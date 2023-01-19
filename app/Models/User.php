<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use App\Models\Permohonan;
use App\Models\Jabatan;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey= 'usersID';
   
    protected $table = 'users';

    protected $fillable = ['nama','nokp','email','jawatan','gredKod','gredAngka','jabatan', 'taraf','jantina','password','role'];
   
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'jumlah_permohonan'
    ];

    public function permohonan()
    {
        return $this->hasMany(Permohonan::class, 'usersID', 'usersID');
    //     return $this->hasMany(Permohonan::class);//untuk one to many  1 orang tengok semua dia punya pos
    //     //return $this->hasMany(Post::'user_id','id');//sama gak nga atas...user_id nie foreign key dan id itu primary key
    }

    public function routeNotificationForMail()
    {
        return $this->email;
    }

    public function userJabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan', 'jabatan_id');
    }

    public function userJawatan()
    {
        return $this->hasOne('\App\Models\Jawatan', 'idJawatan', 'jawatan');
        // return $this->belongsTo(Jawatan::class, 'jawatan', 'idJawatan');
    }

    public function userGredAngka()
    {
        return $this->belongsTo(GredAngka::class, 'gredAngka', 'gred_angka_ID');
    }
    
    public function userGredKod()
    {
        return $this->belongsTo(GredKod::class, 'gredKod', 'gred_kod_ID');
    }

    public function getJumlahPermohonanAttribute()
    {
        $jumlah = Permohonan::where('usersID', $this->usersID)
                        ->count();
        
        return $this->attributes['jumlah_permohonan'] = $jumlah;
    }

    public function getJumlahPermohonanSemasaAttribute()
    {
        $currYear    = Carbon::now()->format('Y');

        $jumlah_semasa = Permohonan::where('usersID', $this->usersID)
                        ->whereYear('created_at', $currYear)
                        ->count();
        
        return $this->attributes['jumlah_permohonan_semasa'] = $jumlah_semasa;
    }

    public function countSideCetak()
    {
        $sideCountCetak = Permohonan::with('user')
                    ->where('statusPermohonan','=','Lulus Semakan BPSM')
                    ->count(); 
        
        return $sideCountCetak;
    }
    
}
