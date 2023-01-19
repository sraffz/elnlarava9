<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jawatan extends Model
{
    protected $primaryKey='idJawatan';

    protected $fillable=['namaJawatan','statusDato','created_at','updated_at'];

    protected $table = 'jawatan';

    public $timestamps = true;

    public function userJabatan()
    {
        return $this->belongsTo('\App\Models\User', 'jawatan', 'idJawatan');
    }
}
