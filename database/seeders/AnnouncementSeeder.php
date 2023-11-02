<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Announcement;
use Faker\Factory as Faker;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $announcements = [
            [
                'title' => 'Important Submission Requirements',
                'content' => '<ul>
                <li>1 copy of the final manuscript in book form (hardbound)</li>
                <li>3 CDs containing the final manuscript (in Word and PDF format)</li>
                <li>Final adviser’s payment receipt</li>
                <li>1 printed copy of the published paper</li>
                <li>For masteral program – students who were enrolled June, 2018 onwards are covered by the
                    publication policy</li>
                <li>For doctoral program – all students are covered regardless of the year of entry in the
                    UMPS</li>
            </ul>',
                'is_active' => true,
                'user_id' => 1,
                'is_pinned' => true,
            ],
            [
                'title' => 'Announcement 2',
                'content' => $faker->sentence(),
                'is_active' => true,
                'user_id' => 1
            ],
            [
                'title' => 'Announcement 3',
                'content' => $faker->paragraph(),
                'is_active' => true,
                'user_id' => 1
            ]
        ];

        foreach($announcements as $announcement) {
            Announcement::create($announcement);
        }
    }
}
