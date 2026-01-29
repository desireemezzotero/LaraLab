<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    /* TUTTE LE PUBBLICAZIONI */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // 2. CASO: ADMIN (VEDE TUTTO SENZA FILTRI)
        if ($user->role === 'Admin/PI') {
            $stats = [
                'projects' => \App\Models\Project::count(), // Tutti i progetti
                'projects_completed' => \App\Models\Project::where('status', 'completed')->count(),
                'tasks' => \App\Models\Task::count(),
                'tasks_completed' => \App\Models\Task::where('status', 'completed')->count(),
                'users' => \App\Models\User::count(),
                /* 'publications' => \App\Models\Publication::with(['projects', 'authors'])->get(), */
                'attachments' => \App\Models\Attachment::count(),
            ];

            $publications = \App\Models\Publication::with(['projects', 'authors'])->latest()->get();
            $projectsList = \App\Models\Project::latest()->get();

            return view('dashboardPublicationAdmin', compact('stats', 'projectsList', 'publications'));
        } elseif (!auth()->check()) {
            $publicationPublished = \App\Models\Publication::with(['authors'])
                ->where('status', 'published')
                ->latest()
                ->get();

            return view('welcome', compact('publicationPublished'));
        }
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

        // 2. Poi fai il ciclo solo per preparare i dati della pivot
        $authorData = [];
        foreach ($validated['authors'] as $userId) {
            $authorData[$userId] = ['position' => $validated['positions'][$userId] ?? 1];
        }
        $publication->authors()->attach($authorData);

        // Gestione Allegati (Polimorfica)
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

        if ($user->role === 'Admin/PI') {
            $publication->load(['projects', 'authors', 'attachments']);

            return view('publishDetail', compact('publication'));
        } elseif (!auth()->check()) {
            $publication->load(['authors', 'attachments']);


            return view('publishDetail', compact('publication'));
        }
    }



    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
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
