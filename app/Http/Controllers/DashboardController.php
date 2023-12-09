<?php

namespace App\Http\Controllers;

use App\Enums\ResearchStatusType;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Course;
use App\Models\ResearchPaper;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $isAdmin = $user->hasRole('admin');
        $isStudent = $user->hasRole('student');
        $isPanel = $user->hasRole('panel');
        $isFaculty = $user->hasRole('faculty');
    
        $data = [];
    
        if ($isAdmin) {
            $data['users'] = $this->getUserStatistics()['total_users'];
            $data['pendingUsers'] = $this->getUserStatistics()['pending_users'];
            $data['userPerCourse'] = $this->getUserPerCourse();
            $data['submissions'] = ResearchPaper::with('author', 'author.course', 'author.form', 'adviser', 'panelMembers')
                ->where('for_scheduling', true)
                ->orWhere(function($q) {
                    $q->whereIn('status', ['quality_checking', 'final_submission', 'completed', 'final_defense', 'title_defense', 'outline_defense'])
                        ->where('for_scheduling', false);
                })
                ->get();
    
            $data['total_submissions'] = ResearchPaper::with('author', 'author.course', 'author.form')
                ->where('is_approved_by_adviser', true)
                ->get();
    
            $data['announcements'] = Announcement::where('is_active', true)->with('user')->get();
            $data['courses'] = Course::all();
            $data['test'] = [];
            $view = 'Dashboard';
        } elseif ($isStudent) {
            $data['announcements'] = Announcement::where('is_active', true)->with('user')->get();
            $view = 'StudentDashboard';
        } elseif ($isPanel) {
            $data['announcements'] = Announcement::where('is_active', true)->with('user')->get();
            $view = 'PanelDashboard';
        } else {
            $data['announcements'] = Announcement::where('is_active', true)->with('user')->get();
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
                    "value" => $courses->sum('users_count'),
                    "color" => "#af2532"
                ];
            })
            ->values()
            ->toArray(); 
    }

    public function showUsers(Request $request)
    {

        $users = User::query()->whereDoesntHave('roles', function ($query) {
            $query->whereIn('name', ['admin', ]);
        })->with('course')->when($request->search, function($q, $search){
            $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('id_number', 'LIKE', "%{$search}%")
                ->orWhere('subject_code', 'LIKE', "%{$search}%")
                ->orWhere('phone_number', 'LIKE', "%{$search}%");
        })->where('is_active', true)->take(10)->get();
        // dd($users);
        return Inertia::render('Admin/Users', [
            'users' => $users
        ]);
    }

    public function showInactiveUsers(Request $request)
    {
        $users = User::query()->whereDoesntHave('roles', function ($query) {
            $query->whereIn('name', ['admin']);
        })->with('course')->when($request->search, function($q, $search){
            $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('id_number', 'LIKE', "%{$search}%")
                ->orWhere('subject_code', 'LIKE', "%{$search}%")
                ->orWhere('phone_number', 'LIKE', "%{$search}%");
        })->where('is_active', false)->get()->toArray();

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
