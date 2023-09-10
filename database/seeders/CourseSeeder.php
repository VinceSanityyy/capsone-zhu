<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Program;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
                'name' => 'Information Technology',
                'program_slug' => 'CCE', // Associate with the program by slug
                'is_active' => true,
                'slug' => 'BSIT',
            ],
            [
                'name' => 'Computer Science',
                'program_slug' => 'CEE', 
                'is_active' => true,
                'slug' => 'BSCS',
            ],
            [
                'name' => 'Nursing',
                'program_slug' => 'CHE', 
                'is_active' => true,
                'slug' => 'BSN',
            ],
            [
                'name' => 'Chemistry',
                'program_slug' => 'CASE', 
                'is_active' => true,
                'slug' => 'BSCH',
            ],
            [
                'name' => 'Civil Engineering',
                'program_slug' => 'CEE', 
                'is_active' => true,
                'slug' => 'BSCE',
            ],
        ];

        foreach ($courses as $course){
            $program = Program::where('slug', $course['program_slug'])->first();
            
            if ($program) {
                $program->courses()->create([
                    'name' => $course['name'],
                    'slug' =>  $course['slug'],
                    'is_active' => $course['is_active']
                ]);
            }
        }
    }
}
