<?php

namespace App\Http\Controllers;

use App\Enums\ResearchStatusType;
use App\Events\ActivityLogged;
use App\Models\ResearchPaper;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Notifications\CommentAddedNotification;
use App\Notifications\ResearchStatusChanged;
use Illuminate\Support\Facades\DB;
class ResearchPaperController extends Controller
{

    public function show(ResearchPaper $researchPaper)
    {
   
        $researchPaper->load('author', 'adviser', 'panelMembers', 'defenseSchedules');
        // $panelMemberComments = $researchPaper->panelMemberComments();
        // $adviserComments = $researchPaper->adviserComments();
        $adminComments = $researchPaper->adminComments();
        $panelRole = Role::where('name', 'panel')->first();
        $panelMembers = User::role($panelRole)->get();

        return Inertia::render('Admin/Submissions/Show', [
            'researchPaper' => $researchPaper,
            // 'panelMemberComments' => $panelMemberComments,
            // 'adviserComments' => $adviserComments,
            'panelMembers' => $panelMembers,
            'adminComments' => $adminComments,
            'adviserEndorsementForms' => $researchPaper->endorsement()->where('user_id', $researchPaper->adviser->id)->get(),
            'panelMemberEvaluationForms' => $researchPaper->evaluationForms()->whereIn('user_id', $panelMembers->pluck('id')->toArray())->get(),
            'panelMemberComments' => $researchPaper->panelMemberComments() ?? null,
            'adviserComments' => $researchPaper->adviserComments() ?? null,
            'receipts' => $researchPaper->receipts,
        ]);
    }

    public function addPanelMembers(ResearchPaper $researchPaper, Request $request)
    {
        $requiredPanelMembersCount = $researchPaper->author->degree_type === 'masteral' ? 4 : 5;

        $request->validate([
            'panels' => 'required|array|size:' . $requiredPanelMembersCount
        ]);
        // $researchPaper->panelMembers()->sync($request->panels);
        $researchPaper->panelMembers()->sync($request->panels);

        ActivityLogged::dispatch(auth()->user(), 'Admin added panel members for research title: ' . $researchPaper->title . ' on ' . now()->format('M d, Y h:i A'));
        return to_route('admin.research-paper.show', $researchPaper->id);
    }

    public function addAdminComment(Request $request, ResearchPaper $researchPaper)
    {
        $request->validate([
            'comment' => 'required'
        ]);
        $paper = $researchPaper;
        
        $paper->comments()->create([
            'comment' => $request->comment,
            'user_id' => auth()->user()->id
        ]);
        $paper->author->notify(new CommentAddedNotification(auth()->user()));
        ActivityLogged::dispatch(auth()->user(), 'Admin commented for research title: '.$researchPaper->title.'  on ' . now()->format('M d, Y h:i A'));
        return redirect()->back();
    }

    public function changeResearchStatus(Request $request, ResearchPaper $researchPaper)
    {
        try {
            DB::beginTransaction();
            if($researchPaper->status === ResearchStatusType::QUALITY_CHECKING){
                $researchPaper->update(['status' => ResearchStatusType::FINAL_CHECKING, 'is_approved_by_adviser' => false, 'for_scheduling' => false]);
            } else {
                dd('Quality cheking approval is for adviser only');
            }
            $researchPaper->latestReceipt->update([
                'is_approved' => true
            ]);
            $researchPaper->adviser->notify(new ResearchStatusChanged(auth()->user(), $researchPaper->status));
            $researchPaper->author->notify(new ResearchStatusChanged(auth()->user(), $researchPaper->status));
        

            ActivityLogged::dispatch(auth()->user(), 'Admin changed the status for research title: '.$researchPaper->title.'  on ' . now()->format('M d, Y h:i A'));
            DB::commit();
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
}
