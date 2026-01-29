<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{

    public function index() {}

    /* FORM DI AGGIUNTA DI UN PROGETTO */
    public function create(Request $request)
    {
        $publicationId = $request->query('publication_id');
        $users = User::all();
        return view('projectCreate', compact('publicationId', 'users'));
    }

    /* AGGIUNTA DI UN PROGETTO */
    public function store(Request $request)
    {
        // 2. Controllo di sicurezza anche in fase di salvataggio
        if (auth()->user()->role !== 'Admin/PI') {
            abort(403, 'Azione non autorizzata.');
        }

        // 3. Validazione
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'objectives' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:active,on_hold,completed',
            'publication_id' => 'nullable|exists:publications,id',
            'users' => 'required|array|min:2', // Almeno un utente deve essere assegnato
            'users.*' => 'exists:users,id',
            'project_roles' => 'required|array',
            'attachments.*' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
        ]);

        // 4. Creazione Progetto
        $project = Project::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'objectives' => $validated['objectives'],
            'status' => $validated['status'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
        ]);

        // 5. Associazione Team con Ruoli Pivot
        $syncData = [];
        foreach ($validated['users'] as $userId) {
            $role = $request->project_roles[$userId] ?? 'Member';
            $syncData[$userId] = ['project_role' => $role];
        }
        $project->users()->attach($syncData);

        // 6. Associazione Pubblicazione (se presente)
        if ($validated['publication_id']) {
            $project->publications()->attach($validated['publication_id']);
        }

        // 7. Allegati
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments', 'public');
                $project->attachments()->create([
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        // Redirect alla pubblicazione se esistente, altrimenti alla dashboard
        if ($validated['publication_id']) {
            return redirect()->route('publication.show', $validated['publication_id'])
                ->with('success', 'Progetto creato e team assegnato con successo.');
        }

        return redirect()->route('dashboard')->with('success', 'Progetto creato con successo.');
    }


    /* VISTA DEL PROGETTO */
    public function show(Project $project)
    {
        $user = auth()->user();
        $userId = $user->id;

        $project->load(['users', 'tasks.users', 'milestones', 'attachments']);

        //il ruolo nel progetto
        $projectMember = $project->users->where('id', $userId)->first();
        $projectRole = $projectMember ? $projectMember->pivot->project_role : null;
        $isManager = $user->role === 'Admin/PI' || $projectRole === 'Project Manager';

        $allTasks = $project->tasks;

        $myTasks = $allTasks->filter(function ($task) use ($userId) {
            return $task->users->contains($userId);
        });

        $otherTasks = $allTasks->filter(function ($task) use ($userId) {
            return !$task->users->contains($userId);
        });


        return view('projectShow', [
            'project' => $project,
            'myTasks' => $myTasks,
            'otherTasks' => $otherTasks,
            'isManager' => $isManager
        ]);
    }

    /* FORM PER LA MODIFICA DEL PROGETTO */
    public function edit(Project $project)
    {
        $user = auth()->user();

        $project->load('attachments');

        $projectRole = $project->users()->where('user_id', $user->id)->first()?->pivot->project_role;

        if ($user->role !== 'Admin/PI' && $projectRole !== 'Project Manager') {
            abort(403, 'Non sei il Project Manager di questo progetto.');
        }

        return view('editProgectPage', compact('project'));
    }

    /* MODIFICA DEL PROGETTO */
    public function update(Request $request, Project $project)
    {
        $user = auth()->user();

        // Recuperiamo il ruolo dell'utente in QUESTO specifico progetto
        $member = $project->users()->where('user_id', $user->id)->first();
        $projectRole = $member ? $member->pivot->project_role : null;

        // Controllo permessi: passa solo se Admin o se è Project Manager del progetto
        if ($user->role !== 'Admin/PI' && $projectRole !== 'Project Manager') {
            abort(403, 'Non hai i permessi per modificare questo progetto.');
        }

        // Validazione: 'attachments.*' serve per validare ogni singolo file dell'array
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:active,on_hold,completed',
            'end_date' => 'nullable|date',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        // 1. Aggiorna i dati base del progetto
        $project->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'end_date' => $validated['end_date'],
        ]);

        // 2. Gestione caricamento file multipli
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                // Salva il file fisicamente
                $path = $file->store('attachments', 'public');

                // Crea il record nella tabella polimorfica (morphMany)
                $project->attachments()->create([
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        if ($user->role === 'Admin/PI') {
            // Recuperiamo la prima pubblicazione associata a questo progetto
            $publication = $project->publications()->first();

            // Se esiste una pubblicazione correlata, torna lì, altrimenti torna alla dashboard
            if ($publication) {
                return redirect()->route('publication.show', $publication->id)
                    ->with('success', 'Progetto aggiornato. Tornato alla pubblicazione.');
            }

            return redirect()->route('dashboard')->with('success', 'Progetto aggiornato.');
        }

        return redirect()->route('project.show', $project->id)
            ->with('success', 'Progetto e allegati aggiornati con successo!');
    }

    /* RIMOZIONE DEL PROGETTO */
    public function destroy(Project $project)
    {
        $user = auth()->user();

        $isManager = $project->users()->where('user_id', $user->id)->wherePivot('project_role', 'Project Manager')->exists();
        if ($user->role !== 'Admin/PI' && !$isManager) {
            abort(403);
        }

        $publicationId =   $project->publications()->first()?->id;
        // 2. Elimina i file fisici (Solo quelli del PROGETTO)
        foreach ($project->attachments as $attachment) {
            if (Storage::disk('public')->exists($attachment->file_path)) {
                Storage::disk('public')->delete($attachment->file_path);
            }
        }

        $project->users()->detach();
        $project->publications()->detach();
        $project->attachments()->delete();
        $project->delete();

        if ($user->role === 'Admin/PI') {
            return redirect()->route('publication.show', $publicationId)
                ->with('success', 'Progetto eliminato con successo dalla pubblicazione.');
        }

        return redirect()->route('dashboard')->with('success', 'Progetto e relativi allegati eliminati con successo.');
    }


    /* RIMUOVERE GLI ALLEGATI DI UN PROGETTO */

    public function destroyAttachment(Attachment $attachment)
    {
        $user = auth()->user();
        $owner = $attachment->attachable; // Può essere un Project o una Publication

        // 1. Controllo Permessi Dinamico
        if ($user->role !== 'Admin/PI') {
            // Se è un progetto, controlliamo se l'utente è Project Manager
            if ($attachment->attachable_type === \App\Models\Project::class) {
                $member = $owner->users()->where('user_id', $user->id)->first();
                if (($member->pivot->project_role ?? null) !== 'Project Manager') {
                    abort(403);
                }
            } else {
                // Se è una pubblicazione e non sei Admin, non puoi cancellare
                abort(403);
            }
        }

        // 2. Eliminazione Fisica del File
        if (Storage::disk('public')->exists($attachment->file_path)) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        // 3. Eliminazione Record
        $attachment->delete();

        // 4. Redirect Dinamico
        if ($attachment->attachable_type === \App\Models\Project::class) {
            return redirect()->route('project.edit', $owner->id)
                ->with('success', 'Allegato progetto rimosso.');
        }

        return redirect()->route('publication.edit', $owner->id)
            ->with('success', 'Allegato pubblicazione rimosso.');
    }
}
