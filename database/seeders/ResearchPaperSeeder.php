<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\ResearchPaper;
use Faker\Factory as Faker;
use App\Enums\ResearchStatusType;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class ResearchPaperSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        // Retrieve only users with the 'student' role
        $studentRole = Role::where('name', 'student')->first();
        $users = $studentRole->users()->where('is_active', true)->get();

        $sampleForm = 'https://images.shiksha.com/mediadata/images/articles/1681379362phpFssVQ8.jpeg';

        foreach ($users as $user) {
            // Assign an adviser
            $adviserRole = Role::where('name', 'adviser')->first();
            $adviser = $adviserRole->users()->inRandomOrder()->first();
      
            $researchPaper = $user->studentPaper()->create([
                'title' => $faker->sentence(),
                'document' => $sampleForm,
                'endorsement' => $sampleForm,
                'receipt' => 'https://files.jotform.com/jotformapps/payment-receipt-template-5fd30596666e2866e04390d48ec89876.png?v=1695990972',
                // 'receipt' => $faker->unique()->randomNumber(5),
                'status' => $faker->randomElement(ResearchStatusType::values()),
                // 'status' => ResearchStatusType::COMPLETED,
                'for_scheduling' => false,
                'is_approved_by_adviser' => true,
            ]);

            // Associate the adviser
            $researchPaper->adviser()->associate($adviser);
            $researchPaper->save();

            // Assign panel members (assuming panels is a many-to-many relationship)
            $panelMembersRole = Role::where('name', 'panel')->first();
            $panelMembers = $panelMembersRole->users()->inRandomOrder()->limit(3)->get();

            foreach ($panelMembers as $panelMember) {
                $researchPaper->panelMembers()->attach($panelMember);
            }

            $this->command->info("Student: {$user->name} with a research paper entitled: {$researchPaper->title} has been created.");
            // $startDateTime = Carbon::now()->setTimezone('Asia/Manila')->setTime(7, 0, 0); // Set start time to 7 AM in the desired timezone
            // $endDateTime = $startDateTime->copy()->addHour(); // Set end time to 8 AM (1 hour after the start time)
            
            
            // if ($endDateTime->hour >= 17) {
            //     $startDateTime->addDay()->setTime(7, 0, 0);
            //     $endDateTime->addDay()->setTime(8, 0, 0);
            // }
            // $this->command->info($startDateTime->toIso8601String(), $endDateTime->toIso8601String());
        
            // // Create defense schedule within the allowed range for each research paper
            // $researchPaper->defenseSchedules()->create([
            //     'start' => $startDateTime->toIso8601String(),
            //     'end' => $endDateTime->toIso8601String(),
            //     'is_done' => 1,
            // ]);
        }
    }
}
