<?php

namespace App\Http\Controllers;

use App\Models\ResearchPaper;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Notifications\CommentAddedNotification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class PanelController extends Controller
{
    public function panelledPapers()
    {
        $assignedPapers = auth()->user()->papersOnPanel()->get();
        // dd($assignedPapers[0]->adviser);
        return Inertia::render('Panel/PanelledPapers',[
            'assignedPapers' => $assignedPapers->load('author','adviser')
        ]);
    }

    public function showPanelledPaper(Request $request)
    {
        $paper = auth()->user()->papersOnPanel()->where('research_papers.id', $request->id)->first();
        $paper->load('author', 'adviser', 'panelMembers');
        $panelMemberComments = $paper->panelMemberComments();
        $adviserComments = $paper->adviserComments();
    
        return Inertia::render('Panel/ShowPanelledPaper',[
            'paper' => $paper,
            'panelMemberComments' => $panelMemberComments,
            'adviserComments' => $adviserComments,
            'attachedEvaluationForms' => $paper->attachedEvaluationFiles(auth()->user()->id)
        ]);
    }

    public function addPanelComment(Request $request)
    {
        $request->validate([
            'comment' => 'required'
        ]);
        $paper = auth()->user()->papersOnPanel()->where('research_paper_id', $request->id)->first();
        $paper->comments()->create([
            'comment' => $request->comment,
            'user_id' => auth()->user()->id
        ]);
        $paper->author->notify(new CommentAddedNotification(auth()->user()));
        // $admin = User::role('admin')->first();
        // $admin->notify(new CommentAddedNotification(auth()->user()));
        return redirect()->back();
    }

    public function attachEvaluationPaper( Request $request)
    {
        $paper = auth()->user()->papersOnPanel()->where('research_paper_id', $request->id)->first();
 
        $paper->evaluationForms()->create([
                'file_path' => url(Config::get('app.url') . Storage::url($request->file('evaluation')->store('evaluation', 'public'))),
                'stage_submitted' => $paper->status,
                'user_id' => auth()->user()->id,
        ]);
        return redirect()->back();
    }
}
