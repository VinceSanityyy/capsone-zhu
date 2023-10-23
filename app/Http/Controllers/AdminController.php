<?php

namespace App\Http\Controllers;

use App\Events\SchedulePlotted;
use App\Models\DefenseSchedule;
use App\Models\ResearchPaper;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Notifications\DefenseScheduleNotification;
use DateTime;
class AdminController extends Controller
{
    public function showCalendarAndSchedules()
    {
        $papers = $this->showResearchPaspersForScheduling();

        return Inertia::render('Admin/Calendar',[
            'papers' => $papers,
            'schedules' =>  $this->getSchedules()
        ]);
    }

    private function showResearchPaspersForScheduling()
    {
        // return ResearchPaper::where('for_scheduling', false)->get();
        return ResearchPaper::where('for_scheduling', true)->get();
    }

    public function plotResearchSchedule(Request $request, ResearchPaper $researchPaper)
    { 
        $researchPaper->update([
            'for_scheduling' => true
        ]);

        $researchPaper->defenseSchedules()->create([
            'start' => $request->startStr,
            'end' => $request->endStr,
        ]);

        $researchPaper->author->notify(new DefenseScheduleNotification($researchPaper->author, 'Admin has posted your defense schedule.'));
        $researchPaper->adviser->notify(new DefenseScheduleNotification($researchPaper->adviser, 'Admin has posted a schedule for your advisee'));
        $researchPaper->panelMembers->each(function($panelMember) use ($researchPaper){
            $panelMember->notify(new DefenseScheduleNotification($panelMember, 'Admin has posted a schedule for your panelled paper'));
        });
        
        $this->triggerSMSForStudent($researchPaper);
        return redirect()->back();
    }

    private function getSchedules()
    {
        return DefenseSchedule::with('researchPaper','researchPaper.author', 'researchPaper.adviser')->get();
    }

    public function deleteSchedule(DefenseSchedule $defenseSchedule)
    {
        $defenseSchedule->delete();
        return redirect()->back();
    }

    public function defenseScheduleSetToDone(DefenseSchedule $defenseSchedule)
    {
        $defenseSchedule->update([
            'is_done' => true
        ]);
        return redirect()->back();
    }

    private function triggerSMSForStudent(ResearchPaper $researchPaper)
    {
        $created_at = new DateTime($researchPaper->defenseSchedules->created_at);
        $start = new DateTime($researchPaper->defenseSchedules->start);
        $end = new DateTime($researchPaper->defenseSchedules->end);
        $message = "Admin has posted your defense schedule on " . $created_at->format('M d, Y') . " " . $start->format('h:i A') . ' - ' . $end->format('h:i A');
        
        return SchedulePlotted::dispatch($researchPaper->author, $message);
    }
}
