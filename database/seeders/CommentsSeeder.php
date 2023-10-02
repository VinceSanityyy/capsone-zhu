<?php

namespace Database\Seeders;

use App\Models\ResearchPaper;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $researchPapers = ResearchPaper::all();

        foreach ($researchPapers as $paper) {
            // Get panel members associated with the research paper
            $panelMembers = $paper->panelMembers;

            // Create comments for panel members
            foreach ($panelMembers as $panelMember) {
                $panelMemberId = $panelMember->id;
                $panelMemberName = $panelMember->name; // Assuming 'name' is the column storing the user's name

                $paper->comments()->create([
                    'user_id' => $panelMemberId,
                    'comment' => "Comment from Panel Member $panelMemberName (ID: $panelMemberId) for Paper $paper->title",
                ]);
            }

            // Get the adviser associated with the research paper
            $adviser = $paper->adviser;
            $adviserId = $adviser->id;
            $adviserName = $adviser->name; // Assuming 'name' is the column storing the user's name

            // Create a comment for the adviser
            $paper->comments()->create([
                'user_id' => $adviserId,
                'comment' => "Comment from Adviser $adviserName (ID: $adviserId) for Paper $paper->title",
            ]);
        }
    }
}
