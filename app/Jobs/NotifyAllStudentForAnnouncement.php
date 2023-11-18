<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Notifications\AnnouncementCreated;

class NotifyAllStudentForAnnouncement implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $title;
    public function __construct($title)
    {
        $this->title = $title;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $students = User::role('student')->get();
        foreach ($students as $student) {
            $student->notify(new AnnouncementCreated($this->title));
        }
    }
}
