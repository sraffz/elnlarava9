<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Models\Permohonan;
use  App\Models\Pasangan;
use  App\Models\Rombongan;
use  App\Models\User;
use  App\Models\Dokumen;
use  App\Models\Eln_pengesahan_bahagian;
use  App\Models\Eln_kelulusan;
use DB;
use PDF;
use Auth;
use Carbon\Carbon;
use Alert;
use Illuminate\Support\Facades\Notification;

use Illuminate\Notifications\Notifiable;
use App\Notifications\SenaraiSokongan;
use App\Notifications\SenaraiSokonganRombongan;
use App\Notifications\SenaraiKelulusan;
use App\Notifications\SenaraiKelulusanRombongan;
use App\Notifications\PermohonanBerjaya;
use App\Notifications\PermohonanTidakBerjaya;
use App\Notifications\KeputusanPermohonan;
use App\Notifications\KeputusanRombongan;

class KetuaController extends Controller
{
    public function index()
    {
        $sejarah = Permohonan::whereIn('statusPermohonan', ['Permohonan Berjaya'])->get();

        // $permohonan = Permohonan::where('statusPermohonan', 'Lulus Semakan BPSM')
        //     ->whereNotIn('JenisPermohonan', ['rombongan'])
        //     ->orderBy('created_at', 'asc')
        //     ->get();

            $permohonan = DB::table('senarai_data_permohonan')
            ->whereIn('statusPermohonan', ['Lulus Semakan BPSM'])
            ->whereNotIn('JenisPermohonan', ['rombongan'])
            ->orderBy('tarikhmohon','asc')
            ->get();

            $dokumen = Dokumen::all();

        return view('ketua.senaraiPermohonan', compact('permohonan', 'sejarah', 'dokumen'));
    }

    public function senaraiLulus()
    {
        $rombongan = Rombongan::whereIn('statusPermohonanRom', ['Permohonan Berjaya', 'Permohonan Gagal'])->get();

        $allPermohonan = Permohonan::with('user')
            ->where('statusPermohonan', ['Permohonan Berjaya', 'Permohonan Gagal'])
            ->get();

        return view('ketua.senaraiDiLuluskan', compact('allPermohonan', 'rombongan'));
    }

    public function senaraiRombonganKetua()
    {
        // $rombongan = Rombongan::all();
        $allPermohonan = Permohonan::with('user')
            ->where('statusPermohonan', '!=', 'Permohonan Gagal')

            ->get();

        //$post = Permohonan::with('pasangans')->where('statusPermohonan','=','Pending')->get();   //sama gak nga many to many
        $rombongan = Rombongan::join('users', 'users.usersID', '=', 'rombongans.usersID')
            ->where('statusPermohonanRom', 'Lulus Semakan')
            ->orderBy('rombongans.created_at', 'asc')
            ->get();

        return view('ketua.senaraiRombonganKetua', compact('rombongan', 'allPermohonan'));
    }

    public function editPermohonan(Request $request)
    {
        $sebab = $request->input('sebab');
        $permohonansID = $request->input('permohonansID');
        $status = 'Permohonan Ditolak';

        Permohonan::where('permohonansID', '=', $permohonansID)->update([
            'sebabDitolak' => $sebab,
            'statusPermohonan' => $status,
            'tarikhLulusan' => \Carbon\Carbon::now(),
        ]);

        return redirect()->back();
    }

