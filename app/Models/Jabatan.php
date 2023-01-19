<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $primaryKey='jabatan_id';

    protected $fillable=['nama_jabatan','kod_jabatan'];

    protected $table = 'jabatan';

    public $timestamps = true;

    // public function userJabatan()
    // {
    //     return $this->belongsTo('App\User');
    // }
}
