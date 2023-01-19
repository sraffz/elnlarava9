<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasangan extends Model
{
    protected $primaryKey='pasangansID';

    protected $fillable=['namaPasangan','hubungan','alamatPasangan','phonePasangan','emailPasangan','permohonansID'];

    protected $table = 'pasangans';

    public $timestamps = true;

    public function userPasangan()
    {
    	return $this->hasMany(\App\Models\Permohonan::class,'permohonansID','permohonansID');
    }
}
