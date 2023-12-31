<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Enums\ResearchStatusType;
use App\Models\Course;
use App\Models\ResearchPaper;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $barchartData = $this->getOverallStudentsCompletedResearch();
        return Inertia::render('Admin/Reports',[
            'barChartData' => $barchartData,
            'courses' => Course::all()
        ]);
    }


    private function getOverallStudentsCompletedResearch()
    {
        $results = ResearchPaper::selectRaw('status, COUNT(*) as total')
        ->whereHas('defenseSchedules', function ($query) {
            $query->where('is_done', true);
            })
            ->where('status', ResearchStatusType::COMPLETED)
            // ->whereBetween
            ->groupBy('status')
            ->get();

        $formattedResults = [];
        foreach ($results as $result) {
            $formattedResults[] = [
                'label' => $result->status,
                'value' => $result->total,
                // 'color' => '#af2532'
            ];
        }

        return $formattedResults;
    }

    public function getOverallStudentsCompletedResearchPerProgramType($courseId, $from, $to)
    {
        $researchStatusValues = ResearchStatusType::values();

        $results = ResearchPaper::rightJoin('users', 'research_papers.user_id', '=', 'users.id')
            ->join('courses', 'users.course_id', '=', 'courses.id')
            ->where('users.course_id', $courseId)
            ->whereHas('defenseSchedules', function ($query) {
                $query->where('is_done', true);
            })
            ->selectRaw('courses.name as course_name, research_papers.status, COUNT(*) as total')
            ->groupBy('courses.name', 'research_papers.status')
            ->orderBy('courses.name')
            ->orderBy('research_papers.status')
            ->get();
    
        $formattedResults = [];
    
        foreach ($researchStatusValues as $status) {
            $result = $results->firstWhere('status', $status);
    
            if ($result) {
                $formattedResults[] = [
                    'label' => $result->status->value,
                    'value' => $result->total,
                    'color' => '#af2532'
                ];
            } else {
                $formattedResults[] = [
                    'label' => $status->value,
                    'value' => 0,
                    'color' => '#af2532'
                ];
            }
        }
    
        // dd($formattedResults);

        if (request()->wantsJson()) {
            return $formattedResults;
        }
    }


    public function filterPiechartData(Request $request)
    {
        $results = ResearchPaper::selectRaw('status, COUNT(*) as total')
        ->whereHas('defenseSchedules', function ($query) use ($request) {
            $query->where('is_done', true)
                // ->whereBetween('created_at',[Carbon::parse($request['form']['from'])->startOfDay(), Carbon::parse($request['form']['to'])->endOfDay()]);
                ->where(function ($query) use ($request) {
                    $query->whereBetween('start', [
                        Carbon::parse($request['form']['from'])->startOfDay(),
                        Carbon::parse($request['form']['to'])->endOfDay(),
                    ])
                    ->orWhereBetween('end', [
                        Carbon::parse($request['form']['from'])->startOfDay(),
                        Carbon::parse($request['form']['to'])->endOfDay(),
                    ]);
                });
            })
            // ->where('status', ResearchStatusType::COMPLETED)
            ->groupBy('status')
            ->get();
        // dd($results);
        $formattedResults = [];
        foreach ($results as $result) {
            $formattedResults[] = [
                'label' => $result->status,
                'value' => $result->total,
                // 'color' => '#af2532'
            ];
        }

        return $formattedResults;
    }
}
