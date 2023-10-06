<?php

namespace App\Http\Controllers;

use App\Models\ResearchPaper;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Spatie\Permission\Models\Role;
class ResearchPaperController extends Controller
{

    public function show(ResearchPaper $researchPaper)
    {
        $researchPaper->load('author', 'adviser', 'panelMembers');
        $panelMemberComments = $researchPaper->panelMemberComments();
        $adviserComments = $researchPaper->adviserComments();

        $panelRole = Role::where('name', 'panel')->first();
        $panelMembers = User::role($panelRole)->get();
    
        return Inertia::render('Admin/Submissions/Show', [
            'researchPaper' => $researchPaper,
            'panelMemberComments' => $panelMemberComments,
            'adviserComments' => $adviserComments,
            'panelMembers' => $panelMembers
        ]);
    }

    public function addPanelMembers(ResearchPaper $researchPaper, Request $request)
    {
        $requiredPanelMembersCount = ($researchPaper->author->degree_type === 'masters') ? 4 : 5;
        
        $request->validate([
            'panels' => 'required|array|size:' . $requiredPanelMembersCount
        ]);
    
        $researchPaper->panelMembers()->sync($request->panels);
        
        return to_route('admin.research-paper.show', $researchPaper->id);
    }
}
