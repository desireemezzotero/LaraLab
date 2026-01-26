<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load(['users', 'tasks.user', 'publications', 'milestones', 'attachments']);

        /* eturn response()->json($project); */

        return view('projectShow', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
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


    /**
     * Update the specified resource in storage.
     */
    /*  public function update(Request $request, Project $project)
    {

        $user = auth()->user();
        $projectRole = $project->users()->where('user_id', $user->id)->first()?->pivot->project_role;

        if ($user->role !== 'Admin/PI' && $projectRole !== 'Project Manager') {
            abort(403, 'Non hai i permessi per modificare questo progetto.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:active,on_hold,completed',
            'end_date' => 'nullable|date',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $project->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'end_date' => $validated['end_date'],
        ]);

        if ($request->hasFile('attachment')) {

            if ($project->attachment) {
                Storage::disk('public')->delete($project->attachment->file_path);
                $project->attachment->delete();
            }

            $path = $request->file('attachments')->store('attachments', 'public');

            $project->attachment()->create([
                'file_path' => $path,
                'file_name' => $request->file('attachments')->getClientOriginalName(),
            ]);
        }

        return redirect()->route('project.show', $project)->with('success', 'Progetto aggiornato con successo!');
    } */

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

        return redirect()->route('project.show', $project->id)
            ->with('success', 'Progetto e allegati aggiornati con successo!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $user = auth()->user();

        $member = $project->users()->where('user_id', $user->id)->first();
        if ($user->role !== 'Admin/PI' && ($member->pivot->project_role ?? null) !== 'Project Manager') {
            abort(403, 'Non hai i permessi per eliminare questo progetto.');
        }

        foreach ($project->attachments as $attachment) {
            if (Storage::disk('public')->exists($attachment->file_path)) {
                Storage::disk('public')->delete($attachment->file_path);
            }
        }

        $project->attachments()->delete();

        $project->delete();

        return redirect()->route('dashboard')->with('success', 'Progetto e relativi allegati eliminati con successo.');
    }

    public function destroyAttachment(Attachment $attachment)
    {

        $project = $attachment->attachable;
        $user = auth()->user();

        $member = $project->users()->where('user_id', $user->id)->first();
        if ($user->role !== 'Admin/PI' && ($member->pivot->project_role ?? null) !== 'Project Manager') {
            abort(403);
        }

        if (Storage::disk('public')->exists($attachment->file_path)) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        $attachment->delete();

        return redirect()->route('project.edit', $project->id)
            ->with('success', 'Immagine rimossa con successo.');
    }
}
