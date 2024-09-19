<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    public $table="postbox";
    protected $fillable=[
        'user_id',
        "title",
        "description",
        "image",
    ];
   
}