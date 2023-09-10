<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'email' => 'admin@abc.com',
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'is_active' => true
            ],
            [
                'email' => 'faculty@abc.com',
                'name' => 'Faculty One',
                'password' => Hash::make('password'),
                'is_active' => true
            ],
            [
                'email' => 'student@abc.com',
                'name' => 'Student One',
                'password' => Hash::make('password'),
                'id_number' => 12345,
                'course_id' => Course::find(1)->value('id'),
                'school_year' => '2023-2024',
                'is_active' => true,
                'subject_code' => '321244'
            ],
        ];

        foreach ($users as $user){
            $createdUser = User::create($user);
            if ($user['email'] === 'admin@abc.com') {
                $createdUser->assignRole('admin');
            } elseif ($user['email'] === 'faculty@abc.com') {
                $createdUser->assignRole('faculty');
            } elseif ($user['email'] === 'student@abc.com') {
                $createdUser->assignRole('student');
            }
        }
    }
}
