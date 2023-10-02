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

use function PHPUnit\Framework\isEmpty;

class StudentController extends Controller
{
    public function showSubmissions()
    {
        $adviserRole = Role::where('name', 'adviser')->first();
        $advisers = User::role($adviserRole)->get();
        // dd(auth()->user()->studentPaper);
        $alreadySubmitted = auth()->user()->studentPaper ? true : false;
   
        return Inertia::render('Student/CreateResearchPaper',[
            'advisers' => $advisers,
            'alreadySubmitted' => $alreadySubmitted,
            'studentPaper' => auth()->user()->studentPaper,
        ]);
    }



    public function submitResearchPaper(Request $request)
    {
       
        if(!auth()->user()->studentPaper){
            // dd(1);
            $request->validate([
                'title' => 'required',
                'adviser' => 'required',
                'status' => 'required',
                'document' => 'required|mimes:pdf|max:10000',
                'endorsement' => 'nullable|mimes:pdf|max:10000',
                'receipt' => 'nullable|mimes:pdf|max:10000',
            ]);
        
            $data = [
                'user_id' => auth()->user()->id,
                'title' => $request->title,
                'adviser' => $request->adviser,
                'status' => ResearchStatusType::byName($request->status)->value,
                'document' => url(Config::get('app.url') . Storage::url($request->file('document')->store('research_papers', 'public'))),
            ];
            
            if ($request->status == 'for_scheduling') {
                dd(1);
                if ($request->hasFile('endorsement')) {
                    $data['endorsement'] = url(Config::get('app.url') . Storage::url($request->file('endorsement')->store('endorsements', 'public')));
                }
            
                if ($request->hasFile('receipt')) {
                    $data['receipt'] = url(Config::get('app.url') . Storage::url($request->file('receipt')->store('receipts', 'public')));
                }
            }
        
            $research = ResearchPaper::create($data); 
    
            if($research)
            {
                return to_route('student.submissions');
            }
        }
        dd('naka submit naka oy unsa ka duha ka thesis?');
   
    }
}
