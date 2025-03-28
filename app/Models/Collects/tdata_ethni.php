<?php

namespace App\Models\Collects;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdata_ethni extends Model
{
    protected $fillable=['id','code_ethni','nom_ethni'];
    protected $table = 'tdata_ethni';
}
