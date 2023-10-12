<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Program;
use App\Enums\ProgramType;
class DoctoralProgramsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
    
            $csvFile = new \SplFileObject(public_path('csv/doctoral_programs.csv'));
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
                        'program_type' => ProgramType::DOCTORS,
                        'program_slug' => ''
                    ]);
    
                    $this->command->info("Program {$programName} added.");
                }
            }
            $this->command->info('All Programs for Doctoral created.');
        }
    }
}
