<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    protected $fillable = [
        "address_line_1",
        "address_line_2",
        "city",
        "state",
        "country",
        "postal_code",
        "timezone",
        "client_id",
        "status",
    ];

    /** Start Relationships **/
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /** Start Relationships **/
}
