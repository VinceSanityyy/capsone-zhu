<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use App\Notifications\CommentAddedNotification;
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
            'adviserComments' => $adviserComments
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
        // dd($request->file('file'));
        $paper = auth()->user()->adviserPaper()->where('id', $request->id)->first();
        $paper->endorsement()->create([
            'file_path' => url(Config::get('app.url') . Storage::url($request->file('file')->store('endorsements', 'public'))),
        ]);
        $paper->update([
            'is_approved_by_adviser' => true
        ]);
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