    public function hantar(Request $request, $id)
    {
        $ubah = 'Permohonan Berjaya';

        $ruj = Permohonan::where('permohonansID', $id)
            ->with('user')
            ->first();

        $userId = $ruj->usersID;

        $users = User::find($userId);

        // dd($users);
        
        $butiran = [
            'negara' => $ruj->negara,
            'tarikhMulaPerjalanan' => Carbon::parse($ruj->tarikhMulaPerjalanan)->format('d/m/Y'),
            'tarikhAkhirPerjalanan' => Carbon::parse($ruj->tarikhAkhirPerjalanan)->format('d/m/Y'),
            'nokp' => $ruj->user->nokp,
            'nama' => $ruj->user->nama
        ];
        // dd($butiran);

        Notification::send($users, new PermohonanBerjaya($butiran));
        // dd('done');

        $pengesahan = Eln_pengesahan_bahagian::where('id_permohonan', $id)->first();

        $pelulus = User::with('userJabatan')
            // ->with('userJawatan')
            ->where('usersID', '=', Auth::user()->usersID)
            ->first();

        $rujukan = Eln_kelulusan::orderBy('id', 'DESC')->first();

        if (!empty($rujukan)) {
            if ($rujukan->no_surat < 100) {
                $jld = $rujukan->jilid;
                $no = $rujukan->no_surat + 1;
            } else {
                $jld = $rujukan->jilid + 1;
                $no = 1;
            }
        } else {
            $jld = 1;
            $no = 1;
        }
        // dd($no, $jld);
        $idl = Eln_kelulusan::insertGetId([
            'id_pengesahan' => $pengesahan->id,
            'id_pelulus' => Auth::user()->usersID,
            'jawatan_pelulus' => $pelulus->userJawatan->namaJawatan,
            'gred_pelulus' => '' . $pelulus->userGredKod->gred_kod_abjad . ' ' . $pelulus->userGredAngka->gred_angka_nombor . '',
            'jabatan_pelulus' => $pelulus->userJabatan->id_jabatan,
            'ulasan' => 'tiada',
            'status_kelulusan' => 'Berjaya',
            'jilid' => $jld,
            'no_surat' => $no,
            'created_at' => \Carbon\Carbon::now(), # new \Datetime()
            'updated_at' => \Carbon\Carbon::now(), # new \Datetime()
        ]);

        
    
        // dd($tarikhMulaPerjalanan);
        Permohonan::where('permohonansID', '=', $id)->update([
            'statusPermohonan' => $ubah,
            'tarikhLulusan' => \Carbon\Carbon::now(),
        ]);

        // flash('Permohonan Diluluskan.')->success();
        toast('Permohonan Diluluskan', 'success')->position('top-end');
        return redirect()->back();
    }

    public function lulusrombongan($id)
    {
        $ubah = 'Permohonan Berjaya';

        Rombongan::where('rombongans_id', '=', $id)->update([
            'statusPermohonanRom' => $ubah,
            'tarikhStatusPermohonan' => \Carbon\Carbon::now(),
        ]);

        $pelulus = User::with('userJabatan')
            // ->with('userJawatan')
            ->where('usersID', '=', Auth::user()->usersID)
            ->first();
            
            $rujukan = Eln_kelulusan::orderBy('id', 'DESC')->first();

            if (!empty($rujukan)) {
                if ($rujukan->no_surat < 100) {
                    $jld = $rujukan->jilid;
                    $no = $rujukan->no_surat + 1;
                } else {
                    $jld = $rujukan->jilid + 1;
                    $no = 1;
                }
            } else {
                $jld = 1;
                $no = 1;
            }

        DB::table('eln_pengesahan_bahagian_rombongan')
            ->where('id_rombongan', $id)
            ->update([
                'id_pelulus' => Auth::user()->usersID,
                'jawatan_pelulus' => Auth::user()->userJawatan->namaJawatan,
                'gred_pelulus' => '' . Auth::user()->userGredKod->gred_kod_abjad . ' ' . Auth::user()->userGredAngka->gred_angka_nombor . '',
                'jabatan_pelulus' => Auth::user()->userJabatan->id_jabatan,
                'ulasan_kelulusan' => 'tiada',
                'status_kelulusan' => 'Berjaya',
                'jld_surat_rombongan' => $jld,
                'no_surat_rombongan' => $no,
                'tarikh_kelulusan' => \Carbon\Carbon::now(), # new \Datetime()
            ]);

        $senarai = DB::table('permohonans')
            ->where('rombongans_id', '=', $id)
            ->where('statusPermohonan', 'Lulus Semakan BPSM')
            ->get();
        // dd($senarai);

        foreach ($senarai as $sena) {
            $idPermohonan = $sena->permohonansID;

            $pengesahan = Eln_pengesahan_bahagian::where('id_permohonan', $idPermohonan)->first();

            Eln_kelulusan::insertGetId([
                'id_pengesahan' => $pengesahan->id,
                'id_pelulus' => Auth::user()->usersID,
                'jawatan_pelulus' => $pelulus->userJawatan->namaJawatan,
                'gred_pelulus' => '' . $pelulus->userGredKod->gred_kod_abjad . ' ' . $pelulus->userGredAngka->gred_angka_nombor . '',
                'jabatan_pelulus' => $pelulus->userJabatan->id_jabatan,
                'ulasan' => 'tiada',
                'status_kelulusan' => 'Berjaya',
                'jilid' => $jld,
                'no_surat' => $no,
                'created_at' => \Carbon\Carbon::now(), # new \Datetime()
                'updated_at' => \Carbon\Carbon::now(), # new \Datetime()
            ]);

            Permohonan::where('permohonansID', '=', $idPermohonan)->update([
                'statusPermohonan' => $ubah,
                'tarikhLulusan' => \Carbon\Carbon::now(),
            ]);
        }

        $ruj = Rombongan::where('rombongans_id', $id)->first();

        $butiran = [
            'negaraRom' => $ruj->negaraRom,
            'tarikhMulaRom' => Carbon::parse($ruj->tarikhMulaRom)->format('d/m/Y'),
            'tarikhAkhirRom' => Carbon::parse($ruj->tarikhAkhirRom)->format('d/m/Y'),
            'keputusan' => 'Diluluskan',
        ];
        $users = User::where('usersID', $ruj->usersID)->get();
        // dd($butiran);
        Notification::send($users, new KeputusanRombongan($butiran));

        toast('Permohonan Telah Diluluskan', 'success')->position('top-end');
        return back();
    }

