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
                'name' => 'Professional Schools',
                'slug' => 'PS',
                'is_active' => true
            ],
        ];

        foreach ($programs as $program){
            Program::create($program);
        }
    }
}
