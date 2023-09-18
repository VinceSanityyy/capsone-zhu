<?php

namespace Database\Seeders;

use App\Enums\ResearchStatusType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ResearchPaperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $users = User::where('is_active', true)
        ->whereDoesntHave('roles', function ($q) {
            $q->whereIn('name', ['admin', 'faculty']);
        })
        ->get();
      
        $sampleForm = 'https://images.shiksha.com/mediadata/images/articles/1681379362phpFssVQ8.jpeg';
        foreach ($users as $user){
            $user->researchPaper()->create([
                'title' => $faker->sentence(),
                'adviser' => $faker->name(),
                'proposal_form' => $sampleForm,
                'endorsment_form' => $sampleForm,
                'panels' => implode(', ', [$faker->name(), $faker->name(), $faker->name()]),
                'receipt' => $faker->unique()->randomNumber(5),
                'status' => $faker->randomElement(ResearchStatusType::values())
            ]);
        }
    }
}
