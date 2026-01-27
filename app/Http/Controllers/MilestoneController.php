<?php

namespace App\Http\Controllers;

use App\Models\Milestone;
use App\Models\Project;
use Illuminate\Http\Request;

class MilestoneController extends Controller
{
    public function create(Project $project)
    {
        return view('createMilestonePage', compact('project'));
    }

    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title'    => 'required|string|max:255',
            'due_date' => 'required|date',
            'status'   => 'required|boolean',
        ]);

        $project->milestones()->create($validated);

        return redirect()->route('project.show', $project)
            ->with('success', 'Nuova milestone aggiunta con successo!');
    }


    public function edit(Milestone $milestone)
    {
        return view('editMilestonePage', compact('milestone'));
    }


    public function update(Request $request, Milestone $milestone)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'due_date' => 'required|date',
            'status' => 'required|boolean',
        ]);

        $milestone->update($validated);

        return redirect()->route('project.show', $milestone->project_id)
            ->with('success', 'Milestone aggiornata!');
    }

    public function destroy(Milestone $milestone)
    {
        $projectId = $milestone->project_id;

        $milestone->delete();

        return redirect()
            ->route('project.show', $projectId)
            ->with('success', 'Milestone eliminata definitivamente.');
    }
}
