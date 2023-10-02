<?php

namespace App\Http\Controllers;

use App\Models\ResearchPaper;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResearchPaperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ResearchPaper $researchPaper)
    {
        $researchPaper->load('adviser', 'panelMembers');
        $panelMemberComments = $researchPaper->panelMemberComments();
        $adviserComments = $researchPaper->adviserComments();

    
        return Inertia::render('Admin/Submissions/Show', [
            'researchPaper' => $researchPaper,
            'panelMemberComments' => $panelMemberComments,
            'adviserComments' => $adviserComments
        ]);
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ResearchPaper $researchPaper)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ResearchPaper $researchPaper)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResearchPaper $researchPaper)
    {
        //
    }
}
