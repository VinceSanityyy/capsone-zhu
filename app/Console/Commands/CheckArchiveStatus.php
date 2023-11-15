<?php

namespace App\Console\Commands;

use App\Enums\ResearchStatusType;
use Illuminate\Console\Command;
use App\Models\ResearchPaper;
use Illuminate\Support\Facades\Log;
class CheckArchiveStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'runArchiveCheck';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $researchPaper = ResearchPaper::all();
        $researchPaper = ResearchPaper::where('status', ResearchStatusType::COMPLETED)->get();
        // dd($researchPaper);
        foreach ($researchPaper as $paper) {
            // dd($paper->defenseSchedules);
            // dd($paper->defenseSchedules->created_at->diffInDays(now()) <= 7);
            if ($paper->defenseSchedules->created_at->diffInDays(now()) <= 7) {
                $paper->update([
                    'status' => ResearchStatusType::ARCHIVED
                ]);
        
                Log::info("Research paper with a tile: '{$paper->title}' authored by '{$paper->author->name}' is now marked as archived.");
            }
        }
    }
}
