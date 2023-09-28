<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\ResearchPaper;
use Faker\Factory as Faker;
use App\Enums\ResearchStatusType;
use Spatie\Permission\Models\Role;

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

            $researchPaper = $user->researchPapers()->create([
                'title' => $faker->sentence(),
                'proposal_form' => $sampleForm,
                'endorsment_form' => $sampleForm,
                // 'receipt' => $faker->unique()->randomNumber(5),
                'status' => $faker->randomElement(ResearchStatusType::values())
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
        }
    }
}
