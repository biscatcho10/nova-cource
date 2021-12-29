<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;



class Post extends Model implements TranslatableContract
{
    use Translatable;
    protected $guarded = [];

    public $translatedAttributes = ['name', 'description'];


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
