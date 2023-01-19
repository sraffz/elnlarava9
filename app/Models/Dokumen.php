<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    protected $primaryKey='dokumens_id';

    protected $fillable=['namaFile','typeFile','pathFile','permohonansID','rombongans_id'];

    protected $table = 'dokumens';

    public $timestamps = true;

    public function dokumenMilikPermohonan()
    {
        return $this->belongsTo('\App\Models\Permohonan');
    }
}
