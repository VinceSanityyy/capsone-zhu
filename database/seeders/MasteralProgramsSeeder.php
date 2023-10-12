<?php

namespace Database\Seeders;

use App\Enums\ProgramType;
use App\Models\Course;
use App\Models\Program;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class MasteralProgramsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $faker = Faker::create();
    
            $csvFile = new \SplFileObject(public_path('csv/mastaral_programs.csv'));
            $csvFile->setFlags(\SplFileObject::READ_CSV);
    
            $skipFirstRow = true;
            foreach ($csvFile as $row) {
                if (empty($row) || count($row) < 1) {
                    continue;
                }
                if ($skipFirstRow) {
                    $skipFirstRow = false;
                    continue;
                }
    
                $programName = $row[0] ?? ''; // Get the value of the first column (program name) or an empty string if it's not set
    
                if (!empty($programName)) {
                    Course::create([
                        'program_id' => Program::find(1)->value('id'),
                        'name' => $programName,
                        'slug' => 'PS',
                        'is_active' => true,
                        'program_type' => ProgramType::MASTERS,
                        'program_slug' => ''
                    ]);
    
                    $this->command->info("Program {$programName} added.");
                }
            }
            $this->command->info('All Programs for Masteral created.');
        }
    }
    
}
