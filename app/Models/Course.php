<?php

namespace App\Models;

use App\Enums\ProgramType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;


    protected $casts = [
        'is_active' => 'boolean',
        'program_type' => ProgramType::class
    ];
    
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'course_id');
    }
}
