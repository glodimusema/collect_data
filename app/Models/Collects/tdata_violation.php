<?php

namespace App\Models\Collects;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdata_violation extends Model
{
    protected $fillable=['id','code_violation','nom_violation'];
    protected $table = 'tdata_violation';
}