    public function ketuaRejectRombongan($id)
    {
        $ubah = 'Permohonan Gagal';

        Rombongan::where('rombongans_id', '=', $id)->update([
            'statusPermohonanRom' => $ubah,
            'tarikhStatusPermohonan' => \Carbon\Carbon::now(),
        ]);

        $rujukan = Eln_kelulusan::orderBy('id', 'DESC')->first();

        if (!empty($rujukan)) {
            if ($rujukan->no_surat < 100) {
                $jld = $rujukan->jilid;
                $no = $rujukan->no_surat + 1;
            } else {
                $jld = $rujukan->jilid + 1;
                $no = 1;
            }
        } else {
            $jld = 1;
            $no = 1;
        }

        DB::table('eln_pengesahan_bahagian_rombongan')
            ->where('id_rombongan', $id)
            ->update([
                'id_pelulus' => Auth::user()->usersID,
                'jawatan_pelulus' => $pelulus->userJawatan->namaJawatan,
                'gred_pelulus' => '' . $pelulus->userGredKod->gred_kod_abjad . ' ' . $pelulus->userGredAngka->gred_angka_nombor . '',
                'jabatan_pelulus' => $pelulus->userJabatan->id_jabatan,
                'ulasan_kelulusan' => 'tiada',
                'status_kelulusan' => 'Gagal',
                'jld_surat_rombongan' => $jld,
                'no_surat_rombongan' => $no,
                'tarikh_kelulusan' => \Carbon\Carbon::now(), # new \Datetime()
            ]);

        $senarai = DB::table('permohonans')
            ->where('rombongans_id', '=', $id)
            ->where('statusPermohonan', 'Lulus Semakan BPSM')
            ->get();

        foreach ($senarai as $sena) {
            $idPermohonan = $sena->permohonansID;

            $pengesahan = Eln_pengesahan_bahagian::where('id_permohonan', $idPermohonan)->first();

            Eln_kelulusan::insertGetId([
                'id_pengesahan' => $pengesahan->id,
                'id_pelulus' => Auth::user()->usersID,
                'jawatan_pelulus' => $pelulus->userJawatan->namaJawatan,
                'gred_pelulus' => '' . $pelulus->userGredKod->gred_kod_abjad . ' ' . $pelulus->userGredAngka->gred_angka_nombor . '',
                'jabatan_pelulus' => $pelulus->userJabatan->id_jabatan,
                'ulasan' => 'tiada',
                'status_kelulusan' => 'Gagal',
                'jilid' => $jld,
                'no_surat' => $no,
                'created_at' => \Carbon\Carbon::now(), # new \Datetime()
                'updated_at' => \Carbon\Carbon::now(), # new \Datetime()
            ]);
            // echo $idPermohonan;
            Permohonan::where('permohonansID', '=', $idPermohonan)->update([
                'statusPermohonan' => $ubah,
                'tarikhLulusan' => \Carbon\Carbon::now(),
            ]);
        }

        $ruj = Rombongan::where('rombongans_id', $id)->first();

        $butiran = [
            'negaraRom' => $ruj->negaraRom,
            'tarikhMulaRom' => Carbon::parse($ruj->tarikhMulaRom)->format('d/m/Y'),
            'tarikhAkhirRom' => Carbon::parse($ruj->tarikhAkhirRom)->format('d/m/Y'),
            'keputusan' => 'Ditolak',
        ];
        $users = User::where('usersID', $ruj->usersID)->get();
        // dd($butiran);
        Notification::send($users, new KeputusanRombongan($butiran));

        toast('Permohonan Telah Ditolak', 'success')->position('top-end');
        return redirect()->back();
    }

