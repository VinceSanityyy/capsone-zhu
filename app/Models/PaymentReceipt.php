<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class PaymentReceipt extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function researchPaper()
    {
        return $this->belongsTo(ResearchPaper::class);
    }

    public function getCreatedAtAttribute($value)
    {
        // Parse the created_at timestamp using Carbon and return the desired format
        return Carbon::parse($value)->toDayDateTimeString(); // Customize the format as per your requirement
    }
}
