<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class profileModel extends Model
{
    public $table="personal_details";
    public $timestamps=false;
    protected $guarded=[];
}
