<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Log;
use Carbon\Carbon;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $appends = [
        'current_roles'
    ];

    public function getCurrentRolesAttribute()
    {
        $roles = $this->roles->pluck('name')->implode(', ');

        return $roles;
    }
    
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function form()
    {
        //this should be hasMany in the future since user can add the forms for the next school yr.
        return $this->hasOne(StudentForm::class, 'user_id');
    }
    // public function researchPapers() {
    //     return $this->hasMany(ResearchPaper::class);
    // }

    public function adviserPaper() {
        return $this->hasMany(ResearchPaper::class, 'adviser_id');
    }

    public function studentPaper()
    {
        return $this->hasOne(ResearchPaper::class, 'user_id')->with('adviser','endorsement');
    }    

    public function papersOnPanel() {
        return $this->belongsToMany(ResearchPaper::class, 'research_paper_panels_pivot', 'user_id', 'research_paper_id');
    }

    // public function comments()
    // {
    //     return $this->hasMany(Comment::class, 'user_id');
    // }

    public function logActivities()
    {
        return $this->hasMany(Log::class, 'user_id');
    }

    public function getCreatedAtAttribute($value)
    {
        // Parse the created_at timestamp using Carbon and return the desired format
        return Carbon::parse($value)->toDayDateTimeString(); // Customize the format as per your requirement
    }
}
