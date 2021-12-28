<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    protected $casts = [
        'date_published' => 'date',
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'details'
    ];

    public function getDetailsAttribute()
    {
        $date = Carbon::parse($this->date_published)->format('d/m/y');
        return "{$this->name} at : {$date}";
    }


    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}
