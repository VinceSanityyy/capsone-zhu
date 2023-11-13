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
        $researchPaper = ResearchPaper::all();
        foreach ($researchPaper as $paper) {
            if ($paper->created_at->diffInDays(now()) >= 7) {
                $paper->update([
                    'status' => ResearchStatusType::ARCHIVED
                ]);
        
                Log::info("Research paper with a tile: '{$paper->title}' authored by '{$paper->author->name}' is now marked as archived.");
            }
        }
    }
}
