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
                'title' => 'Announcement 1',
                'content' => $faker->sentence(),
                'is_active' => true,
                'user_id' => 1
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
