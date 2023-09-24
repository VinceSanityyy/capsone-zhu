<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Course;
use App\Models\ResearchPaper;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $isAdmin = auth()->user()->hasRole('admin');
        $isStudent = auth()->user()->hasRole('student');
        $submissions = ResearchPaper::with('user', 'user.course', 'user.form')
        ->when($request->status, function ($q, $search) {
            $q->where('title', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%");
        })
        ->when($request->degree_type, function ($q, $degreeType) {
            $q->whereHas('user', function ($userQuery) use ($degreeType) {
                $userQuery->where('degree_type', $degreeType);
            });
        })
        ->get();
        $total_submissions = ResearchPaper::with('user', 'user.course', 'user.form')->get();
        $data = [];
        
        if ($isAdmin) {
            $data['users'] = $this->getUserStatistics()['total_users']; // Pass users only if admin
            $data['pendingUsers'] = $this->getUserStatistics()['pending_users'];
            $data['userPerCourse'] = $this->getUserPerCourse();
            $data['submissions'] = $submissions;
            $data['total_submissions'] = $total_submissions;
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

    public function showUsers(Request $request)
    {

        $users = User::query()->whereDoesntHave('roles', function ($query) {
            $query->whereIn('name', ['admin', 'faculty']);
        })->with('course')->when($request->search, function($q, $search){
            $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('id_number', 'LIKE', "%{$search}%")
                ->orWhere('subject_code', 'LIKE', "%{$search}%")
                ->orWhere('phone_number', 'LIKE', "%{$search}%");
        })->where('is_active', true)->get()->toArray();
        // dd($users);
        return Inertia::render('Admin/Users', [
            'users' => $users
        ]);
    }

    public function showInactiveUsers(Request $request)
    {
        $users = User::query()->whereDoesntHave('roles', function ($query) {
            $query->whereIn('name', ['admin', 'faculty']);
        })->with('course')->when($request->search, function($q, $search){
            $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('id_number', 'LIKE', "%{$search}%")
                ->orWhere('subject_code', 'LIKE', "%{$search}%")
                ->orWhere('phone_number', 'LIKE', "%{$search}%");
        })->where('is_active', false)->get()->toArray();
        // dd($users);
        return Inertia::render('Admin/InactiveUsers', [
            'users' => $users
        ]);
    }

    public function dataTableFilter(Request $request)
    {

        $submissions = ResearchPaper::where('status', 'LIKE', "%{$request->status}%")
            ->with('user', 'user.course', 'user.form')->get();
      
        return response()->json($submissions);
    }
}
