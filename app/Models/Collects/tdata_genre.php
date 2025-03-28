<?php

namespace App\Models\Collects;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdata_genre extends Model
{
    protected $fillable=['id','code_genre','nom_genre'];
    protected $table = 'tdata_genre';
}
