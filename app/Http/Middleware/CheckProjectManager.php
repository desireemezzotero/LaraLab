<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProjectManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        $project = $request->route('project');

        /* CARICAMENTO DEGLI ALLEGATI  */
        if (!$project && $request->route('attachment')) {
            $attachment = $request->route('attachment');
            if (!$attachment instanceof \App\Models\Attachment) {
                $attachment = \App\Models\Attachment::findOrFail($attachment);
            }
            $project = $attachment->attachable;
        }

        /* CARICAMENTO DEI MILESTONI */
        if (!$project && $request->route('milestone')) {
            $milestone = $request->route('milestone');

            if (!$milestone instanceof \App\Models\Milestone) {
                $milestone = \App\Models\Milestone::findOrFail($milestone);
            }
            $project = $milestone->project;
        }


        if (!$project) {
            return $next($request);
        }

        if (!$project instanceof \App\Models\Project) {
            $project = \App\Models\Project::findOrFail($project);
        }

        /* SE E' ADMIN PU0' FARE TUTTO */
        if ($user->role === 'Admin/PI') {
            return $next($request);
        }

        if ($request->isMethod('DELETE')) {
            $routeName = $request->route()->getName();

            if ($routeName === 'project.destroy') {
                abort(403, "Solo il PI (Admin) può eliminare un intero progetto.");
            }
        }

        $isManager = $project->users()
            ->where('user_id', $user->id)
            ->wherePivot('project_role', 'Project Manager')
            ->exists();

        if (!$isManager) {
            abort(403, "Non hai i permessi per questo progetto.");
        }


        return $next($request);
    }
}
