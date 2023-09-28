<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $appends = [
        'date_created'
    ];

    public function getDateCreatedAttribute()
    {
        return $this->created_at->format('M d, Y h:i A');
    }
}
