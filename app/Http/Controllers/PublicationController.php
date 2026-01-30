<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    /* TUTTE LE PUBBLICAZIONI */
    public function index()
    {

        $publicationPublished = \App\Models\Publication::with(['authors', 'attachments'])
            ->where('status', 'published')
            ->latest()
            ->get();

        return view('welcome', compact('publicationPublished'));
    }

    public function indexAdmin()
    {
        $user = auth()->user();

        $stats = [
            'projects' => \App\Models\Project::count(), // Tutti i progetti
            'projects_completed' => \App\Models\Project::where('status', 'completed')->count(),
            'tasks' => \App\Models\Task::count(),
            'tasks_completed' => \App\Models\Task::where('status', 'completed')->count(),
            'users' => \App\Models\User::count(),
            'attachments' => \App\Models\Attachment::count(),
        ];

        $publications = \App\Models\Publication::with(['projects', 'authors'])->latest()->get();
        $projectsList = \App\Models\Project::latest()->get();

        return view('dashboardPublicationAdmin', compact('stats', 'projectsList', 'publications'));
    }


    /*   FORM PER NUOVA PUBBLICAZIONE */
    public function create()
    {
        if (auth()->user()->role !== 'Admin/PI') {
            abort(403);
        }

        $users = \App\Models\User::all();
        return view('publishCreate', compact('users'));
    }

    /* CREARE UNA NUOVA PUBBLICAZIONE */
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'Admin/PI') {
            abort(403);
        }

        // Validazione
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:drafting,submitted,accepted,published',
            'authors' => 'required|array|min:1',
            'authors.*' => 'exists:users,id',
            'positions' => 'required|array',
            'attachments.*' => 'nullable|file|mimes:pdf,jpg,png,docx|max:5120',
        ]);

        // Creazione Pubblicazione
        $publication = Publication::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
        ]);

        // preparare i dati della pivot
        $authorData = [];
        foreach ($validated['authors'] as $userId) {
            $authorData[$userId] = ['position' => $validated['positions'][$userId] ?? 1];
        }
        $publication->authors()->attach($authorData);

        // Gestione Allegati 
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('publications_files', 'public');
                $publication->attachments()->create([
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        return redirect()->route('publication.show', $publication->id)
            ->with('success', 'Pubblicazione creata con successo!');
    }

    /* VISUALIZZAZIONE DI UNA PUBBLICAZIONE */
    public function show(Publication $publication)
    {
        $user = auth()->user();

        // 1. Caricamento base comune a tutti (Autori e Allegati)
        $relations = ['authors', 'attachments'];

        // 2. Se l'utente è Admin/PI, carichiamo ANCHE i progetti
        if ($user && $user->role === 'Admin/PI') {
            $relations[] = 'projects';
        }

        $publication->load($relations);

        // 3. Restituiamo SEMPRE la vista (indipendentemente dal ruolo)
        return view('publishDetail', compact('publication'));
    }



    public function edit(Publication $publication)
    {
        $user = auth()->user();
        $isAuthor = $publication->authors->contains($user->id);

        if (auth()->user()->role !== 'Admin/PI' && !($user->role === 'Researcher' && $isAuthor)) {
            abort(403);
        }

        $users = \App\Models\User::all();

        $currentAuthors = $publication->authors->pluck('id')->toArray();

        return view('publicationEdit', compact('publication', 'users', 'currentAuthors'));
    }


    public function update(Request $request, Publication $publication)
    {
        $user = auth()->user();
        $isAdmin = $user->role === 'Admin/PI';
        $isAuthor = $publication->authors->contains($user->id);

        // Controllo sicurezza base
        if (!$isAdmin && !($user->role === 'Researcher' && $isAuthor)) {
            abort(403);
        }

        if (!$isAdmin) {
            $validated = $request->validate([
                'status' => 'required|in:drafting,submitted,accepted,published',
            ]);
            $publication->update(['status' => $validated['status']]);
        } else {
            // Logica completa per l'ADMIN (quella che avevi già)
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'status' => 'required|in:drafting,submitted,accepted,published',
                'authors' => 'required|array|min:1',
                'positions' => 'required|array',
                'attachments.*' => 'nullable|file|mimes:pdf,jpg,png,docx|max:5120',
            ]);

            $publication->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'status' => $validated['status'],
            ]);

            $syncData = [];
            foreach ($validated['authors'] as $userId) {
                $syncData[$userId] = ['position' => $validated['positions'][$userId] ?? 1];
            }
            $publication->authors()->sync($syncData);

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('publications_files', 'public');
                    $publication->attachments()->create([
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                    ]);
                }
            }
        }

        return redirect()->route('publication.show', $publication->id)
            ->with('success', 'Aggiornamento completato!');
    }

    /* ELIMINAZIONE DELLA PUBBLICAZIONE */
    public function destroy(Publication $publication)
    {
        if (auth()->user()->role !== 'Admin/PI') {
            abort(403, 'Azione non autorizzata. Solo il Principal Investigator può eliminare le pubblicazioni.');
        }
        $publication->projects()->detach();
        $publication->delete();

        return redirect()->route('publication.index')->with('success', 'Pubblicazione eliminata con successo.');
    }
}
