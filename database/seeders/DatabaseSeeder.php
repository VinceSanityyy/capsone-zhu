<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\ResearchPaper;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ProgramSeeder::class,
            // CourseSeeder::class,
            MasteralProgramsSeeder::class,
            DoctoralProgramsSeeder::class,
            RolesAndPermissionsSeeder::class,
            UsersSeeder::class,
            AdvisersAndPannelsSeeder::class,
            // ResearchPaperSeeder::class, comment sa ka
            ResearchPaperSeeder::class,
            DashboardDataSeeder::class, // para sa schedules
            AnnouncementSeeder::class,
            CommentsSeeder::class
        ]);
    }
}
