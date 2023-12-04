<?php

namespace App\Http\Controllers;

use App\Enums\ResearchStatusType;
use App\Events\ActivityLogged;
use App\Events\SchedulePlotted;
use App\Models\DefenseSchedule;
use App\Models\ResearchPaper;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Notifications\DefenseScheduleNotification;
use DateTime;
use Illuminate\Support\Facades\DB;

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
        return ResearchPaper::with('author')->where('for_scheduling', true)->get();
    }

    public function plotResearchSchedule(Request $request, ResearchPaper $researchPaper)
    { 
        try {
            if($researchPaper->author->degree_type == 'masteral' && $researchPaper->panelMembers->count() < 4){
                return response()->json([
                    'message' => 'Please add panel members first before plotting a schedule.'
                ], 422);

            } else if($researchPaper->author->degree_type == 'doctoral' && $researchPaper->panelMembers->count() < 5){
                return response()->json([
                    'message' => 'Please add panel members first before plotting a schedule.'
                ], 422);
            }

            DB::beginTransaction();
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
            
            // $this->triggerSMSForStudent($researchPaper);
            ActivityLogged::dispatch(auth()->user(), 'Defense schedule plotted for research title: ' . $researchPaper->title . ' by ' . auth()->user()->name . ' on ' . now()->format('M d, Y h:i A'));
            DB::commit();
            // return redirect()->back();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function getSchedules()
    {
        return DefenseSchedule::with('researchPaper','researchPaper.author', 'researchPaper.adviser')->get();
    }

    public function deleteSchedule(DefenseSchedule $defenseSchedule)
    {
        $defenseSchedule->delete();
        $defenseSchedule->researchPaper->author->notify(new DefenseScheduleNotification($defenseSchedule->researchPaper->author, 'Admin deleted your recent defense schedule.'));

        ActivityLogged::dispatch(auth()->user(), 'Defense schedule deleted for research title: ' . $defenseSchedule->researchPaper->title . ' by ' . auth()->user()->name . ' on ' . now()->format('M d, Y h:i A'));

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


    public function approvePaperForChecking(ResearchPaper $researchPaper, Request $request)
    {
        $researchPaper->update([
            'status' => $request->status
        ]);
        return redirect()->back();
    }

    public function updateFinalPaperChecklist(ResearchPaper $researchPaper, Request $request)
    {
        $updateData = [];
        // Check if the checkbox is checked
        if ($request->checked) {
            // Only update the specified field if the checkbox is checked
            switch ($request->status) {
                case 'has_submitted_manuscript':
                    $updateData['has_submitted_manuscript'] = true;
                    ActivityLogged::dispatch(auth()->user(), 'Admin checked the manuscript submitted for research: '.$researchPaper->title.'  on ' . now()->format('M d, Y h:i A'));
                    break;
                case 'has_submitted_cd':
                    $updateData['has_submitted_cd'] = true;
                    ActivityLogged::dispatch(auth()->user(), 'Admin checked the cd submitted for research: '.$researchPaper->title.'  on ' . now()->format('M d, Y h:i A'));
                    break;
                case 'has_submitted_final_receipt':
                    $updateData['has_submitted_final_receipt'] = true;
                    ActivityLogged::dispatch(auth()->user(), 'Admin checked the final receipt submitted for research: '.$researchPaper->title.'  on ' . now()->format('M d, Y h:i A'));
                    break;
                case 'has_submitted_printed_materials':
                    $updateData['has_submitted_printed_materials'] = true;
                    ActivityLogged::dispatch(auth()->user(), 'Admin checked the printed materials submitted for research: '.$researchPaper->title.'  on ' . now()->format('M d, Y h:i A'));
                    break;
                // case 'has_paid_final_adviser_fee':
                //     $updateData['has_paid_final_adviser_fee'] = true;
                //     ActivityLogged::dispatch(auth()->user(), 'Admin checked the submitted final advisers fee for research: '.$researchPaper->title.'  on ' . now()->format('M d, Y h:i A'));
                //     break;
                default:
             
                    break;
            }
        } else {
            // Handle the case where the checkbox is unchecked
            switch ($request->status) {
                case 'has_submitted_manuscript':
                    $updateData['has_submitted_manuscript'] = false;
                    ActivityLogged::dispatch(auth()->user(), 'Admin unchecked the manuscript submitted for research: '.$researchPaper->title.'  on ' . now()->format('M d, Y h:i A'));
                    break;
                case 'has_submitted_cd':
                    $updateData['has_submitted_cd'] = false;
                    ActivityLogged::dispatch(auth()->user(), 'Admin unchecked the cd submitted for research: '.$researchPaper->title.'  on ' . now()->format('M d, Y h:i A'));
                    break;
                case 'has_submitted_final_receipt':
                    $updateData['has_submitted_final_receipt'] = false;
                    ActivityLogged::dispatch(auth()->user(), 'Admin unchecked the final receipt submitted for research: '.$researchPaper->title.'  on ' . now()->format('M d, Y h:i A'));
                    break;
                case 'has_submitted_printed_materials':
                    $updateData['has_submitted_printed_materials'] = false;
                    ActivityLogged::dispatch(auth()->user(), 'Admin unchecked the printed materials submitted for research: '.$researchPaper->title.'  on ' . now()->format('M d, Y h:i A'));
                    break;
                case 'has_paid_final_adviser_fee':
                    $updateData['has_paid_final_adviser_fee'] = false;
                    $researchPaper->update(['status' => ResearchStatusType::FINAL_SUBMISSION]);
                    ActivityLogged::dispatch(auth()->user(), 'Admin unchecked the printed materials submitted for research: '.$researchPaper->title.'  on ' . now()->format('M d, Y h:i A'));
                    break;
                default:
            
                    break;
            }
        }
        
        if (!empty($updateData)) {
            $researchPaper->update($updateData);
            $this->finalPaperChecklist($researchPaper) ? $researchPaper->update(['status' => ResearchStatusType::COMPLETED]) : $researchPaper->update(['status' => ResearchStatusType::FINAL_SUBMISSION]);
        }
    }

    public function addFinalAdviserFeeReciept(Request $request, ResearchPaper $researchPaper)
    {
        if (
            $researchPaper->has_submitted_manuscript == true
            && $researchPaper->has_submitted_cd == true
            && $researchPaper->has_submitted_final_receipt == true
            && $researchPaper->has_submitted_printed_materials == true
        ) {
            $request->validate([
                'reference_number' => 'required',
                'amount' => 'required',
                'date' => 'required',
            ]);
            $researchPaper->update([
                'has_paid_final_adviser_fee' => true,
                'status' => ResearchStatusType::COMPLETED
            ]);
    
            $receipt = $researchPaper->receipts()->create([
                'user_id' => $researchPaper->author->id,
                'amount' => $request->amount,
                'reference_number' => $request->reference_number,
                'stage_submitted' => 'final_submission',
                'date_submitted' => $request->date,
                'is_approved' => true,
            ]);
            ActivityLogged::dispatch(auth()->user(), 'Admin added adviser final fee for the paper: '.$researchPaper->title.'  on ' . now()->format('M d, Y h:i A'));

        } else {
            return response()->json([
                'message' => 'Please check all the checkboxes first before submitting the final adviser fee.'
            ], 422);
        }

    }

    private function finalPaperChecklist($researchPaper)
    {
        if (
            $researchPaper->has_submitted_manuscript == true
            && $researchPaper->has_submitted_cd == true
            && $researchPaper->has_submitted_final_receipt == true
            && $researchPaper->has_submitted_printed_materials == true
            && $researchPaper->has_paid_final_adviser_fee == true
        ) {
            return true;
        }
    }

    public function showArchivedPapers()
    {
        return Inertia::render('Admin/Submissions/ArchivedSubmissions', [
            'papers' => ResearchPaper::where('status', ResearchStatusType::ARCHIVED)->with('author', 'author.course', 'author.form', 'adviser', 'panelMembers')->get()
        ]);
    }
}
