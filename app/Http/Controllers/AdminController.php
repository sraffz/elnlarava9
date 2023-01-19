<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;
use App\Models\Pasangan;
use App\Models\Rombongan;
use App\Models\Sebab;
use App\Models\Dokumen;
use App\Models\Negara;
use App\Models\User;
use App\Models\Jabatan;
use App\Models\Jawatan;
use App\Models\GredAngka;
use App\Models\GredKod;
use App\Models\InfoSurat;
use App\Models\Eln_pengesahan_bahagian;
use App\Models\Eln_kelulusan;
use DB;
use Carbon\Carbon;
use File;
use PDF;
use Session;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;
use Auth;
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

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $permohonan = Permohonan::all();
        //$post = Permohonan::with('pasangans')->where('statusPermohonan','=','Pending')->get();   //sama gak nga many to many
        if (Auth::user()->role == 'adminBPSM') {
            $permohonan2 = Permohonan::join('users', 'users.usersID', '=', 'permohonans.usersID')
                ->leftjoin('jabatan', 'jabatan.jabatan_id','=' ,'users.jabatan')
                ->whereNull('rombongans_id')
                ->whereIn('statusPermohonan', ['Lulus Semakan BPSM', 'Lulus Semakkan ketua Jabatan'])
                ->get();
        } elseif (Auth::user()->role == 'jabatan') {
            $permohonan2 = Permohonan::join('users', 'users.usersID', '=', 'permohonans.usersID')
                ->whereNull('rombongans_id')
                ->where('users.jabatan', Auth::user()->jabatan)
                ->whereIn('statusPermohonan', ['Lulus Semakan BPSM', 'Lulus Semakkan ketua Jabatan'])
                ->get();
        }

        // $permohonan2 = DB::table('senarai_rekod_permohonan_suk')
        // ->whereNotIn('jenisPermohonan', ['rombongan'])
        // ->orderBy('tarikh_permohonan', 'desc')
        // ->get();

        //dd($permohonan);
        return view('admin.senaraiPending', compact('permohonan', 'permohonan2'));
    }

    public function profil()
    {
        $jabatan = Jabatan::orderBy('nama_jabatan', 'asc')->get();
        $gredAngka = GredAngka::all();
        $gredKod = GredKod::all();
        $jawatan = Jawatan::orderBy('namaJawatan', 'asc')->get();

        $user = User::with('userJabatan')
            // ->with('userJawatan')
            ->where('usersID', '=', Auth::user()->usersID)
            ->first();

        $nega = Permohonan::where('usersID', Auth::user()->usersID)->get();
        $negaRom = Rombongan::where('usersID', Auth::user()->usersID)->get();

        $senaraiNegara = $nega->where('statusPermohonan', 'Permohonan Berjaya')->pluck('negara');

        $senaraiNegaraRom = $negaRom->where('statusPermohonanRom', 'Permohonan Berjaya')->pluck('negaraRom');
        // dd($senaraiNegara);
        return view('profil', compact('user', 'senaraiNegara', 'senaraiNegaraRom', 'jabatan', 'gredAngka', 'gredKod', 'jawatan'));
    }

    public function kemaskiniprofil(Request $req)
    {
        $user = User::where('usersID', Auth::user()->usersID)->first();

        if ($user->jabatan != $req->input('jabatan')) {
             User::where('usersID', Auth::user()->usersID)->update([
                'nama' => $req->input('nama'),
                'nokp' => $req->input('kp'),
                'email' => $req->input('email'),
                'jawatan' => $req->input('jawatan'),
                'jabatan' => $req->input('jabatan'),
                'gredKod' => $req->input('gredKod'),
                'taraf' => $req->input('taraf'),
                'gredAngka' => $req->input('gredangka'),
                'role' => 'pengguna',
            ]);
        } else {
             User::where('usersID', Auth::user()->usersID)->update([
                'nama' => $req->input('nama'),
                'nokp' => $req->input('kp'),
                'email' => $req->input('email'),
                'jawatan' => $req->input('jawatan'),
                'jabatan' => $req->input('jabatan'),
                'gredKod' => $req->input('gredKod'),
                'taraf' => $req->input('taraf'),
                'gredAngka' => $req->input('gredangka'),
            ]);
        }
        
        // $user->role == 'pengguna'
        // Session::flash('message', 'Berjaya dikemaskini.');
        toast('Berjaya dikemaskini', 'success')->position('top-end');
        return back();
    }

    public function kemaskinikatalaluan(Request $req)
    {
        $req->validate([
            'password' => ['required', new MatchOldPassword()],
            'newpassword' => ['required'],
            'confirmpassword' => ['same:newpassword'],
        ]);

        User::where('usersID', Auth::user()->usersID)->update([
            'password' => Hash::make($req->newpassword),
        ]);

        // Session::flash('message', 'Kata laluan berjaya ditukar.');
        toast('Kata laluan berjaya ditukar', 'success')->position('top-end');

        return back();
    }

    public function senaraiRekodIndividu()
    {
        // $permohonan = Permohonan::all();
        //$post = Permohonan::with('pasangans')->where('statusPermohonan','=','Pending')->get();   //sama gak nga many to many
        // $permohonan = Permohonan::with('user')
        //     ->whereNull('rombongans_id')
        //     ->whereIn('statusPermohonan', ['Permohonan Berjaya', 'Permohonan Gagal'])
        //     ->orderBy('created_at', 'desc')
        //     ->get();

        $permohonan2 = DB::table('senarai_rekod_permohonan_suk')
        ->whereIn('status_kelulusan', ['Berjaya', 'Gagal'])
        ->whereNotIn('jenisPermohonan', ['rombongan'])
        ->orderBy('tarikh_permohonan', 'desc')
        ->get();

        return view('admin.senaraiPending', compact('permohonan2'));
    }

    public function indexRombongan()
    {
        $jab = Auth::user()->jabatan;

        if (Auth::user()->role == 'adminBPSM') {
            $rombongan = Rombongan::select('users.*', 'rombongans.*', 'rombongans.created_at as tarikmohon')
            ->leftjoin('users', 'users.usersID', '=', 'rombongans.usersID')
                ->whereIn('statusPermohonanRom', ['Pending'])
                ->orderBy('rombongans.created_at','asc')
                ->get();

        } elseif (Auth::user()->role == 'jabatan') {

                $rombongan = Rombongan::select('users.*','jabatan.*', 'rombongans.*', 'rombongans.created_at as tarikmohon')
                    ->leftjoin('users', 'users.usersID', '=', 'rombongans.usersID')
                    ->leftjoin('jabatan', 'jabatan.jabatan_id', '=', 'users.jabatan')
                    ->whereIn('statusPermohonanRom', ['Pending'])
                    ->where('users.jabatan', $jab)
                    ->orderBy('rombongans.created_at','asc')
                    ->get();
            
        }

        // dd($rombongan);
            $allPermohonan = Permohonan::select('users.*', 'jabatan.nama_jabatan', 'jawatan.namaJawatan', 'permohonans.*', 'eln_pengesahan_bahagian.id as id_pengesahan')
                ->join('users', 'users.usersID', '=', 'permohonans.usersID' )
                ->leftjoin('jabatan', 'jabatan.jabatan_id', '=', 'users.jabatan')
                ->leftjoin('eln_pengesahan_bahagian', 'eln_pengesahan_bahagian.id_permohonan', '=', 'permohonans.permohonansID')
                ->leftjoin('jawatan', 'jawatan.idJawatan', '=', 'users.jawatan')
                ->whereNotIn('permohonans.statusPermohonan', ['Permohonan Gagal'])
                ->get();
            
                $dokumen = Dokumen::all();

            // dd($allPermohonan);

            if (Auth::user()->role == 'adminBPSM'){
                return view('admin.senaraiPendingRombongan', compact('rombongan', 'allPermohonan', 'dokumen'));
            } elseif (Auth::user()->role == 'jabatan') {
                return view('jabatan.senaraiPendingRombongan', compact('rombongan', 'allPermohonan', 'dokumen'));

            }
    }

    public function senaraiRekodRombongan()
    {

        $rombongan = DB::table('senarai_data_permohonan_rombongan')
        ->whereIn('status_kelulusan', ['Berjaya', 'Gagal'])->get();

            if (Auth::user()->role == "DatoSUK") {

                $allPermohonan = DB::table('senarai_nama_rombongan')
                ->whereIn('status_kelulusan', ['Berjaya', 'Gagal'])
                ->where('status_pengesah', 'disokong')
                ->get();

            }
            elseif(Auth::user()->role == "adminBPSM"){
                // $allPermohonan = Permohonan::with('user')
                // ->get();
                $allPermohonan = DB::table('senarai_nama_rombongan')
                ->whereIn('status_kelulusan', ['Berjaya', 'Gagal'])
                ->where('status_pengesah', 'disokong')
                ->get();

                $billPermohonan = Permohonan::with('user')
                ->where('statusPermohonan', ['Permohonan Berjaya'])
                ->count();
            } else {
                return view('/');
            }
            
        return view('admin.rekod-rombongan', compact('rombongan', 'allPermohonan', 'billPermohonan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function carian()
    {
        $negara = Negara::all();
        
        return view('admin/carian', compact('negara'));
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function procarian(Request $request)
    {
        $tarikhPermo = $request->input('tarikhPermohonan');
        // $tarikhSurat= $request -> input('tarikhSurat');
        $jabatan = $request->input('jabatan');
        $nama = $request->input('nama');
        $tempat = $request->input('tempat');
        $status = $request->input('status');
        // $tempoh= $request -> input('tempoh');
        $jenisKewanganRom = $request->input('jenisKewanganRom');
        $D = '%d';
        $M = '%m';
        $Y = '%Y';
        $and = 'AND';
        //echo $tarikhPermo;

        if ($tarikhPermo == '') {
            $tarikhPermo1 = '';
        } else {
            $tarikhPermo1 = "DATE_FORMAT(permohonans.created_at,'$M/$D/$Y')='$tarikhPermo' $and";
        }

        if ($jenisKewanganRom == '') {
            $jenisKewanganRom1 = '';
        } else {
            $jenisKewanganRom1 = "permohonans.jenisKewangan = '$jenisKewanganRom' $and";
        }

        if ($jabatan == '') {
            $jabatan1 = '';
        } else {
            $jabatan1 = "users.jabatan = '$jabatan' $and";
        }

        if ($tempat == '') {
            $tempat1 = '';
        } else {
            $tempat1 = "permohonans.negara = '$tempat' $and";
        }

        if ($status == '') {
            $status1 = '';
        } else {
            $status1 = "permohonans.statusPermohonan = '$status' $and";
        }

        if ($nama == '') {
            $nama1 = '';
        } else {
            $nama1 = "users.nama LIKE '%$nama%' AND";
        }

        // $a="select * from permohonans where ".$tempat1.$status1;
        $a = "select * from permohonans,users where $tarikhPermo1 $jabatan1 $tempat1 $status1 $jenisKewanganRom1 $nama1 permohonans.usersID=users.usersID";
        //echo $a;
        $permohon = DB::select($a);
        // dd($permohon);
        return view('admin.senaraiCarian', compact('permohon'));
    }

    public function store(Request $request)
    {
        //
    }

    public function editPaparanRombongan($id)
    {
        $negara = Negara::all();

        $rombongan = Rombongan::where('rombongans_id', $id)->get();

        $dokumen = DB::table('dokumens')
            ->where('rombongans_id', $id)
            ->get();

        $peserta = Permohonan::with('user')
            ->where('rombongans_id', $id)
            ->get();

        return view('pengguna.kemaskini-permohonan', compact('negara', 'rombongan', 'dokumen', 'peserta'));
    }

    public function kemaskinirombongan(Request $req)
    {
        $id = $req->input('id');

        Rombongan::where('rombongans_id', $id)->update([
            'tarikhInsuranRom' => Carbon::parse($req->input('tarikhInsuranRom'))->format('Y-m-d'),
            'tarikhMulaRom' => Carbon::parse($req->input('tarikhmula'))->format('Y-m-d'),
            'tarikhAkhirRom' => Carbon::parse($req->input('tarikhakhir'))->format('Y-m-d'),
            'negaraRom' => $req->input('negaraRom'),
            'tujuanRom' => $req->input('tujuanRom'),
            'catatan_permohonan' => $req->input('catatan_permohonan'),
            'jenis_rombongan' => $req->input('jenis_rombongan'),
            'jenisKewanganRom' => $req->input('jenisKewanganRom'),
            'anggaranBelanja' => $req->input('anggaranBelanja'),
            'alamatRom' => $req->input('alamatRom'),
            'alamatRom' => $req->input('alamatRom'),
        ]);

        if ($req->input('jenis_rombongan') == 'Rasmi') {
             if ($req->hasFile('fileRasmiRom')) {
                $files = $req->file('fileRasmiRom');
                
                foreach ($files as $file) {
                    $filename = $file->hashName();
                    $extension = $file->getClientOriginalExtension();
        
                    if ($extension == 'pdf' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'docx' || $extension == 'JPG') {
                        $currYear = Carbon::now()->format('Y');
                        $storagePath = 'upload/dokumen/' . $currYear. '/rombongan/rasmi/' .$id.'';
                        $filePath = str_replace(base_path() . '/', '', $storagePath) . '/' . $filename;
        
                        $upload_success = $file->storeAs($storagePath, $filename);
        
                        if ($upload_success) {
                            $perm = Dokumen::where('rombongans_id',$id)->first();
                            if (empty($perm->pathFile)) {
                                $data = [
                                    'namaFile' => $filename,
                                    'typeFile' => $extension,
                                    'pathFile' => $filePath,
                                    'rombongans_id' => $id,
                                    'created_at' => \Carbon\Carbon::now(), # \Datetime()
                                    'updated_at' => \Carbon\Carbon::now(), # \Datetime()
                                ];
                                Dokumen::create($data);
                            } else {
                                Storage::Delete($perm->pathFile);
        
                                Dokumen::where('rombongans_id', $id)->update([
                                    'namaFile' => $filename,
                                    'typeFile' => $extension,
                                    'pathFile' => $filePath,
                                    'created_at' => \Carbon\Carbon::now(), # \Datetime()
                                    'updated_at' => \Carbon\Carbon::now(), # \Datetime()
                                ]);
                            }
                        } else {
                            Flash::error('Error uploading ' . $doc_type);
                            return redirect('');
                        }
                    } else {
                        echo '<div class="alert alert-warning"><strong>Warning!</strong> Sorry Only Upload png , jpg , doc</div>';
                        return redirect('');
                    }
                }
            }
        }

        // flash('Maklumat dikemaskini.')->success();
        toast('Maklumat dikemaskini', 'success')->position('top-end');

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $permohonan = Permohonan::find($id);
        $permohonan = DB::table('butiran_permohonan')
        ->where('permohonansID', $id)
        ->first();

        $sej = Permohonan::where('permohonansID', $id)->first();
        
        $sejarah = Permohonan::where('permohonans.usersID', $sej->usersID)
            ->leftjoin('rombongans', 'rombongans.rombongans_id', '=', 'permohonans.rombongans_id')
            ->whereIn('permohonans.statusPermohonan', ['Permohonan Berjaya'])
            ->get();

        $pasangan = Pasangan::where('permohonansID', $id)->get();
        $dokumen = DB::table('dokumens')
            ->where('permohonansID', '=', $id)
            ->get();

        $dokumen_sokongan = DB::table('dokumen_sokongan')
            ->where('permohonansID', '=', $id)
            ->get();

        $mula = Carbon::parse($permohonan->tarikhMulaPerjalanan);
        $akhir = Carbon::parse($permohonan->tarikhAkhirPerjalanan);
        $jumlahDate = $mula->diffInDays($akhir);

        $mulaCuti = Carbon::parse($permohonan->tarikhMulaCuti);
        $akhirCuti = Carbon::parse($permohonan->tarikhAkhirCuti);
        $jumlahDateCuti = $mulaCuti->diffInDays($akhirCuti);

        return view('admin.detailPermohonan', compact('sejarah','permohonan','pasangan', 'dokumen_sokongan','jumlahDate', 'jumlahDateCuti', 'dokumen'));
    }
    
    public function pesertaRombongan()
    {
        $peserta = Permohonan::join('users', 'users.usersID', '=', 'permohonans.usersID')
            ->leftjoin('jabatan', 'jabatan.jabatan_id', '=', 'users.jabatan')
            ->leftjoin('eln_pengesahan_bahagian', 'eln_pengesahan_bahagian.id_permohonan', '=', 'permohonans.permohonansID')
            ->leftjoin('eln_kelulusan', 'eln_kelulusan.id_pengesahan', '=', 'eln_pengesahan_bahagian.id')
            ->where('permohonans.rombongans_id', $id)
            // ->whereIn('statusPermohonan',['Lulus Semakan BPSM'])
            ->get();

            return response()->json([
                'peser' => $peserta,
            ]);
    }

    public function showRombongan($id)
    {
        $rombongan = Rombongan::leftjoin('users', 'users.usersID', '=', 'rombongans.ketua_rombongan')
            ->where('rombongans_id', $id)
            ->get();

        foreach ($rombongan as $rombo) {
            $mula = Carbon::parse($rombo->tarikhMulaRom);
            $akhir = Carbon::parse($rombo->tarikhAkhirRom);
            $jumlahDate = $mula->diffInDays($akhir);
        }

        $peserta = Permohonan::select('permohonans.*','users.*', 'jabatan.*', 'eln_pengesahan_bahagian.*', 'eln_kelulusan.*', 'eln_kelulusan.id as id_pelulus' )
            ->join('users', 'users.usersID', '=', 'permohonans.usersID')
            ->leftjoin('jabatan', 'jabatan.jabatan_id', '=', 'users.jabatan')
            ->leftjoin('eln_pengesahan_bahagian', 'eln_pengesahan_bahagian.id_permohonan', '=', 'permohonans.permohonansID')
            ->leftjoin('eln_kelulusan', 'eln_kelulusan.id_pengesahan', '=', 'eln_pengesahan_bahagian.id')
            ->where('permohonans.rombongans_id', $id)
            // ->whereIn('statusPermohonan',['Lulus Semakan BPSM'])
            ->get();

            
        
        $dokumen = DB::table('dokumens')
            ->where('rombongans_id', '=', $id)
            ->first();
        // dd($dokumen);

        // $sah = Eln_pengesahan_bahagian::all();
        // $lulus = Eln_kelulusan::all();

        // return dd($peserta);

        return view('admin.detailPermohonanRombongan', compact('rombongan', 'id', 'jumlahDate', 'peserta', 'dokumen'));
    }

    public function download($id)
    {
        $permohonan = Permohonan::find($id);
        $extension = $permohonan->jenisFileCuti;
        $path = $permohonan->pathFileCuti;

        return Storage::download($path, 'Dokumen Cuti.'.$extension.'');
    }
    
    public function downloadDokumen($id)
    {
        $dokumen = Dokumen::find($id);
        // $path = $dokumen->namaFile;
        $path = $dokumen->pathFile;

        $extension = $dokumen->typeFile;

        // return dd($path);
        return Storage::download($path, 'Dokumen Rasmi.'.$extension.'');
    }
    
    public function downloadDokumensokongan($id)
    {
        $dokumen = DB::table('dokumen_sokongan')->where('dokumens_id_sokongan', $id)->first();
        // $path = $dokumen->namaFile;
        $path = $dokumen->pathFile_sokongan;

        $extension = $dokumen->typeFile_sokongan;

        // return dd($path);
        return Storage::download($path, 'Dokumen Rasmi.'.$extension.'');
    }

    public function gambar($name)
    {
        $extension = File::extension($name);
        $path = public_path('storage/' . $name);
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header('Content-Type', $type);
        return $response;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     //
    // }

    public function hantar($id)
    {
        $ubah = 'Lulus Semakan BPSM';

        Permohonan::where('permohonansID', $id)->update(['statusPermohonan' => $ubah]);

        toast('Permohonan disokong', 'success')->position('top-end');
        return redirect()->back();
    }

    public function hantarRombo($id)
    {
      
        $list = Rombongan::where('rombongans_id', $id)
        ->first();

        $userid = $list->usersID;

        $data = Permohonan::where('usersID', $userid)
        ->where('rombongans_id', $id)
        ->first();

        $id_permohonan = $data->permohonansID;

        $pemohon = User::with('userJabatan')
            ->where('usersID', $userid)
            ->first();

        $pengesah = User::with('userJabatan')
            ->where('usersID', '=', Auth::user()->usersID)
            ->first();

        Eln_pengesahan_bahagian::insertGetId( [
            'id_permohonan' => $id_permohonan,
            'id_rombongan' => $id,
            'id_pemohon' => $userid,
            'jawatan_pemohon' => $pemohon->userJawatan->namaJawatan,
            'gred_pemohon' => ''.$pemohon->userGredKod->gred_kod_abjad.' '.$pemohon->userGredAngka->gred_angka_nombor.'',
            'jabatan_pemohon' => $pemohon->userJabatan->jabatan_id,
            'taraf_pemohon' => $pemohon->taraf,
            'id_pengesah' => Auth::user()->usersID,
            'jawatan_pengesah' => $pengesah->userJawatan->namaJawatan,
            'gred_pengesah' => ''.$pengesah->userGredKod->gred_kod_abjad.' '.$pengesah->userGredAngka->gred_angka_nombor.'',
            'jabatan_pengesah' => $pengesah->userJabatan->jabatan_id,
            'ulasan' => 'disokong',
            'status_pengesah' => 'disokong',
            "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
            "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
        ]);

        DB::table('eln_pengesahan_bahagian_rombongan')->insertGetId([
            'id_rombongan' => $id,
            'id_pemohon' => $userid,
            'jawatan_pemohon' => $pemohon->userJawatan->namaJawatan,
            'gred_pemohon' => ''.$pemohon->userGredKod->gred_kod_abjad.' '.$pemohon->userGredAngka->gred_angka_nombor.'',
            'jabatan_pemohon' => $pemohon->userJabatan->jabatan_id,
            'taraf_pemohon' => $pemohon->taraf,
            'id_pengesah' => Auth::user()->usersID,
            'jawatan_pengesah' => $pengesah->userJawatan->namaJawatan,
            'gred_pengesah' => ''.$pengesah->userGredKod->gred_kod_abjad.' '.$pengesah->userGredAngka->gred_angka_nombor.'',
            'jabatan_pengesah' => $pengesah->userJabatan->jabatan_id,
            'ulasan_pengesahan' => 'disokong',
            'status_pengesah' => 'disokong',
            'tarikh_pengesah' =>  \Carbon\Carbon::now(), # new \Datetime()
            'created_at' =>  \Carbon\Carbon::now(), # new \Datetime()
            'updated_at' =>  \Carbon\Carbon::now(), # new \Datetime()
        ]);

        $ubah = 'Lulus Semakan';

        Rombongan::where('rombongans_id', $id)
        ->update([
            'statusPermohonanRom' => $ubah
        ]);

        $suk = User::where('role', 'DatoSUK')->get();
        Notification::send($suk, new SenaraiKelulusanRombongan($butiran));

        // flash('lulus semakkan.')->success();
        toast('Permohonan Rombongan Disokong', 'success')->position('top-end');

        return redirect('/senaraiPendingRombongan');
    }

    public function sebab(Request $request)
    {
        // dd($request);
        $id = $request->input('id_edit');
        $sebab = $request->input('sebb');
        $ubah = 'simpanan';

        Permohonan::where('permohonansID', $id)
        ->update(['statusPermohonan' => $ubah]);

        $data = [
            'alasan' => $sebab,
            'permohonansID' => $id,

            'created_at' => \Carbon\Carbon::now(), # \Datetime()
            'updated_at' => \Carbon\Carbon::now(), # \Datetime()
        ];
        Sebab::create($data);
        toast('Berjaya dihantar semula', 'success')->position('top-end');
        return back();
    }

    public function sebabRombongan(Request $request)
    {
        // dd($request);
        $id = $request->input('id_edit');
        $sebab = $request->input('sebb');
        $ubah = 'simpanan';

        Rombongan::where('rombongans_id', '=', $id)->update(['statusPermohonanRom' => $ubah]);

        $data = [
            'alasan' => $sebab,
            'rombongans_id' => $id,

            'created_at' => \Carbon\Carbon::now(), # \Datetime()
            'updated_at' => \Carbon\Carbon::now(), # \Datetime()
        ];
        Sebab::create($data);
        toast('Berjaya dihantar semula', 'success')->position('top-end');
        
        return back();
    }

    public function laporanDato()
    {
        $list = DB::table('laporan_senarai_permohonan')
            ->whereIn('statusPermohonan', ['Permohonan Gagal', 'Permohonan Berjaya'])
            // ->where('statusPermohonan','Lulus Semakan BPSM')
            ->get();

        $bilkluarneagara = DB::table('jumlah_permohonan_individu')->get();

        $permohon = Permohonan::with('user')
            ->where('statusPermohonan', '=', 'Lulus Semakan BPSM')
            ->get();

        $PermohonanRombongan = Permohonan::with('rombonganPermohonan')
            ->with('user')
            ->where('JenisPermohonan', '=', 'rombongan')
            ->orderBy('rombongans_id')
            ->get();

        if (is_null($permohon)) {
            echo 'kosong';
        } else {
            // dd($permohon);
            // $pdf = PDF::loadView('admin.laporanIndividu',['permohon'=>$permohon,'PermohonanRombongan'=>$PermohonanRombongan])->setPaper('a4', 'landscape');
            // return $pdf->download('laporan.pdf');
        }
        // return view('admin.laporanIndividu', compact('permohon', 'PermohonanRombongan', 'list', 'bilkluarneagara'));
        $pdf = PDF::loadView('admin.laporanIndividu', compact('permohon', 'PermohonanRombongan', 'list', 'bilkluarneagara'))->setPaper('a4', 'landscape');
        return $pdf->download('Laporan Perjalanan Pegawai Ke Luar Negara.pdf');
    }

    public function senaraiJabatan()
    {
        $jabatan = Jabatan::all();
        return view('konfigurasi.senaraiJabatan', compact('jabatan'));
    }


    public function prosesTambahJab(Request $request)
    {
        // dd($request);
        $namajabatan = $request->input('nama_jabatan');
        $kodjabatan = $request->input('kod_jabatan');
        // dd($request->negeri);
        $data = [
            'jawatan_ketua' => $request->ketua,
            'nama_jabatan' => $namajabatan,
            'kod_jabatan' => $kodjabatan,
            'alamat' => $request->alamat,
            'poskod' => $request->poskod,
            'daerah' => $request->daerah,
            'negeri' => $request->negeri,
            'surat' => $request->surat,
            // 'created_at' => \Carbon\Carbon::now(), # \Datetime()
            // 'updated_at' => \Carbon\Carbon::now(), # \Datetime()
        ];
        Jabatan::insertGetId($data);

        toast('Jabatan berjaya ditambah', 'success')->position('top-end');
        return back();
    }

    public function kemaskinijabatan(Request $req)
    {
        Jabatan::where('jabatan_id', $req->input('id'))
        ->update([
            'jawatan_ketua' => $req->ketua,
            'nama_jabatan' => $req->nama_jabatan,
            'kod_jabatan' => $req->kod_jabatan,
            'alamat' => $req->alamat,
            'poskod' => $req->poskod,
            'daerah' => $req->daerah,
            'negeri' => $req->negeri,
            'surat' => $req->surat,
        ]);

        // flash('Jabatan berjaya dikemaskini')->success();
        toast('Jabatan berjaya dikemaskini', 'success')->position('top-end');
        return back();
    }

    public function padamjabatan(Request $req)
    {
        Jabatan::where('jabatan_id', $req->input('id'))
        ->delete();

        // flash('Jabatan berjaya dipadam')->success();
        toast('Jabatan berjaya dipadam', 'success')->position('top-end');
        return back();
    }

    public function senaraiJawatan()
    {
        $jawatan = Jawatan::all();
        return view('konfigurasi.senaraiJawatan', compact('jawatan'));
    }


    public function prosesTambahJaw(Request $request)
    {
        // dd($request);
        $namajawatan = $request->input('namajawatan');

        $data = [
            'namaJawatan' => $namajawatan,
            'created_at' => \Carbon\Carbon::now(), # \Datetime()
            'updated_at' => \Carbon\Carbon::now(), # \Datetime()
        ];
        Jawatan::create($data);
        // flash('Jawatan berjaya ditambah.')->success();
        toast('Jawatan berjaya ditambah', 'success')->position('top-end');
        return redirect('senaraiJawatan');
    }

    public function kemaskinijawatan(Request $req)
    {
        Jawatan::where('idJawatan', $req->input('id'))
        ->update([
            'namaJawatan' => $req->input('namaJawatan')
        ]);

        toast('Jawatan berjaya dikemaskini', 'success')->position('top-end');
        // flash('Jawatan berjaya dikemaskini')->success();
        return back();
    }

    public function padamjawatan(Request $req)
    {
        Jawatan::where('idJawatan', $req->input('id'))
        ->delete();

        // flash('Jawatan berjaya dipadam')->success();
        toast('Jawatan berjaya dipadam', 'success')->position('top-end');
        return back();
    }

    public function senaraiGredAngka()
    {
        $angka = GredAngka::all();
        return view('konfigurasi.senaraiGredAngka', compact('angka'));
    }

    public function tambahGredAngka()
    {
        return view('konfigurasi.tambahGredAngka');
    }

    public function prosesTambahGredAngka(Request $request)
    {
        // dd($request);
        $angka = $request->input('angka');

        $data = [
            'gred_angka_nombor' => $angka,
            'created_at' => \Carbon\Carbon::now(), # \Datetime()
            'updated_at' => \Carbon\Carbon::now(), # \Datetime()
        ];
        GredAngka::create($data);
        // flash('Maklumat telah ditambah')->success();
        toast('Maklumat telah ditambah', 'success')->position('top-end');

        return redirect('senaraiGredAngka');
    }

    public function kemaskiniangkagred(Request $req)
    {
        GredAngka::where('gred_angka_ID', $req->input('id'))
        ->update([
            'gred_angka_nombor' => $req->input('gred_angka_nombor')
        ]);

        // flash('GredAngka berjaya dikemaskini')->success();
        toast('Angka Gred dikemaskini', 'success')->position('top-end');

        return back();
    }

    public function padamangkagred(Request $req)
    {
        GredAngka::where('gred_angka_ID', $req->input('id'))
        ->delete();

        // flash('GredAngka berjaya dipadam')->success();
        toast('Angka Gred dipadam', 'success')->position('top-end');

        return back();
    }

    public function laporanjantina(Request $req)
    {
        $tahun = $req->tahun;
        
        $listyear = DB::table('tahun_ada_permohonan')->get();

        $countLBerjaya = Permohonan::with('user')
            ->where('statusPermohonan', 'Permohonan Berjaya')
            ->whereYear('tarikhMulaPerjalanan', $tahun)
            ->whereHas('user', function ($q) {
                $q->where('jantina', 'Lelaki');
            })
            ->count();

        $countPBerjaya = Permohonan::with('user')
            ->where('statusPermohonan', 'Permohonan Berjaya')
            ->whereYear('tarikhMulaPerjalanan', $tahun)
            ->whereHas('user', function ($q) {
                $q->where('jantina', 'Perempuan');
            })
            ->count();

        $countLGagal = Permohonan::with('user')
            ->where('statusPermohonan', 'Permohonan Gagal')
            ->whereYear('tarikhMulaPerjalanan', $tahun)
            ->whereHas('user', function ($q) {
                $q->where('jantina', 'Lelaki');
            })
            ->count();

        $countPGagal = Permohonan::with('user')
            ->where('statusPermohonan', 'Permohonan Gagal')
            ->whereYear('tarikhMulaPerjalanan', $tahun)
            ->whereHas('user', function ($q) {
                $q->where('jantina', 'Perempuan');
            })
            ->count();

        return view('laporan.jantina', compact('countLBerjaya', 'listyear', 'countPBerjaya', 'countLGagal', 'countPGagal', 'tahun'));
    }

    public function laporanjabatan(Request $req)
    {
        $tahun = $req->tahun;

        $listyear = DB::table('tahun_ada_permohonan')->get();

        $list = DB::table('jumlah_jabatan_tahunan')
            ->where('tahun', $tahun)
            ->orderBy('jumlah', 'desc')
            ->get();

        return view('laporan.jabatan', compact('list', 'listyear',  'tahun'));
    }

    public function laporannegara(Request $req)
    {
        $tahun = $req->tahun;

        $listyear = DB::table('tahun_ada_permohonan')->get();

        $list = DB::table('jumlah_mengikut_negara_tahunan')
            ->where('tahun', $tahun)
            ->orderBy('jumlah', 'desc')
            ->get();

        return view('laporan.negara', compact('list', 'listyear', 'tahun' ));
    }

    public function laporanbulanan(Request $req)
    {
        $tahun = $req->tahun;

        $listyear = DB::table('tahun_ada_permohonan')->get();

        $bil = DB::table('jumlah_permohonan_bulanan_tahunan')
            ->where('tahun', $tahun)
            ->get();

        $jumlah = DB::table('jumlah_permohonan_bulanan_tahunan')
            ->where('tahun', $tahun)
            ->sum('bil');

        return view('laporan.bulanan', compact('tahun', 'listyear', 'bil', 'jumlah'));
    }

    public function laporanbutiranbulanan(Request $req, $tahun, $bulan)
    {
        $listyear = DB::table('tahun_ada_permohonan')->get();

        $list = DB::table('senarai_berjaya_bulan_tahun')
        ->where('tahun', $tahun)
        ->where('bulan', $bulan)
        ->get();

        return view('laporan.butiran-bulanan', compact('listyear', 'list', 'tahun', 'bulan'));
    }

    public function laporanbutiranbulanan2(Request $req)
    {
        $tahun = $req->input('tahun');
        $bulan = $req->input('bulan');

        $listyear = DB::table('tahun_ada_permohonan')->get();

        $list = DB::table('senarai_berjaya_bulan_tahun')
        ->where('tahun', $tahun)
        ->where('bulan', $bulan)
        ->get();

        return view('laporan.butiran-bulanan', compact('listyear', 'list', 'tahun', 'bulan'));
    }

    public function laporantahunan()
    {
        $listyear = DB::table('tahun_ada_permohonan')->get();

        $data = DB::table('jumlah_permohonan_tahunan')
            ->orderBy('tahun', 'desc')
            ->get();

        return view('laporan.tahun', compact('data', 'listyear'));
    }

    public function laporanindividu()
    {
        $data = DB::table('bilangan_keluar_negara_individu')->get();

        return view('laporan.individu', compact('data'));
    }
    
    public function butiranindividu($id)
    {
        $user = DB::table('butiran_keluar_negara_individu')
        ->where('usersID', $id)
        ->first();

        $negara = DB::table('butiran_keluar_negara_individu')
        ->where('usersID', $id)
        ->whereIn('statusPermohonan', ['Permohonan Berjaya', 'Permohonan Gagal'])
        ->orderBy('tarikhMulaPerjalanan', 'desc')
        ->get();

        return view('laporan.butiran-individu', compact('user','negara'));
    }

    public function terusDato()
    {
        $jawatan = Jawatan::where('statusDato', '=', 'Aktif')->get();

        $jawatan2 = Jawatan::whereNotIn('statusDato', ['Aktif'])->get();

        return view('konfigurasi.terusDato', compact('jawatan', 'jawatan2'));
    }
    
    public function sokongantsuk()
    {
        $tsukpem = Jawatan::where('stsukpem', '1')->get();
        $tsukpen = Jawatan::where('stsukpen', '1')->get();

        $jawatan2 = Jawatan::get()->sortBy('namaJawatan');


        return view('konfigurasi.sokongan-tsuk', compact('tsukpem', 'tsukpen', 'jawatan2'));
    }

    public function tambahterusDato()
    {
        // $jawatan = Jawatan::all();
        $jawatan = Jawatan::get()->sortBy('namaJawatan');
        return view('konfigurasi.tambahterusDato', compact('jawatan'));
    }

    public function tambahsokongantsukpen(Request $request)
    {
       Jawatan::where('idJawatan', $request->jawatan)->update(['stsukpen' => 1]);
       toast('Maklumat telah ditambah', 'success')->position('top-end');
       return back();
    }

    public function tambahsokongantsukpem(Request $request)
    {
       Jawatan::where('idJawatan', $request->jawatan)->update(['stsukpem' => 1]);
       toast('Maklumat telah ditambah', 'success')->position('top-end');
       return back();
    }

    public function prosesTambahterusDato(Request $request)
    {
        // dd($request);
        $angka = $request->input('jawatan');
        $ulasan = 'Aktif';

        Jawatan::where('idJawatan', $request->jawatan)->update(['statusDato' => $ulasan]);

        // flash('Maklumat telah ditambah')->success();
        toast('Maklumat telah ditambah', 'success')->position('top-end');
        return redirect('terusDato');
    }

    public function padamTerusDato($id)
    {
        $ulasan = 'Tidak Aktif';
        Jawatan::where('idJawatan', $id)->update(['statusDato' => $ulasan]);

        // flash('Jawatan terus ke Dato dihapuskan.')->error();
        toast('Jawatan terus ke Dato dihapuskan', 'error')->position('top-end');
        return redirect('terusDato');
    }

    public function padamtsukpen($id)
    {
        $ulasan = 'Tidak Aktif';
        Jawatan::where('idJawatan', $id)->update(['stsukpen' =>'']);

        // flash('Jawatan terus ke Dato dihapuskan.')->error();
        toast('Maklumat telah dihapuskan', 'error')->position('top-end');
        return back();
    }

    public function padamtsukpem($id)
    {
        $ulasan = 'Tidak Aktif';
        Jawatan::where('idJawatan', $id)->update(['stsukpem' => '']);

        // flash('Maklumat telah dihapuskan.')->error();
        toast('Maklumat telah dihapuskan', 'error')->position('top-end');
        return back();
    }

    public function senaraiGredKod()
    {
        $kod = GredKod::all();
        return view('konfigurasi.senaraiGredKod', compact('kod'));
    }

    public function tambahGredKod()
    {
        return view('konfigurasi.tambahGredKod');
    }

    public function prosesTambahGredKod(Request $request)
    {
        // dd($request);
        $kod = $request->input('kod');
        $klasifikasi = $request->input('klasifikasi');

        $data = [
            'gred_kod_abjad' => $kod,
            'gred_kod_klasifikasi' => $klasifikasi,
            'created_at' => \Carbon\Carbon::now(), # \Datetime()
            'updated_at' => \Carbon\Carbon::now(), # \Datetime()
        ];
        GredKod::create($data);
        // flash('Maklumat telah ditambah')->success();
        toast('Maklumat telah ditambah', 'success')->position('top-end');

        return redirect('senaraiGredKod');
    }

    public function kemaskinigredkod(Request $req)
    {
        GredKod::where('gred_kod_ID', $req->input('id'))
        ->update([
            'gred_kod_abjad' => $req->input('gred_kod_abjad'),
            'gred_kod_klasifikasi' => $req->input('gred_kod_klasifikasi')
        ]);

        // flash('GredKod berjaya dikemaskini')->success();
        toast('GredKod berjaya dikemaskini', 'success')->position('top-end');

        return back();
    }

    public function padamgredkod(Request $req)
    {
        GredKod::where('gred_kod_ID', $req->input('id'))
        ->delete();

        // flash('GredKod berjaya dipadam')->success();
        toast('GredKod telah dipadam', 'success')->position('top-end');

        return back();
    }

    public function daftarPic()
    {
        $jabatan = Jabatan::all();
        $jawatan = Jawatan::all();
        $angka = GredAngka::all();
        $kod = GredKod::all();
        // dd($jabatan);
        return view('admin.tambah-pic', compact('jabatan', 'jawatan', 'angka', 'kod'));
    }

    public function daftarJabatan(Request $request)
    {
        // dd($request);
        $nama = $request->input('nama');
        $nokp = $request->input('nokp');
        $jabatan = $request->input('jabatan');
        $jawatan = $request->input('jawatan');
        $kod = $request->input('kod');
        $gred = $request->input('gred');
        $email = $request->input('email');
        $role = $request->input('role');
        $katalaluan = bcrypt($nokp);

        $data = [
            'nama' => $nama,
            'nokp' => $nokp,
            'email' => $email,
            'jabatan' => $jabatan,
            'jawatan' => $jawatan,
            'gredKod' => $kod,
            'gredAngka' => $gred,
            'password' => $katalaluan,
            'role' => $role,
            'created_at' => \Carbon\Carbon::now(), # \Datetime()
            'updated_at' => \Carbon\Carbon::now(), # \Datetime()
        ];
        User::create($data);
        toast('Pentadbir telah berjaya ditambah','success')->position('top-end');
        
        return redirect()->back();
    }

    public function senaraiPic()
    {
        $user = User::with('userJabatan')
            ->where('role', '=', 'jabatan')
            ->get();
        // dd($user);
        return view('admin.senaraiPicJabatan', compact('user'));
    }

    public function senaraiPengguna()
    {
        $user = User::leftjoin('jawatan', 'jawatan.idJawatan', '=', 'users.jawatan')->get();
        // $user = User::where('jabatan', Auth::user()->jabatan)->get();

        // $user = User::with('userJabatan')->get();

        // dd($user);
        return view('admin.senaraiPengguna', compact('user'));
    }

    public function editPIC($id)
    {
        //dd($id);
        $users = User::with('userJabatan')
            ->where('role', '=', 'picJabatan')
            ->where('usersID', '=', $id)
            ->first();
        return view('admin.insertEdit', compact('users'));
    }

    public function updateDataPIC(Request $request, $id)
    {
        //dd($request);
        $users = User::find($id);
        $users->update($request->all());
        // flash('Maklumat telah dikemaskini.')->success();
        toast('Maklumat telah dikemaskini','success')->position('top-end');
        return redirect('senaraiPic');
    }

    // --------------------------jabatan-----------------------
    // --------------------------------------------------------

    public function senaraiPermohonanJabatan()
    {
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
            ->WhereIn('jabatan', ['39', '40', '35', '36'])
            ->orWhere(function ($query) {
                $query->where('statusPermohonan', 'Ketua Jabatan')
                ->Where('stsukpen', 1);
            })
            ->orderBy('tarikhmohon','asc')
            ->get();
        } else {
            $permohonan = DB::table('senarai_data_permohonan')
            ->where('jabatan', $jab)
            ->whereIn('statusPermohonan', ['Ketua Jabatan'])
            ->whereNotIn('role', ['jabatan'])
            ->orderBy('tarikhmohon','asc')
            ->get();
        }

        $dokumen = Dokumen::all();

        // if ($jab == 44) {
        //     $permohonan = Permohonan::select('permohonans.*', 'users.*', 'permohonans.created_at as tpermohonan')
        //         ->join('users', 'permohonans.usersID', '=', 'users.usersID')
        //         ->whereIn('users.jabatan', [44, 37])
        //         ->whereIn('statusPermohonan', ['Ketua Jabatan'])
        //         ->orderBy('permohonans.created_at','asc')
        //         ->get();
        // } else {
        //     $permohonan = Permohonan::select('permohonans.*', 'users.*', 'permohonans.created_at as tpermohonan')
        //         ->join('users', 'permohonans.usersID', '=', 'users.usersID')
        //         ->where('users.jabatan', $jab)
        //         ->whereIn('statusPermohonan', ['Ketua Jabatan'])
        //         ->orderBy('permohonans.created_at','asc')
        //         ->get();
        // }
        
        return view('jabatan.senaraiPermohonanJabatan', compact('permohonan', 'dokumen'));
    }

    public function senaraiPermohonanLepas()
    {
        $jab = Auth::user()->jabatan;
            if ($jab == 38) {
                $permohonan = DB::table('senarai_data_permohonan_ind_rom')
                ->Where('jabatan_pengesah', $jab)
                ->whereIn('statusPermohonan', ['Lulus Semakan BPSM','Permohonan Berjaya', 'Permohonan Gagal'])
                ->orWhere(function ($query) {
                    $query->whereIn('statusPermohonan', ['Lulus Semakan BPSM','Permohonan Berjaya', 'Permohonan Gagal'])
                    ->Where('stsukpem', 1);
                })
                ->orderBy('tarikhmohon','desc')
                ->get();

            } elseif  ($jab == 39) {
                $permohonan = DB::table('senarai_data_permohonan_ind_rom')
                ->whereIn('statusPermohonan', ['Lulus Semakan BPSM','Permohonan Berjaya', 'Permohonan Gagal'])
                ->where('jabatan_pengesah', $jab)
                ->orWhere(function ($query) {
                    $query->whereIn('statusPermohonan', ['Lulus Semakan BPSM','Permohonan Berjaya', 'Permohonan Gagal'])
                    ->where('stsukpen', 1);
                })
                ->orderBy('tarikhmohon','desc')
                ->get();

            } else {
                $permohonan = DB::table('senarai_data_permohonan_ind_rom')
                ->where('jabatan_pemohon', $jab)
                ->whereIn('statusPermohonan', ['Lulus Semakan BPSM','Permohonan Berjaya', 'Permohonan Gagal'])
                ->whereNotIn('role', ['jabatan'])
                ->orderBy('tarikhmohon', 'desc')
                ->get();

            }


            // $permohonan2 = Permohonan::select('users.*', 'permohonans.*', 'permohonans.created_at as tarikhmohon')
            //     ->join('users', 'permohonans.usersID', '=', 'users.usersID')
            //     ->where('users.jabatan', $jab)
            //     ->whereNotIn('statusPermohonan', ['simpanan'])
            //     ->orderBy('permohonans.created_at', 'desc')
            //     ->get();
                
            // $permohonan = DB::table('senarai_data_permohonan')
            //     ->where('jabatan_pemohon', $jab)
            //     ->orderBy('tarikhmohon', 'desc')
            //     ->get();


            // $rombo = Rombongan::select('users.*', 'rombongans.*', 'rombongans.created_at as tarikhMohon')
            //     ->join('users', 'rombongans.usersID', '=', 'users.usersID')
            //     ->where('users.jabatan', $jab)
            //     ->whereNotIn('rombongans.statusPermohonanRom', ['simpanan'])
            //     ->orderBy('rombongans.created_at', 'desc')
            //     ->get();

                $rombo = DB::table('senarai_data_permohonan_rombongan')
                ->where('jabatan_pemohon', $jab)
                ->orderBy('tarikhMohon', 'desc')
                ->get();
        

        $jabatan = Jabatan::where('jabatan_id', $jab)->first();

        return view('jabatan.senaraiPermohonanLepas', compact('permohonan', 'rombo', 'jabatan'));
    }

    public function daftarPenggunaJabatan()
    {
    }
    public function senaraiPenggunaJabatan()
    {
    }

    public function hantarJabatan(Request $request)
    {
        $id = $request->kopeID;
        $ulasan = $request->ulasan;
        $upda = 'Lulus Semakan BPSM';

        $permohonan = Permohonan::where('permohonansID', $id)->first();
        
        $tarikhmulajalan = $permohonan->tarikhMulaPerjalanan;
        
        $end = Carbon::parse($tarikhmulajalan);
        $nowsaa = Carbon::today();
        
        $length = $end->diffInDays($nowsaa);
        
        $pemohon = User::with('userJabatan')
            // ->with('userJawatan')
            ->where('usersID', '=', $permohonan->usersID)
            ->first();

        $pengesah = User::with('userJabatan')
            // ->with('userJawatan')
            ->where('usersID', '=', Auth::user()->usersID)
            ->first();

        Eln_pengesahan_bahagian::insertGetId( [
            'id_permohonan' => $permohonan->permohonansID,
            'id_rombongan' => $permohonan->rombongans_id,
            'id_pemohon' => $permohonan->usersID,
            'jawatan_pemohon' => $pemohon->userJawatan->namaJawatan,
            'gred_pemohon' => ''.$pemohon->userGredKod->gred_kod_abjad.' '.$pemohon->userGredAngka->gred_angka_nombor.'',
            'taraf_pemohon' => $pemohon->taraf,
            'jabatan_pemohon' => $pemohon->userJabatan->jabatan_id,
            'id_pengesah' => Auth::user()->usersID,
            'jawatan_pengesah' => $pengesah->userJawatan->namaJawatan,
            'gred_pengesah' => ''.$pengesah->userGredKod->gred_kod_abjad.' '.$pengesah->userGredAngka->gred_angka_nombor.'',
            'jabatan_pengesah' => $pengesah->userJabatan->jabatan_id,
            'ulasan' => $request->ulasan,
            'status_pengesah' => 'disokong',
            "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
            "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
        ]);

        Permohonan::where('permohonansID', $id)->update(['ulasan' => $ulasan, 'statusPermohonan' => $upda, 'jumlahHariPermohonanBerlepas' => $length]);
        // flash('Permohonan telah disokong.', 'success');

        $suk = User::where('role', 'DatoSUK')->get();

        Notification::send($suk, new SenaraiKelulusan($suk));
        // dd($suk);
        toast('Permohonan telah disokong', 'success')->position('top-end');
        return redirect('/senaraiPermohonanJabatan');
    }

    public function pengesahanTolak(Request $request)
    {
        $id = $request->id;
        $ulasan = $request->ulasan;
        $ubah = 'Permohonan Gagal';

        Permohonan::where('permohonansID', '=', $id)->update([
            'statusPermohonan' => $ubah,
            'tarikhLulusan' => \Carbon\Carbon::now(),
        ]);

        $permohonan = Permohonan::where('permohonansID', $id)->first();

        $pemohon = User::with('userJabatan')
            // ->with('userJawatan')
            ->where('usersID', '=', $permohonan->usersID)
            ->first();

        $pengesah = User::with('userJabatan')
            // ->with('userJawatan')
            ->where('usersID', '=', Auth::user()->usersID)
            ->first();

        Eln_pengesahan_bahagian::insertGetId( [
            'id_permohonan' => $permohonan->permohonansID,
            'id_rombongan' => $permohonan->rombongans_id,
            'id_pemohon' => $permohonan->usersID,
            'jawatan_pemohon' => $pemohon->userJawatan->namaJawatan,
            'gred_pemohon' => ''.$pemohon->userGredKod->gred_kod_abjad.' '.$pemohon->userGredAngka->gred_angka_nombor.'',
            'taraf_pemohon' => $pemohon->taraf,
            'jabatan_pemohon' => $pemohon->userJabatan->jabatan_id,
            'id_pengesah' => Auth::user()->usersID,
            'jawatan_pengesah' => $pengesah->userJawatan->namaJawatan,
            'gred_pengesah' => ''.$pengesah->userGredKod->gred_kod_abjad.' '.$pengesah->userGredAngka->gred_angka_nombor.'',
            'jabatan_pengesah' => $pengesah->userJabatan->jabatan_id,
            'ulasan' => $request->ulasan,
            'status_pengesah' => 'ditolak',
            "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
            "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
        ]);

        // flash('Permohonan Ditolak.')->success();
        toast('Permohonan Ditolak', 'error')->position('top-end');
        return redirect('/senaraiPermohonanJabatan');
    }
    
    public function tukarketuarombongan(Request $request)
    {
        $id = $request->id;
        $romboid = $request->romboid;

        // return dd($romboid, $id);
        
        Rombongan::where('rombongans_id', $romboid)
        ->update([
            'ketua_rombongan' => $id
        ]);
        
        // flash('Ketua Rombongan baru telah berjaya ditukar')->success();

        // Alert::success('Berjaya', 'Ketua Rombongan telah ditukar!');
        Alert::success('Berjaya', 'Maklumat dikemaskini');

        return response()->json(['success' => true, 'message' => 'Berjaya Dikemaskini']);
        // return back();
    }

    public function kemaskiniPengguna($id)
    {
        $jabatan = Jabatan::all();
        $jawatan = Jawatan::all();
        $angka = GredAngka::all();
        $kod = GredKod::all();

        $users = User::with('userJabatan')
            ->where('usersID', '=', $id)
            ->first();
        //dd($user);
        return view('admin.kemaskiniPengguna', compact('jabatan', 'users', 'jawatan', 'angka', 'kod'));
    }

    public function resetKatalaluan($id)
    {
        
        $user = User::where('usersID', $id)
        ->first();

        User::where('usersID', $id)
        ->update([
            'password' => Hash::make($user->nokp)
        ]);

        // flash('Kata Laluan Pengguna Telah Diset Semula', 'success');
        toast('Kata Laluan Pengguna Telah Diset Semula', 'success')->position('top-end');
        return back();
    }

    public function kemaskiniDataPengguna(Request $request)
    {
        $nama = $request->nama;
        $nokp = $request->nokp;
        $email = $request->email;

        $jawatan = $request->jawatan;
        $jabatan = $request->jabatan;
        $gred = $request->gred;
        $kod = $request->kod;

        
        User::with('userJabatan')
            ->with('userJawatan')
            ->where('nokp', $nokp)
            ->update([
                'nama' => $nama, 
                'email' => $email,
                'jawatan' => $jawatan,
                'role' => $request->role,
                'jabatan' => $jabatan,
                'taraf' => $request->taraf,
                'gredAngka' => $gred,
                'gredKod' => $kod
            ]);

        // flash('Maklumat telah dikemaskini', 'success');
        toast('Maklumat telah dikemaskini', 'success')->position('top-end');
        return redirect()->back();
    }

    public function infoSurat()
    {
        $cogan = 'Cogan Kata';
        $ppengarah = 'Penolong Pengarah';

        $cogankata = InfoSurat::where('perkara', '=', $cogan)->first();

        $penolongPengarah = InfoSurat::where('perkara', '=', $ppengarah)->first();

        // dd($penolongPengarah);
        return view('konfigurasi.infoSurat', compact('cogankata', 'penolongPengarah'));
    }

    public function prosesTambahCoganKata(Request $request)
    {
        $id = $request->input('id');

        infoSurat::where('info_surat_ID', $id)->update([
            'maklumat1' => $request->input('kata'),
            'maklumat2' => $request->input('kata2'),
            'maklumat3' => $request->input('kata3'),
        ]);
        // flash('Maklumat telah dikemaskini', 'success');
        toast('Maklumat telah dikemaskini', 'success')->position('top-end');

        return back();

        // $cogan=$request->cogan;
        // $kata=$request->kata;
        // $bilanganCogan = InfoSurat::where('perkara','=',$cogan)
        //             ->count();
        // if ($bilanganCogan == 0)
        // {
        //    $data = [
        //         'perkara'=>$cogan,
        //         'maklumat1'=>$kata,
        //         'created_at' =>  \Carbon\Carbon::now(), # \Datetime()
        //         'updated_at' => \Carbon\Carbon::now()  # \Datetime()
        //     ];
        //     infoSurat::create($data);
        //     flash('Berjaya mendaftar cogan kata. ')->success();
        //     return redirect()->back();
        // }
        // else
        // {
        //     infoSurat::where('info_surat_ID', $cogan)
        //     ->update([
        //         'maklumat1' => $cogan,
        //         'maklumat2' => $cogan2,
        //         'maklumat3' => $cogan3,
        //     ]);
        //     flash('kemaskini dah berjaya!!', 'success');

        //     return redirect()->back();
        // }
    }

    public function prosesTambahNamaPenolongPengarah(Request $request)
    {
        $maklumat1 = $request->maklumat1;
        $maklumat2 = $request->maklumat2;
        $maklumat3 = $request->maklumat3;
        $maklumat4 = $request->maklumat4;
        $pp = $request->pp;
        $bilanganCogan = InfoSurat::where('perkara', '=', $pp)->count();
        if ($bilanganCogan == 0) {
            $data = [
                'perkara' => $pp,
                'maklumat1' => $maklumat1,
                'maklumat2' => $maklumat2,
                'maklumat3' => $maklumat3,
                'maklumat4' => $maklumat4,
                'created_at' => \Carbon\Carbon::now(), # \Datetime()
                'updated_at' => \Carbon\Carbon::now(), # \Datetime()
            ];
            infoSurat::create($data);
            // flash('Berjaya mendaftar Penolong Pengarah. ')->success();
            toast('Maklumat telah dikemaskini', 'success')->position('top-end');
            return back();
        } else {
            infoSurat::where('perkara', $pp)->update(['maklumat1' => $maklumat1, 'maklumat2' => $maklumat2, 'maklumat3' => $maklumat3, 'maklumat4' => $maklumat4]);
            // flash('Maklumat telah dikemaskini', 'success');
            toast('Maklumat telah dikemaskini', 'success')->position('top-end');

            return back();
        }
    }
}
