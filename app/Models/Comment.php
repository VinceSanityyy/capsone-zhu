<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $appends = [
        'date_created'
    ];

    protected $guarded = [
        'id'
    ];

    public function getDateCreatedAttribute()
    {
        return $this->created_at->format('M d, Y h:i A');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
