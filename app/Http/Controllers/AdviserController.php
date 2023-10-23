<?php

namespace App\Http\Controllers;

use App\Enums\ResearchStatusType;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use App\Notifications\CommentAddedNotification;
use App\Notifications\ResearchStatusChanged;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
class AdviserController extends Controller
{
    public function getAssignedStudents()
    {
        $assignedPapers = auth()->user()->adviserPaper()->get();
        return Inertia::render('Adviser/AdvisedPapers',[
            'assignedPapers' => $assignedPapers->load('author','adviser','panelMembers')
        ]);
    }

    public function showAssignedPaper(Request $request)
    {
        $paper = auth()->user()->adviserPaper()->where('id', $request->id)->first();
        $paper->load('author', 'adviser', 'panelMembers');
        $panelMemberComments = $paper->panelMemberComments();
        $adviserComments = $paper->adviserComments();
        
        return Inertia::render('Adviser/ShowAdvisedPaper',[
            'paper' => $paper,
            'panelMemberComments' => $panelMemberComments,
            'adviserComments' => $adviserComments,
            'attachedEndorsementFromStudent' => $paper->attachedEndorsmentFiles($paper->author->id),
        ]);
    }

    public function addAdviserComment(Request $request)
    {
        $request->validate([
            'comment' => 'required'
        ]);
        $paper = auth()->user()->adviserPaper()->where('id', $request->id)->first();
        $paper->comments()->create([
            'comment' => $request->comment,
            'user_id' => auth()->user()->id
        ]);
        $paper->author->notify(new CommentAddedNotification(auth()->user()));

        return redirect()->back();
    }

    public function approvePaper(Request $request)
    {
        
        $paper = auth()->user()->adviserPaper()->where('id', $request->id)->first();
        $newStatus = '';
        if ($paper->status === ResearchStatusType::FINAL_DEFENSE) {
            $newStatus = ResearchStatusType::FINAL_CHECKING;
        } elseif ($paper->status === ResearchStatusType::FINAL_CHECKING) {
            $newStatus = ResearchStatusType::QUALITY_CHECKING;
        } else{
            $newStatus = $paper->status;
        }

        $paper->update([
            'is_approved_by_adviser' => true,
            'status' => $newStatus
        ]);

        if($paper->wasChanged()){
            $paper->endorsement()->create([
                'file_path' => url(Config::get('app.url') . Storage::url($request->file('file')->store('endorsements', 'public'))),
                'stage_submitted' => $paper->status,
                'user_id' => auth()->user()->id,
            ]);
            $paper->update([
                'for_scheduling' => true
            ]);
        }
        $paper->author->notify(new ResearchStatusChanged($paper->author, $newStatus));

        return redirect()->back();
    }

    public function declinePaper(Request $request)
    {
        $paper = auth()->user()->adviserPaper()->where('id', $request->id)->first();
        $paper->update([
            'is_approved_by_adviser' => false
        ]);
        return redirect()->back();
    }
}
