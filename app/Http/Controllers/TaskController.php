<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task->load(['project', 'milestone', 'user', 'comments.user']);

        return view('showTaskPage', compact('task'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $user = auth()->user();

        // Recuperiamo il progetto tramite la relazione (assicurati di averla nel modello Task)
        $project = $task->project;

        // Recuperiamo il ruolo dell'utente in questo specifico progetto
        $member = $project->users()->where('user_id', $user->id)->first();
        $projectRole = $member ? $member->pivot->project_role : null;

        return view('editTaskPage', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Task $task)
    {
        $userProjectRole = $task->project->users()
            ->where('user_id', auth()->id())
            ->first()?->pivot->project_role;

        $isManager = auth()->user()->role === 'Admin/PI' || $userProjectRole === 'Project Manager';

        if ($isManager) {
            // Il PM può modificare tutto
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'required|in:to_do,in_progress,completed',
                'tag' => 'nullable|string',
            ]);
        } else {
            // Il Collaborator/Research può modificare SOLO lo stato
            $validated = $request->validate([
                'status' => 'required|in:to_do,in_progress,completed',
            ]);
        }

        $task->update($validated);

        return redirect()->route('task.show', $task->id)->with('success', 'Task aggiornato!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
