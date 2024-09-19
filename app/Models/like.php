<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class like extends Model
{
    public $timestamps=false;
    public $table="likes";

    protected $guarded=[];
}
