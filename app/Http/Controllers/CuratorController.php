<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\Challenge;

class CuratorController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $challenges = $user->challenges()->withCount('submissions')->latest()->get();
        
        $activeCount = $user->challenges()->where('status', 'open')->count();
        
        $totalSubmissions = $challenges->sum('submissions_count');

        return view('curator.dashboard', compact('user', 'challenges', 'activeCount', 'totalSubmissions'));
    }
}