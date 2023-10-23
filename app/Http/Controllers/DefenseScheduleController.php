<?php

namespace App\Http\Controllers;

use App\Models\DefenseSchedule;
use Illuminate\Http\Request;

class DefenseScheduleController extends Controller
{
    public function changeDefenseStatus(DefenseSchedule $defenseSchedule, Request $request)
    {
      
        $defenseSchedule->update([
            'is_done' => $request->status
        ]);

        $defenseSchedule->researchPaper->update([
            'for_scheduling' => $request->status == 1 ? false : true
        ]);

        return redirect()->back();
    }
}
