<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefenseSchedule extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    public function researchPaper()
    {
        return $this->belongsTo(ResearchPaper::class, 'research_paper_id');
    }

    protected $appends = ['title', 'author', 'adviser', 'object'];

    public function getTitleAttribute()
    {
        return $this->researchPaper->title;
    }

    public function getAuthorAttribute()
    {
        return $this->researchPaper->author->name;
    }

    public function getAdviserAttribute()
    {
        return $this->researchPaper->adviser->name;
    }
    
    public function getObjectAttribute()
    {
        return $this->researchPaper;
    }
}
