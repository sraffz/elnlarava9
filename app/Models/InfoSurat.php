<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfoSurat extends Model
{
    protected $primaryKey='info_surat_ID';

    protected $fillable=['perkara','maklumat1','maklumat2','maklumat3','maklumat4','status','created_at','updated_at'];

    protected $table = 'info_surat';

    public $timestamps = true;

}
