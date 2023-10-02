<?php

namespace App\Models;

use App\Enums\ResearchStatusType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchPaper extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => ResearchStatusType::class,
        'panels' => 'array',
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

    public function endorsment()
    {
        return $this->hasOne(Endorsment::class);
    }
}
