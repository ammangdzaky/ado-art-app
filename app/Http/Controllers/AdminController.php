<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Report;
use App\Models\Artwork;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $pendingCurators = User::where('role', 'curator')->where('status', 'pending')->count();
        $pendingReports = Report::where('status', 'pending')->count();
        $totalUsers = User::count();
        $totalArtworks = Artwork::count();

        return view('admin.dashboard', compact('pendingCurators', 'pendingReports', 'totalUsers', 'totalArtworks'));
    }

    public function users()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function approveCurator(User $user)
    {
        if ($user->role !== 'curator') abort(404);
        
        $user->update(['status' => 'active']);
        return back()->with('success', 'Curator approved successfully.');
    }

    public function deleteUser(User $user)
    {
        if ($user->role === 'admin') return back()->with('error', 'Cannot delete admin.');
        
        $user->delete();
        return back()->with('success', 'User deleted.');
    }

    public function reports()
    {
        $reports = Report::with(['reporter', 'artwork'])->where('status', 'pending')->latest()->get();
        return view('admin.reports.index', compact('reports'));
    }

    public function handleReport(Request $request, Report $report)
    {
        $action = $request->input('action'); // 'dismiss' or 'takedown'

        if ($action === 'takedown') {
            $report->artwork->delete(); // Soft delete or hard delete artwork
            $report->update(['status' => 'resolved']);
            return back()->with('success', 'Content taken down and report resolved.');
        } 
        
        if ($action === 'dismiss') {
            $report->update(['status' => 'dismissed']);
            return back()->with('success', 'Report dismissed.');
        }

        return back();
    }
}