<?php

namespace App\Models\Collects;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdata_enquete extends Model
{
    protected $fillable=['id','id_violation','id_ethni','id_genre','id_auteur','refAgent','author','refUser'];
    protected $table = 'tdata_enquete';
}
