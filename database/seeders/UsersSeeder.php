<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Faker\Factory as Faker;


class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        //pre defined users
        $users = [
            [
                'email' => 'admin@abc.com',
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'phone_number' => '09123456780',
                'is_active' => true
            ],
            [
                'email' => 'faculty@abc.com',
                'name' => 'Faculty One',
                'password' => Hash::make('password'),
                'phone_number' => '09123456789',
                'is_active' => true
            ],
            [
                'email' => 'student@abc.com',
                'name' => 'Student One',
                'password' => Hash::make('password'),
                'phone_number' => '09123456781',
                'id_number' => 12345,
                'course_id' => Course::find(1)->value('id'),
                'school_year' => '2023-2024',
                'is_active' => true,
                'subject_code' => '321244',
                'degree_type' => 'masteral'
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

        // Create 15 random student users using Faker
        for ($i = 1; $i <= 500; $i++) { // <- number of students
            $course = Course::inRandomOrder()->first();
            $degree_type = $course->program_type->value && str_contains(strtolower($course->program_type->value), 'masteral') ? 'masteral' : 'doctoral';
            
            $user = User::create([
                'email' => "student{$i}@abc.com",
                'name' => $faker->name,
                'password' => Hash::make('password'),
                'phone_number' => $faker->phoneNumber,
                'id_number' => $faker->unique()->randomNumber(5),
                'course_id' => $course->id,
                'school_year' => $faker->randomElement(['2023-2024', '2024-2025']),
                // 'is_active' => $faker->boolean(),
                'is_active' => true,
                'subject_code' => $faker->unique()->randomNumber(6),
                'degree_type' => $degree_type,
            ]);
            $user->assignRole('student');
            $user->form()->create(['file_path' => 'https://images.template.net/wp-content/uploads/2019/09/Student-Enrollment-Form-in-PDF.jpg']); //random url only
        }

        /** 
        //panels
        for ($a = 1; $a <= 5; $a ++){
            $user = User::create([
                'email' => "panel{$a}@abc.com",
                'name' => $faker->name,
                'password' => Hash::make('password'),
                'phone_number' => $faker->phoneNumber,
                'is_active' => true,
            ]);
            $user->assignRole('panel');
        }

        //adviser
        for ($b = 1; $b <= 5; $b++){
            $user = User::create([
                'email' => "adviser{$b}@abc.com",
                'name' => $faker->name,
                'password' => Hash::make('password'),
                'phone_number' => $faker->phoneNumber,
                'is_active' => true,
            ]);
            $user->assignRole('adviser');
        }

        */
        //faculty
        for ($c = 1; $c <= 5; $c++){
            $faculty = User::create([
                'email' => "faculty{$c}@abc.com",
                'name' => $faker->name,
                'password' => Hash::make('password'),
                'phone_number' => $faker->phoneNumber,
                'is_active' => true,
            ]);
            $faculty->assignRole('faculty');
        }
    }
}