    public function tolakPermohonan($id)
    {
        $ubah = 'Permohonan Gagal';

        $ruj = Permohonan::where('permohonansID', $id)
            ->with('user')
            ->first();

        $userId = $ruj->usersID;

        $users = User::find($userId);

        // dd($users);
        
        $butiran = [
            'negara' => $ruj->negara,
            'tarikhMulaPerjalanan' => Carbon::parse($ruj->tarikhMulaPerjalanan)->format('d/m/Y'),
            'tarikhAkhirPerjalanan' => Carbon::parse($ruj->tarikhAkhirPerjalanan)->format('d/m/Y'),
            'nokp' => $ruj->user->nokp,
            'nama' => $ruj->user->nama
        ];
        // dd($butiran);

        Notification::send($users, new PermohonanTidakBerjaya($butiran));

        $pengesahan = Eln_pengesahan_bahagian::where('id_permohonan', $id)->first();

        $pelulus = User::with('userJabatan')
            // ->with('userJawatan')
            ->where('usersID', '=', Auth::user()->usersID)
            ->first();

        $rujukan = Eln_kelulusan::orderBy('id', 'DESC')->first();

        if (!empty($rujukan)) {
            if ($rujukan->no_surat < 100) {
                $jld = $rujukan->jilid;
                $no = $rujukan->no_surat + 1;
            } else {
                $jld = $rujukan->jilid + 1;
                $no = 1;
            }
        } else {
            $jld = 1;
            $no = 1;
        }
        // dd($no, $jld);
        $idl = Eln_kelulusan::insertGetId([
            'id_pengesahan' => $pengesahan->id,
            'id_pelulus' => Auth::user()->usersID,
            'jawatan_pelulus' => $pelulus->userJawatan->namaJawatan,
            'gred_pelulus' => '' . $pelulus->userGredKod->gred_kod_abjad . ' ' . $pelulus->userGredAngka->gred_angka_nombor . '',
            'jabatan_pelulus' => $pelulus->userJabatan->id_jabatan,
            'ulasan' => 'tiada',
            'status_kelulusan' => 'Gagal',
            'jilid' => $jld,
            'no_surat' => $no,
            'created_at' => \Carbon\Carbon::now(), # new \Datetime()
            'updated_at' => \Carbon\Carbon::now(), # new \Datetime()
        ]);

        Permohonan::where('permohonansID', '=', $id)->update([
            'statusPermohonan' => $ubah,
            'tarikhLulusan' => \Carbon\Carbon::now(),
        ]);

        toast('Permohonan Ditolak', 'error')->position('top-end');
        return back();
    }

    public function tukarstatuskelulusan(Request $req)
    {
        $id = $req->id;

        $k = Eln_kelulusan::join('eln_pengesahan_bahagian', 'eln_pengesahan_bahagian.id', '=', 'eln_kelulusan.id_pengesahan')
        ->where('eln_kelulusan.id', $id)
        ->first();
        
        if ($k->status_kelulusan == 'Berjaya') {
            $status = 'Gagal';
            $status2 = 'Permohonan Gagal';
        } else {
            $status = 'Berjaya';
            $status2 = 'Permohonan Berjaya';
        }

        Permohonan::where('permohonansID', $k->id_permohonan)
        ->update([
            'statusPermohonan' => $status2,
        ]);

        Eln_kelulusan::where('id', $id)->update([
            'status_kelulusan' => $status,
        ]);

        // flash('Status Kelulusan berjaya ditukar')->success();
        toast('Status Permohonan Ditukar', 'info')->position('top-end');
        return back();
    }

    public function ubahstatusrombongan(Request $req)
    {
        $id = $req->id;
        
        $k= Rombongan::where('rombongans_id', $id)->first();

        if ($k->statusPermohonanRom == 'Permohonan Berjaya') {
            $status = 'Gagal';
            $status2 = 'Permohonan Gagal';
        } else {
            $status = 'Berjaya';
            $status2 = 'Permohonan Berjaya';
        }

        Rombongan::where('rombongans_id', $id)
        ->update([
            'statusPermohonanRom' => $status2,
        ]);

        DB::table('eln_pengesahan_bahagian_rombongan')
        ->where('id_rombongan', $id)
        ->update([
            'status_kelulusan' => $status,
        ]);

        // flash('Status Kelulusan berjaya ditukar')->success();
        toast('Status Permohonan Ditukar', 'info')->position('top-end');
        return back();
    }

