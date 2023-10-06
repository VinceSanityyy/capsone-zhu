<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

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
            'adviserComments' => $adviserComments
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
        return redirect()->back();
    }
}
