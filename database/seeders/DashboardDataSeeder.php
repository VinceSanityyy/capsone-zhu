<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Faker\Factory as Faker;
use App\Enums\ResearchStatusType;
use App\Models\ResearchPaper;
use Carbon\Carbon;

class DashboardDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $papers = ResearchPaper::all();
        $faker = Faker::create();
        
        foreach ($papers as $index => $paper) {
            $startDateTime = Carbon::now()->setTimezone('Asia/Manila')->setTime(7, 0, 0)->addDays($index);
            $endDateTime = $startDateTime->copy()->addHour();
            // If the hour is 17 or greater, move to the next day and set start time to 7 AM
            if ($endDateTime->hour >= 17) {
                $startDateTime->addDay()->setTime(7, 0, 0);
            }
        
            // Add 1 hour to end time
            $endDateTime->addHour();
        
            // Create defense schedule within the allowed range for each research paper
            $paper->defenseSchedules()->create([
                'start' => $startDateTime->toIso8601String(),
                'end' => $endDateTime->toIso8601String(),
                'is_done' => 1,
            ]);
            $this->command->info($startDateTime->toIso8601String(), $endDateTime->toIso8601String());
            $this->command->info("Defense schedule for research title: {$paper->title} has been created by {$paper->author->name}.");
        }
    }
}