    public function tukarstatussekongan(Request $req)
    {
        $id = $req->id;
// dd($id);
        $k = Eln_pengesahan_bahagian::where('id', $id)->first();

        if ($k->status_pengesah == 'disokong') {
            $status = 'ditolak';
        } else {
            $status = 'disokong';
        }

        Eln_pengesahan_bahagian::where('id', $id)->update([
            'status_pengesah' => $status,
        ]);

        // flash('Status Kelulusan berjaya ditukar')->success();
        Alert::success('Berjaya', 'Maklumat dikemaskini');
        return back();
    }

    public function permohonanGagalKetua($id)
    {
        $ubah = 'Permohonan Gagal';

        Permohonan::where('permohonansID', '=', $id)->update([
            'statusPermohonan' => $ubah,
            'tarikhLulusan' => \Carbon\Carbon::now(),
        ]);

        flash('Permohonan Gagal.')->success();
        return redirect()->back();
    }

    public function jumlahKeluarnegara()
    {
        $senaraiPermohonan = Permohonan::where('statusPermohonan', 'Permohonan Berjaya')->get();

        $senaraiPengguna = Permohonan::where('statusPermohonan', 'Permohonan Berjaya')
            ->distinct()
            ->with('user')
            ->get(['usersID']);

        // dd($senaraiPengguna);
        return view('ketua.jumlahKeLuarnegara', compact('senaraiPermohonan', 'senaraiPengguna'));
    }

    public function cetakRombongan($id)
    {
        $permohonan = Rombongan::select('users.*', 'rombongans.*', 'rombongans.created_at as tarikhmohon', 'gred_angka.*', 'gred_kod.*', 'jawatan.*')
            ->join('users', 'users.usersID', '=', 'rombongans.usersID')
            ->leftjoin('gred_angka', 'users.gredAngka', '=', 'gred_angka.gred_angka_ID')
            ->leftjoin('gred_kod', 'users.gredKod', '=', 'gred_kod.gred_kod_ID')
            ->leftjoin('jawatan', 'users.jawatan', '=', 'jawatan.idJawatan')
            ->where('rombongans.rombongans_id', $id)
            ->first();

        $dokumen = DB::table('dokumens')
            ->where('permohonansID', '=', $id)
            ->get();

        $tarikhmohon = $permohonan->tarikhmohon;
        $mula = Carbon::parse($permohonan->tarikhMulaRom);
        $akhir = Carbon::parse($permohonan->tarikhAkhirRom);
        $jumlahDate = $mula->diffInDays($akhir);

        \Carbon\Carbon::setLocale('ms-MY');

        $pengesahan = DB::table('eln_pengesahan_bahagian_rombongan')
        ->join('users', 'users.usersID','=', 'eln_pengesahan_bahagian_rombongan.id_pengesah')
        ->join('jabatan', 'jabatan.jabatan_id','=', 'eln_pengesahan_bahagian_rombongan.jabatan_pengesah')
        ->where('id_rombongan', $id)
        ->first();

        $allPermohonan = DB::table('senarai_data_permohonan')
            ->where('rombongans_id', $id)
            ->whereIn('statusPermohonan', ['Lulus Semakan BPSM'])
            ->get();

        // return view('ketua.cetak.cetak-butiran-rombongan', compact('permohonan', 'tarikhmohon', 'jumlahDate', 'allPermohonan', 'dokumen', 'pengesahan'));
        $pdf = PDF::loadView('ketua.cetak.cetak-butiran-rombongan', compact('permohonan', 'tarikhmohon', 'jumlahDate', 'allPermohonan', 'dokumen', 'pengesahan'))->setpaper('a4', 'potrait');
        return $pdf->download('Borang Permohonan Rombongan Ke Luar Negara.pdf');
    }

