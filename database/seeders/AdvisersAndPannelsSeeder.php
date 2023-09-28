<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;


class AdvisersAndPannelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $csvFile = new \SplFileObject(public_path('csv/potential_panels_and_advisers.csv'));
        $csvFile->setFlags(\SplFileObject::READ_CSV);

        $skipFirstRow = true;
        foreach ($csvFile as $row) {
            if (empty($row) || count($row) < 2) {
                continue;
            }

            if($skipFirstRow) {
                $skipFirstRow = false;
                continue;
            }
            // dd(count($row));
            $user = User::firstOrNew(['email' => $row[1]]);
        
            if (!$user->exists) {
                // User does not exist, create a new user
                $user->name = $row[0];
                $user->password = Hash::make('password');
                $user->phone_number = $faker->phoneNumber(); // random default
                $user->is_active = true;
                $user->save();
            }

            $user->assignRole(['adviser', 'panel']);
            $this->command->info("User {$user->name} created with the role of adviser and panel.");
        }
        $this->command->info('All advisers and panels created.');
    }
}
