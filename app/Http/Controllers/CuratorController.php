<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CuratorController extends Controller
{
    public function index()
    {
        return view('curator.dashboard');
    }
}