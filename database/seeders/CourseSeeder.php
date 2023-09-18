<?php

namespace Database\Seeders;

use App\Enums\ProgramType;
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
                'name' => 'Masters in Information Technology',
                'slug' => 'PS', // Associate with the program by slug
                'is_active' => true,
                'program_slug' => 'MIT',
                'program_type' => ProgramType::MASTERS
            ],
            [
                'name' => 'Masters in Computer Science',
                'slug' => 'PS', 
                'is_active' => true,
                'program_slug' => 'MSCS',
                'program_type' => ProgramType::MASTERS

            ],
            [
                'name' => 'Masters in Civil Engineering',
                'slug' => 'PS', 
                'is_active' => true,
                'program_slug' => 'MSCE',
                'program_type' => ProgramType::MASTERS

            ],
            [
                'name' => 'Masters in Chemecal Engineering',
                'slug' => 'PS', 
                'is_active' => true,
                'program_slug' => 'MSCHE',
                'program_type' => ProgramType::MASTERS

            ],
            //add other programs
        ];

        foreach ($courses as $course){
            $program = Program::where('slug', $course['slug'])->first();
            
            if ($program) {
                $program->courses()->create([
                    'name' => $course['name'],
                    'slug' =>  $course['slug'],
                    'is_active' => $course['is_active'],
                    'program_slug' => $course['program_slug'],
                    'program_type' => $course['program_type']
                ]);
            }
        }
    }
}
