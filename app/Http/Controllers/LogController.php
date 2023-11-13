<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LogController extends Controller
{
    public function index()
    {
       
        return Inertia::render('Admin/Logs', [
            'logs' => Log::where('user_id', auth()->user()->id)->with('user')->get()
        ]);
    }
}
