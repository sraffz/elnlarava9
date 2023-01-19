<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Negara extends Model
{
    protected $table = 'negaras';
    protected $primaryKey = 'negaras_id';
    protected $fillable = ['namaNegara'];
    public $timestamps = true;
}
