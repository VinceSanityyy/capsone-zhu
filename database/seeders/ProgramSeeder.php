<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Program;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            [
                'name' => 'College of Computing Education',
                'slug' => 'CCE',
                'is_active' => true
            ],
            [
                'name' => 'College of Engineering Education',
                'slug' => 'CEE',
                'is_active' => true
            ],   
            [
                'name' => 'College of Accounting Education',
                'slug' => 'CAE',
                'is_active' => true
            ],
            [
                'name' => 'College of Hospitality Education',
                'slug' => 'CHE',
                'is_active' => true
            ],
            [
                'name' => 'College of Arts and Sciences Education',
                'slug' => 'CASE',
                'is_active' => true
            ],
        ];

        foreach ($programs as $program){
            Program::create($program);
        }
    }
}
