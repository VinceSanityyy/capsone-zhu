<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Endorsment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function getCreatedAtAttribute($value)
    {
        // Parse the created_at timestamp using Carbon and return the desired format
        return Carbon::parse($value)->format('Y-m-d H:i:s'); // Customize the format as per your requirement
    }

    public function researchPaper()
    {
        return $this->belongsTo(ResearchPaper::class, 'research_paper_id');
    }

    
}
