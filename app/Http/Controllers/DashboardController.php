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
        $completedProjects = $user->projects()->whereIn('projects.status', ['completed'])->get();

        /* scadenze dei progetti entro 7 giorni */
        $upcomingDeadlines = $user->projects()
            ->where('end_date', '<=', now()->addDays(7))
            ->where('end_date', '>=', now())
            ->get();

        /* task per la barra */
        $totalTasks = $user->tasks()->count();
        $completedTasks = $user->tasks()->where('status', 'completed')->count();
        $progressPercentageTasks = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

        /* pubblicazioni che hanno come stato submitted e drafting */
        $publicationCount = $user->publications()->whereIn('status', ['submitted', 'drafting'])->get();

        return view('dashboard', compact(
            'user',
            'activeProjects',
            'completedProjects',
            'upcomingDeadlines',
            'progressPercentageTasks',
            'publicationCount',
        ));
    }
}
