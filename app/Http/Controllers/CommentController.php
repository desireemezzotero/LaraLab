<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

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
    public function store(Request $request, Task $task)
    {
        $validated = $request->validate([
            'body' => 'required|string|min:1|max:2000',
        ]);

        $task->comments()->create([
            'body' => $validated['body'],
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Commento aggiunto con successo!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Comment $comment)
    {
        $project = $comment->task->project;

        if (!$project) {
            abort(404, 'Impossibile trovare il progetto associato a questo task.');
        }

        // Cerchiamo l'utente loggato nel progetto per vedere che ruolo ha
        $member = $project->users()
            ->where('user_id', auth()->id())
            ->first();

        // Ruolo nella pivot del progetto
        $projectRole = $member ? $member->pivot->project_role : null;

        $isAuthorized = (auth()->user()->role === 'Admin/PI') || ($projectRole === 'Project Manager');

        if (!$isAuthorized) {
            abort(403, 'Accesso negato. Solo l\'Admin o il PM del progetto possono eliminare.');
        }

        $comment->delete();

        return back()->with('success', 'Commento eliminato.');
    }
}
