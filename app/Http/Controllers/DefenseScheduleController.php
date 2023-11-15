<?php

namespace App\Http\Controllers;

use App\Enums\ResearchStatusType;
use App\Events\ActivityLogged;
use App\Models\DefenseSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class DefenseScheduleController extends Controller
{
    public function changeDefenseStatus(DefenseSchedule $defenseSchedule, Request $request)
    {
        
        try {
            DB::beginTransaction();
                
        switch ($defenseSchedule->researchPaper->status) {
            case ResearchStatusType::TITLE_DEFENSE:
                $defenseSchedule->researchPaper->update([
                    'status' => ResearchStatusType::OUTLINE_DEFENSE,
                    'is_approved_by_adviser' => false,
                    'for_scheduling' => false]);
                break;
        
            case ResearchStatusType::OUTLINE_DEFENSE:
                $defenseSchedule->researchPaper->update(['status' => ResearchStatusType::FINAL_DEFENSE,
                'is_approved_by_adviser' => false,
                'for_scheduling' => false]);
                break;
        
            case ResearchStatusType::FINAL_DEFENSE:
                $defenseSchedule->researchPaper->update(['status' => ResearchStatusType::FINAL_REVISION,
                'is_approved_by_adviser' => false,
                'for_scheduling' => false]);
                break;
        
            // case ResearchStatusType::FINAL_REVISION:
            //     $defenseSchedule->researchPaper->update(['status' => ResearchStatusType::QUALITY_CHECKING]);
            //     break;
            
            // case ResearchStatusType::FINAL_CHECKING:
            //     $defenseSchedule->researchPaper->update(['status' => ResearchStatusType::FINAL_SUBMISSION]);
            //     break;
        
            default:
                dd('error');
                break;
        }
        

        $defenseSchedule->update([
            'is_done' => $request->status
        ]);
        $defenseSchedule->researchPaper->latestReceipt->update([
            'is_approved' => true
        ]);
        $defenseSchedule->researchPaper->update([
            'for_scheduling' => $request->status == 1 ? false : true
        ]);
        ActivityLogged::dispatch(auth()->user(), 'Defense status changed for research title: ' . $defenseSchedule->researchPaper->title . ' by ' . auth()->user()->name . ' on ' . now()->format('M d, Y h:i A'));
        DB::commit();
        return redirect()->back();

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