    public function cetakPermohonan($id)
    {
        $sej = Permohonan::where('permohonansID', $id)->first();

        // $sejarah = Permohonan::whereIn('statusPermohonan', ['Permohonan Berjaya'])
        //     ->where('usersID', $sej->usersID)
        //     ->get();

            $sejarah = Permohonan::where('permohonans.usersID', $sej->usersID)
            ->leftjoin('rombongans', 'rombongans.rombongans_id', '=', 'permohonans.rombongans_id')
            ->whereIn('permohonans.statusPermohonan', ['Permohonan Berjaya'])
            ->get();

        // return dd($sejarah);
        $pengesah = Eln_pengesahan_bahagian::select('users.*', 'eln_pengesahan_bahagian.*', 'jabatan.nama_jabatan', 'eln_pengesahan_bahagian.created_at as tarikhsah')
            ->join('users', 'users.usersID', '=', 'eln_pengesahan_bahagian.id_pengesah')
            ->join('jabatan', 'jabatan.jabatan_id', '=', 'eln_pengesahan_bahagian.jabatan_pengesah')
            ->where('eln_pengesahan_bahagian.id_permohonan', $id)
            ->get();

        $permohonan = Permohonan::find($id);
        $pasangan = Pasangan::where('permohonansID', $id)->get();
        $dokumen = DB::table('dokumens')
            ->where('permohonansID', '=', $id)
            ->get();

        $mula = Carbon::parse($permohonan->tarikhMulaPerjalanan);
        $akhir = Carbon::parse($permohonan->tarikhAkhirPerjalanan);
        $jumlahDate = $mula->diffInDays($akhir);

        $mulaCuti = Carbon::parse($permohonan->tarikhMulaCuti);
        $akhirCuti = Carbon::parse($permohonan->tarikhAkhirCuti);
        $jumlahDateCuti = $mulaCuti->diffInDays($akhirCuti);

        // return view('ketua.cetak.cetak-butiran-permohonan', compact('pengesah', 'sejarah', 'permohonan', 'pasangan', 'jumlahDate', 'jumlahDateCuti', 'dokumen'));
        $pdf = PDF::loadView('ketua.cetak.cetak-butiran-permohonan', compact('pengesah', 'sejarah', 'permohonan', 'pasangan', 'jumlahDate', 'jumlahDateCuti', 'dokumen'))->setpaper('a4', 'potrait');
        return $pdf->download('Borang Permohonan Ke Luar Negara.pdf');
    }

    public function cetakSenarairombongan()
    {
        $allPermohonan = Permohonan::with('user')
            ->where('statusPermohonan', '!=', 'Permohonan Gagal')
            ->get();

        $jab = Auth::user()->jabatan;

        if (Auth::user()->role == 'DatoSUK') {
            // $rombongan = Rombongan::join('users', 'users.usersID', '=', 'rombongans.usersID')
            //     ->where('statusPermohonanRom', 'Lulus Semakan')
            //     ->get();

            $rombongan = Rombongan::select('users.*', 'rombongans.*', 'rombongans.created_at as tarikmohon')
                ->leftjoin('users', 'users.usersID', '=', 'rombongans.usersID')
                ->whereIn('statusPermohonanRom', ['Lulus Semakan'])
                ->orderBy('rombongans.created_at', 'asc')
                ->get();
        } elseif (Auth::user()->role == 'jabatan') {
            // $rombongan = Rombongan::join('users', 'users.usersID', '=', 'rombongans.usersID')
            //     ->where('statusPermohonanRom', 'Pending')
            //     ->where('users.jabatan', Auth::user()->jabatan)
            //     ->get();
            if ($jab == 44) {
                $rombongan = Rombongan::select('users.*', 'rombongans.*', 'rombongans.created_at as tarikmohon')
                    ->leftjoin('users', 'users.usersID', '=', 'rombongans.usersID')
                    ->whereIn('statusPermohonanRom', ['Pending'])
                    ->whereIn('users.jabatan', [44, 37])
                    ->orderBy('rombongans.created_at', 'asc')
                    ->get();
            } else {
                $rombongan = Rombongan::select('users.*', 'rombongans.*', 'rombongans.created_at as tarikmohon')
                    ->leftjoin('users', 'users.usersID', '=', 'rombongans.usersID')
                    ->whereIn('statusPermohonanRom', ['Pending'])
                    ->where('users.jabatan', $jab)
                    ->orderBy('rombongans.created_at', 'asc')
                    ->get();
            }
        }

        // dd($rombongan);
        $allPermohonan = Permohonan::with('user')
            ->whereNotIn('statusPermohonan', ['Permohonan Gagal'])
            ->get();

        // return view('ketua.cetak.cetak-senarai-rombongan', compact('rombongan', 'allPermohonan'));

        $pdf = PDF::loadView('ketua.cetak.cetak-senarai-rombongan', compact('rombongan', 'allPermohonan'))->setpaper('a4', 'landscape');
        return $pdf->download('Senarai Permohonan Rombongan Ke Luar Negara.pdf');
    }

