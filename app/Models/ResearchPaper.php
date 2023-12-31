<?php

namespace App\Models;

use App\Enums\ResearchStatusType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ResearchPaper extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => ResearchStatusType::class,
        'panels' => 'array',
        'for_scheduling' => 'boolean'
    ];

    protected $appends = [
        'pannels' 
    ];

    protected $guarded = [
        'id'
    ];

    public function getPannelsAttribute()
    {
        $panels = $this->panelMembers->pluck('name')->implode(', ');

        return $panels;
    }
    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function masteral()
    {
        return $this->author()->where('degree_type', 'masteral');
    }

    public function doctoral()
    {
        return $this->author()->where('degree_type', 'doctoral');
    }
    
    public function adviser() {
        return $this->belongsTo(User::class, 'adviser_id');
    }
    
    public function panelMembers() {
        return $this->belongsToMany(User::class, 'research_paper_panels_pivot', 'research_paper_id', 'user_id');
    }

    public function receipts()
    {
        return $this->hasMany(PaymentReceipt::class);
    }

    public function latestReceipt()
    {
        return $this->hasOne(PaymentReceipt::class)->latestOfMany();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function panelMemberComments()
    {
        $panelMemberIds = $this->panelMembers()->pluck('users.id')->toArray();
        $comments = Comment::where('research_paper_id', $this->id)
            ->whereIn('user_id', $panelMemberIds)
            ->with('user')
            ->get();

        return $comments;
    }

    public function adviserComments()
    {
        $comments = Comment::where('research_paper_id', $this->id)
            ->where('user_id', $this->adviser->id)
            ->with('user')
            ->get();

        return $comments;
    }

    public function adminComments()
    {
        $comments = Comment::where('research_paper_id', $this->id)
            ->where('user_id', 1)
            ->with('user')
            ->get();

        return $comments;
    }

    public function endorsement()
    {
        return $this->hasMany(Endorsment::class)->latest();
    }

    public function defenseSchedules()
    {
        return $this->hasOne(DefenseSchedule::class)->latestOfMany();
    }

    public function attachedEndorsmentFiles($user_id)
    {
        return $this->endorsement()->where('user_id', $user_id)->get();
    }

    public function evaluationForms()
    {
        return $this->hasMany(Evaluation::class)->with('panel');
    }

    public function attachedEvaluationFiles($user_id)
    {
        return $this->evaluationForms()->where('user_id', $user_id)->get();
    }

    public function getCreatedAtAttribute($value)
    {
        // Parse the created_at timestamp using Carbon and return the desired format
        return Carbon::parse($value)->toDayDateTimeString(); // Customize the format as per your requirement
    }

}
