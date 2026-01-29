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
        //
    }

    /* CREARE UNA NUOVA PUBBLCIAZIONE */
    public function store(Request $request)
    {
        //
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
