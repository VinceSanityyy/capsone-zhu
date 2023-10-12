<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Notifications\AnnouncementCreated;
use App\Models\User;
class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $announcements = Announcement::with('user')
            ->orderBy('id', 'desc')
            ->get();
        return Inertia::render('Admin/Announcements',
            ['announcements' => $announcements]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/CreateAnnouncement');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => ['required', 'string'],
            'content' => ['required', 'string'],
        ]);

        Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->user()->id,
        ]);

        $this->sendNotificationsToStudents($request->title);
        
        return to_route('announcement.index');
    }

    private function sendNotificationsToStudents($title)
    {
        $students = User::role('student')->get();
        foreach ($students as $student) {
            $student->notify(new AnnouncementCreated($title));
        }
    }
}
