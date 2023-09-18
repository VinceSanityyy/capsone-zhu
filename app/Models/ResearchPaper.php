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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
