<?php

namespace App\Http\Controllers;

use App\Enums\ResearchStatusType;
use App\Models\ResearchPaper;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;

class StudentController extends Controller
{
    public function showSubmissions()
    {
        $adviserRole = Role::where('name', 'adviser')->first();
        $advisers = User::role($adviserRole)->get();
        // dd(auth()->user()->studentPaper);
        $alreadySubmitted = auth()->user()->studentPaper ? true : false;

        // $paper->load('author', 'adviser', 'panelMembers');
        // $panelMemberComments = $paper->panelMemberComments();
        // $adviserComments = $paper->adviserComments();

        return Inertia::render('Student/CreateResearchPaper',[
            'advisers' => $advisers,
            'alreadySubmitted' => $alreadySubmitted,
            'studentPaper' => auth()->user()->studentPaper,
            'adviserComments' => auth()->user()->studentPaper ? auth()->user()->studentPaper->adviserComments() : null,
            'panelMemberComments' => auth()->user()->studentPaper ? auth()->user()->studentPaper->panelMemberComments() : null,
        ]);
    }

    public function submitResearchPaper(Request $request)
    {
     
       
        $scheduling = $request->for_scheduling == 'yes' ? true : false;
        // if(!auth()->user()->studentPaper){
            // dd(1);
           $request->validate([
                'title' => 'required',
                'adviser_id' => 'required',
                'status' => 'required',
                'document' => 'required|mimes:pdf',
                'endorsement' => 'nullable|mimes:pdf,jpg|max:10000',
                'receipt' => 'nullable|mimes:pdf,jpg|max:10000',
                'for_scheduling' => 'required'
            ]);
        
            $data = [
                'user_id' => auth()->user()->id,
                'title' => $request->title,
                'adviser_id' => $request->adviser_id,
                'status' => ResearchStatusType::byName($request->status)->value,
                'document' => url(Config::get('app.url') . Storage::url($request->file('document')->store('research_papers', 'public'))),
                'for_scheduling' => $scheduling,
            ];
            
            if ($request->status == 'for_scheduling') {
                if ($request->hasFile('endorsement')) {
                    $data['endorsement'] = url(Config::get('app.url') . Storage::url($request->file('endorsement')->store('endorsements', 'public')));
                }
            
                if ($request->hasFile('receipt')) {
                    $data['receipt'] = url(Config::get('app.url') . Storage::url($request->file('receipt')->store('receipts', 'public')));
                }
            }
        
            // Find the existing research paper by user_id
            $research = ResearchPaper::where('user_id', auth()->user()->id)->first();

            if ($research) {
                // Update the existing research paper
                $research->update($data);
            } else {
                // Create a new research paper
                ResearchPaper::create($data);
            }

            return redirect()->route('student.submissions');
        // }
    }
}
