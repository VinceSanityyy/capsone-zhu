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

    public function getPannelsAttribute()
    {
        $panels = $this->panelMembers->pluck('name')->implode(', ');

        return $panels;
    }
    public function author() {
        return $this->belongsTo(User::class, 'user_id');
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

}
