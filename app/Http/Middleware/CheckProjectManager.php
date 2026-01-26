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

        // Se non c'è il parametro {project}, controlla se c'è {attachment}
        if (!$project && $request->route('attachment')) {
            $attachment = $request->route('attachment');

            // Se Laravel non ha fatto il binding automatico, cerchiamo l'allegato
            if (!$attachment instanceof \App\Models\Attachment) {
                $attachment = \App\Models\Attachment::findOrFail($attachment);
            }

            // Risaliamo al progetto dall'allegato (relazione polimorfica)
            $project = $attachment->attachable;
        }

        // Se siamo su una rotta che non ha né progetto né allegato, lascia passare
        if (!$project) {
            return $next($request);
        }

        // Se $project è solo un ID (numero), carichiamo il modello
        if (!$project instanceof \App\Models\Project) {
            $project = \App\Models\Project::findOrFail($project);
        }

        // Logica Permessi (Admin o Project Manager)
        if ($user->role === 'Admin/PI') {
            return $next($request);
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
