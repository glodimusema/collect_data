<?php

namespace App\Models\Collects;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdata_auteur extends Model
{
    protected $fillable=['id','code_auteur','nom_auteur'];
    protected $table = 'tdata_auteur';
}
