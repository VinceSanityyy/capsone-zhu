<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Course;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $isAdmin = auth()->user()->hasRole('admin');
        $isStudent = auth()->user()->hasRole('student');
        $data = [];
    
        if ($isAdmin) {
            $data['users'] = $this->getUserStatistics()['total_users']; // Pass users only if admin
            $data['pendingUsers'] = $this->getUserStatistics()['pending_users'];
            $data['userPerCourse'] = $this->getUserPerCourse();
            $view = 'Dashboard';
        } elseif ($isStudent) {
            $view = 'StudentDashboard';
        } else {
            $view = 'FacultyDashboard';
        }
    
        return Inertia::render($view, $data);
    }

    private function getUserStatistics()
    {
        return [
            'total_users' => User::whereDoesntHave('roles', function ($query) {
                $query->where('name', 'admin');
            })->get(),
            'pending_users' => User::where('is_active', false)->count(),
        ];
    }

    private function getUserPerCourse()
    {
        return Course::withCount('users')
            ->get()
            ->groupBy('name') // Group by course name
            ->map(function ($courses) {
                return [
                    "label" => ucwords(strtolower($courses->first()->name)),
                    "value" => $courses->sum('users_count')
                ];
            })
            ->values()
            ->toArray(); 
    }
}
