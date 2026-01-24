<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        /* progetti che hanno come stato on_hold e active */
        $activeProjects = $user->projects()->whereIn('projects.status', ['on_hold', 'active'])->get();

        /* pubblicazioni */
        /*   $pendingPublications =  $user->publications()->whereNotIn('status', ['submitted', 'drafting'])->get(); */

        /* scadenze dei progetti entro 7 giorni */
        $upcomingDeadlines = Project::where('end_date', '<=', now()->addDays(7))
            ->where('end_date', '>=', now())
            ->get();

        /* task per la barra */
        $totalTasks = $user->tasks()->count();
        $completedTasks = $user->tasks()->where('status', 'completed')->count();
        $progressPercentageTasks = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

        /* pubblicazioni per il grafica */
        $totalPubs = $user->publications()->count();
        $publishedCount = $user->publications()->where('status', 'published')->count();
        $progressPercentagePublications = $totalPubs > 0 ? ($publishedCount / $totalPubs) * 100 : 0;

        return view('dashboard', compact(
            'user',
            'activeProjects',
            'upcomingDeadlines',
            'progressPercentageTasks',
            'progressPercentagePublications',
        ));
    }
}