    public function cetakSenaraiPermohonan()
    {
        $sejarah = Permohonan::whereIn('statusPermohonan', ['Permohonan Berjaya', 'Permohonan Gagal'])->get();

        if (Auth::user()->role == 'DatoSUK') {
            // $permohonan = Permohonan::select('permohonans.*', 'permohonans.created_at as tarikhmohon')
            // ->where('statusPermohonan', 'Lulus Semakan BPSM')
            //     ->whereNotIn('JenisPermohonan', ['rombongan'])
            //     ->get();

                $permohonan = DB::table('senarai_data_permohonan')
                ->whereIn('statusPermohonan', ['Lulus Semakan BPSM'])
                ->whereNotIn('JenisPermohonan', ['rombongan'])
                ->orderBy('tarikhmohon','asc')
                ->get();
                // $permohonan = Permohonan::select('permohonans.*', 'users.*', 'permohonans.created_at as tarikhmohon')
                //         ->join('users', 'permohonans.usersID', '=', 'users.usersID')
                //         ->where('users.jabatan', $jab)
                //         ->whereIn('statusPermohonan', ['Ketua Jabatan'])
                //         ->orderBy('permohonans.created_at','asc')
                //         ->get();

        } elseif (Auth::user()->role == 'jabatan') {
            $jab = Auth::user()->jabatan;
            // echo $jab;
            if ($jab == 38) {
                $permohonan = DB::table('senarai_data_permohonan')
                ->where('statusPermohonan', 'Ketua Jabatan')
                ->Where('jabatan', $jab)
                // ->Where('stsukpem', ['1'])
                ->orWhere(function ($query) {
                    $query->where('statusPermohonan', 'Ketua Jabatan')
                    ->Where('stsukpem', 1);
                })
                ->orderBy('tarikhmohon','asc')
                ->get();
            } elseif  ($jab == 39) {
                $permohonan = DB::table('senarai_data_permohonan')
                ->whereIn('statusPermohonan', ['Ketua Jabatan'])
                ->Where('jabatan', $jab)
                ->orWhere(function ($query) {
                    $query->where('statusPermohonan', 'Ketua Jabatan')
                    ->Where('stsukpen', 1);
                })
                ->orderBy('tarikhmohon','asc')
                ->get();
            } else {
                $permohonan = DB::table('senarai_data_permohonan')
                ->whereIn('statusPermohonan', ['Ketua Jabatan'])
                ->where('jabatan', $jab)
                ->whereNotIn('role', ['jabatan'])
                ->orderBy('tarikhmohon','asc')
                ->get();
            }

            // if ($jab == 44) {
            //     $permohonan = Permohonan::select('permohonans.*', 'users.*', 'permohonans.created_at as tarikhmohon')
            //         ->join('users', 'permohonans.usersID', '=', 'users.usersID')
            //         ->whereIn('users.jabatan', [44, 37])
            //         ->whereIn('statusPermohonan', ['Ketua Jabatan'])
            //         ->orderBy('permohonans.created_at','asc')
            //         ->get();
            // } else {
            //     $permohonan = Permohonan::select('permohonans.*', 'users.*', 'permohonans.created_at as tarikhmohon')
            //         ->join('users', 'permohonans.usersID', '=', 'users.usersID')
            //         ->where('users.jabatan', $jab)
            //         ->whereIn('statusPermohonan', ['Ketua Jabatan'])
            //         ->orderBy('permohonans.created_at','asc')
            //         ->get();
            // }

            // $permohonan = Permohonan::join('users', 'users.usersID', '=', 'permohonans.usersID')
            //     ->where('statusPermohonan', 'Ketua Jabatan')
            //     ->where('users.jabatan', Auth::user()->jabatan)
            //     ->get();
        }
        // return dd($permohonan);
        // return view('ketua.cetak.cetak-senarai-permohonan', compact('permohonan'));

        $pdf = PDF::loadview('ketua.cetak.cetak-senarai-permohonan', compact('permohonan'))->setpaper('a4', 'landscape');
        return $pdf->download('Senarai Permohonan Individu Ke Luar Negara.pdf');
    }
}
