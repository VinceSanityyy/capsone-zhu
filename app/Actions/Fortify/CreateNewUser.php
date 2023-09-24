<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Support\Facades\Storage;
class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
 
       
   
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'course_id' => 'required',
            // 'year_level' => 'required',
            'school_year' => 'required',
            'subject_code' => 'required',
            'phone_number' => ['required', 'string', 'max:255', Rule::unique(User::class)],
            'id_number' => ['required', 'string', 'max:255', Rule::unique(User::class)],
            'terms' => 'accepted',
            'password' => $this->passwordRules(),
            'enrollment_form' => 'required|file|max:2048',
            'degree_type' => 'required'
        ])->validate();

        $user =  User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'course_id' => $input['course_id'],
            'degree_type' => $input['degree_type'],
            'school_year' => $input['school_year'],
            'subject_code' => $input['subject_code'],
            'id_number' => $input['id_number'],
            'phone_number' => $input['phone_number'],
        ])->assignRole('student');


        if ($input['enrollment_form']->isValid()) {
            // Generate a unique filename
            $filename = uniqid('enrollment_form_') . '.' . $input['enrollment_form']->getClientOriginalExtension();
        
            // Define the path where the file will be stored, e.g., in the 'users' directory with the user's ID as a subdirectory
            $path = 'users/' . $user->id;
        
            // Store the uploaded file in the specified path
            $file = Storage::disk('public')->putFileAs($path, $input['enrollment_form'], $filename);
        
            // Create a new Form record and associate it with the user
            $form = $user->form()->create(['file_path' => $path . '/' . $filename]);
        
            // Get the full URL of the uploaded enrollment form
            $form->file_path = Storage::disk('public')->url($form->file_path);
        
            $form->save(); // Save the updated form with the full URL
        }
        
        return $user;
    }

}
