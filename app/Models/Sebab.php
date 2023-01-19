<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sebab extends Model
{
    protected $primaryKey='sebab_id';

    protected $fillable=['alasan','permohonansID','rombongans_id'];

    protected $table = 'sebabs';

    public $timestamps = true;

    public function sebabPermohonan()
    {
        return $this->belongsTo('\App\Models\Permohonan');
    }
}
