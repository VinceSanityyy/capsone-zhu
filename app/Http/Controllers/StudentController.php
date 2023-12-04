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
use App\Models\DefenseSchedule;

class StudentController extends Controller
{
    public function showSubmissions()
    {
        $adviserRole = Role::where('name', 'adviser')->first();
        $advisers = User::role($adviserRole)->get();
        // dd(auth()->user()->studentPaper);
        $alreadySubmitted = auth()->user()->studentPaper ? true : false;

        // $attachedEndorsements = auth()->user()->studentPaper->attachedEndorsmentFiles(auth()->user()->studentPaper->adviser->id) ?? null;
        return Inertia::render('Student/CreateResearchPaper', [
            'advisers' => $advisers,
            'alreadySubmitted' => $alreadySubmitted,
            'studentPaper' => auth()->user()->studentPaper,
            'adviserComments' => auth()->user()->studentPaper ? auth()->user()->studentPaper->adviserComments() : null,
            'panelMemberComments' => auth()->user()->studentPaper ? auth()->user()->studentPaper->panelMemberComments() : null,
            'adminComments' => auth()->user()->studentPaper ? auth()->user()->studentPaper->adminComments() : null,
            'attachedPanelEndorsements' => auth()->user()->studentPaper ? auth()->user()->studentPaper->attachedEndorsmentFiles(auth()->user()->studentPaper->adviser->id) : null,
        ]);
    }

    public function submitResearchPaper(Request $request)
    {

        $scheduling = $request->for_scheduling == 'yes' ? true : false;
        // if(!auth()->user()->studentPaper){
        // dd(1);
        $plagiarism_counter = 0;
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
        // if ($request->status == 'for_scheduling') {
        if ($request->for_scheduling) {
            if ($request->hasFile('endorsement')) {
                $data['endorsement'] = url(Config::get('app.url') . Storage::url($request->file('endorsement')->store('endorsements', 'public')));
            }
            if ($request->hasFile('receipt')) {
                $data['receipt'] = url(Config::get('app.url') . Storage::url($request->file('receipt')->store('receipts', 'public')));
            }
        }

        if ($request->status === 'final_checking') {
            if ($request->hasFile('endorsement')) {
                $data['endorsement'] = url(Config::get('app.url') . Storage::url($request->file('endorsement')->store('endorsements', 'public')));
            }
        }
        // Find the existing research paper by user_id
        $research = ResearchPaper::where('user_id', auth()->user()->id)->first();

        if ($research) {
            if ($research->is_approved_by_adviser && !$research->for_scheduling) {
                // Update the existing research paper
               
                if($research->status == ResearchStatusType::QUALITY_CHECKING){
                    // if($research->plagiarism_counter >= 3){
                    //     dd('You have reached the maximum number of plagiarism, attach a receipt');
                    // }
                    $research->update(array_merge($data,[
                        'plagirism_counter' => $research->plagiarism_counter += 1
                    ]));
                  
                }
                $research->update($data);
                if ($request->hasFile('receipt')) {
                    $research->receipts()->create([
                        'receipt' => url(Config::get('app.url') . Storage::url($request->file('receipt')->store('receipts', 'public'))),
                        'user_id' => auth()->user()->id,
                        'reference_number' => $request->reference_number,
                        'stage_submitted' => $research->status,
                        'amount' => $request->amount,
                    ]);
                }
                if ($request->hasFile('endorsement')) {
                    $research->endorsement()->create([
                        'file_path' => url(Config::get('app.url') . Storage::url($request->file('endorsement')->store('endorsements', 'public'))),
                        'stage_submitted' => $research->status,
                        'user_id' => auth()->user()->id,
                    ]);
                }
            } elseif (!$research->is_approved_by_adviser && !$research->for_scheduling) {
                if ($request->hasFile('endorsement')) {
                    $research->endorsement()->create([
                        'file_path' => url(Config::get('app.url') . Storage::url($request->file('endorsement')->store('endorsements', 'public'))),
                        'stage_submitted' => $research->status,
                        'user_id' => auth()->user()->id,
                    ]);
                }
                $research->update($data);
            }
        } else {

            // Create a new research paper
            ResearchPaper::create($data);
        }

        return redirect()->route('student.submissions');
        // }
    }

    public function showSchedules()
    {
        $papers = $this->showResearchPaspersForScheduling();

        return Inertia::render('Student/Schedules', [
            'papers' => $papers,
            'schedules' =>  $this->getSchedules()
        ]);
    }

    private function showResearchPaspersForScheduling()
    {
        return ResearchPaper::where('for_scheduling', true)->get();
    }

    private function getSchedules()
    {
        return DefenseSchedule::with('researchPaper', 'researchPaper.author', 'researchPaper.adviser')->get();
    }

    public function updateTitle(Request $request, ResearchPaper $researchPaper)
    {
        $researchPaper->update([
            'title' => $request->title
        ]);
        return redirect()->back();
    }
}
