<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GredAngka extends Model
{
    protected $primaryKey='gred_angka_ID';

    protected $fillable=['gred_angka_nombor','created_at','updated_at'];

    protected $table = 'gred_angka';

    public $timestamps = true;

    // public function userJabatan()
    // {
    //     return $this->belongsTo('App\User');
    // }
}
