<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class connection extends Model
{
    public $table="connection";

    public $timestamps=false;
    public $fillable=[
        "id1",
        "id2",
        'sentBy',
        'status',
    ];

}
