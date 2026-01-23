<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $user = \App\Models\User::with(['projects', 'publications', 'tasks'])->find($userId);
        if (!$user) {
            return redirect()->route('login');
        }
        return view('dashboard', compact('user'));
    }
}
