<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GredKod extends Model
{
    protected $primaryKey='gred_kod_ID';

    protected $fillable=['gred_kod_abjad','gred_kod_klasifikasi','created_at','updated_at'];

    protected $table = 'gred_kod';

    public $timestamps = true;

    // public function userJabatan()
    // {
    //     return $this->belongsTo('App\User');
    // }
}
