<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;

use App\Models\Negara;
use App\Models\User;
use App\Models\Permohonan;
use App\Models\Dokumen;
use App\Models\Rombongan;
use App\Models\Pasangan;
use App\Models\Jawatan;
use App\Models\Jabatan;
use App\Models\GredKod;
use App\Models\GredAngka;
use App\Models\Eln_pengesahan_bahagian;
use App\Models\Eln_kelulusan;
use DB;
use Auth;
use Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

use Illuminate\Notifications\Notifiable;
use App\Notifications\SenaraiSokongan;
use App\Notifications\SenaraiSokonganRombongan;
use App\Notifications\SenaraiKelulusan;
use App\Notifications\SenaraiKelulusanRombongan;
use App\Notifications\PermohonanBerjaya;
use App\Notifications\KeputusanPermohonan;

use Vinkla\Hashids\Facades\Hashids;

class permohonanController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $negara = Negara::all();
        $options = Negara::pluck('namaNegara'); //depan tuu display/kemudian valuenya
        //dd($negara);
        return view('registerForm', compact('options'));
    }

    public function registerBaru()
    {
        $jabatan = Jabatan::orderBy('nama_jabatan', 'asc')->get();
        $gredAngka = GredAngka::all();
        $gredKod = GredKod::all();
        $jawatan = Jawatan::orderBy('namaJawatan', 'asc')->get();

        //dd($negara);
        return view('auth.register', compact('jabatan', 'gredAngka', 'gredKod', 'jawatan'));
    }

    public function index2()
    {
        //check auth wujud ke idok
        if (Auth::check()) {
            $user = Auth::user();
            $role = $user->role;
            $id = $user->usersID;
            $create = $user->created_at;
            $year = today()->format('Y');
            // --------------------Pengguna---------------------------------------------------------------------------------
            $DateNew3 = strtotime($create);
            $mula = date('d-m-Y', $DateNew3);

            $TotalPerm = DB::table('permohonans')
                ->where('usersID', '=', $id)
                ->whereNotIn('statusPermohonan', ['simpanan'])
                // ->where('statusPermohonan','!=', 'simpanan')
                // ->whereYear('tarikhLulusan', $year)
                ->count();
            $TotalPermRomb = DB::table('rombongans')
                ->where('usersID', '=', $id)
                ->whereNotIn('statusPermohonanRom', ['simpanan'])
                // ->where('statusPermohonan','!=', 'simpanan')
                // ->whereYear('tarikhLulusan', $year)
                ->count();

            $TotalBerjaya = DB::table('permohonans')
                ->where('usersID', '=', $id)
                ->where('statusPermohonan', '=', 'Permohonan Berjaya')
                // ->whereYear('tarikhLulusan', $year)
                ->count();

            $TotalBerjayaRomb = DB::table('rombongans')
                ->where('usersID', '=', $id)
                ->where('statusPermohonanRom', '=', 'Permohonan Berjaya')
                // ->whereYear('tarikhLulusan', $year)
                ->count();

            $TotalGagal = DB::table('permohonans')
                ->where('usersID', '=', $id)
                ->where('statusPermohonan', '=', 'Permohonan Gagal')
                // ->whereYear('tarikhLulusan', $year)
                ->count();

            $TotalGagalRomb = DB::table('rombongans')
                ->where('usersID', '=', $id)
                ->where('statusPermohonanRom', '=', 'Permohonan Gagal')
                // ->whereYear('tarikhLulusan', $year)
                ->count();

            $TotalProces = DB::table('permohonans')
                ->where('usersID', '=', $id)
                ->whereNotIn('statusPermohonan', ['Permohonan Berjaya', 'Permohonan Gagal', 'simpanan'])
                // ->whereYear('tarikhLulusan', $year)
                ->count();

            $TotalProcesRomb = DB::table('rombongans')
                ->where('usersID', '=', $id)
                ->whereNotIn('statusPermohonanRom', ['Permohonan Berjaya', 'Permohonan Gagal', 'simpanan'])
                // ->whereYear('tarikhLulusan', $year)
                ->count();

            $senarai = DB::table('permohonans')
                ->where('usersID', Auth::user()->usersID)
                ->whereIn('statusPermohonan', ['Permohonan Berjaya', 'Permohonan Gagal'])
                // ->whereYear('tarikhLulusan', $year)
                ->orderBy('tarikhLulusan', 'DESC')
                ->get();
            // --------------------Pengguna---------------------------------------------------------------------------------
            // --------------------ADMIN PSM---------------------------------------------------------------------------------

            if (Auth::user()->role == 'adminBPSM' || Auth::user()->role == 'DatoSUK') {
                $TotalPerm1 = DB::table('permohonans')
                    ->whereNotIn('statusPermohonan', ['simpanan'])
                    ->whereNotIn('JenisPermohonan', ['rombongan'])
                    // ->whereYear('tarikhMulaPerjalanan', $year)
                    ->count();

                $TotalPermRom = DB::table('rombongans')
                    ->whereNotIn('statusPermohonanRom', ['simpanan'])
                    // ->whereNotIn('JenisPermohonan', ['rombongan'])
                    // ->whereYear('tarikhMulaPerjalanan', $year)
                    ->count();

                $TotalBerjaya1 = DB::table('senarai_rekod_permohonan_suk')
                    ->where('status_kelulusan', 'Berjaya')
                    ->whereNotIn('JenisPermohonan', ['rombongan'])
                    // ->whereYear('tarikhLulusan', $year)
                    ->count();

                $TotalBerjaya1Rom = DB::table('senarai_rekod_permohonan_rombongan_suk')
                    ->where('status_kelulusan', 'Berjaya')
                    // ->whereNotIn('JenisPermohonan', ['rombongan'])
                    // ->whereYear('tarikhLulusan', $year)
                    ->count();

                $TotalGagal1 = DB::table('senarai_rekod_permohonan_suk')
                    ->where('status_kelulusan', '=', 'Gagal')
                    ->whereNotIn('JenisPermohonan', ['rombongan'])
                    // ->whereYear('tarikhLulusan', $year)
                    ->count();

                $TotalGagal1Rom = DB::table('senarai_rekod_permohonan_rombongan_suk')
                    ->where('status_kelulusan', 'Gagal')
                    // ->whereNotIn('JenisPermohonan', ['rombongan'])
                    // ->whereYear('tarikhLulusan', $year)
                    ->count();

                $TotalProces1 = DB::table('permohonans')
                    ->whereNotIn('statusPermohonan', ['Permohonan Berjaya', 'Permohonan Gagal', 'simpanan'])
                    // ->whereYear('tarikhMulaPerjalanan', $year)
                    ->count();
                $TotalProces1Rom = DB::table('rombongans')
                    ->whereNotIn('statusPermohonanRom', ['Permohonan Berjaya', 'Permohonan Gagal', 'simpanan'])
                    // ->whereYear('tarikhMulaPerjalanan', $year)
                    ->count();

                $senarai1 = DB::table('permohonans')
                    ->wherein('statusPermohonan', ['Permohonan Berjaya', 'Permohonan Gagal'])
                    // ->whereYear('tarikhLulusan', $year)
                    ->orderBy('tarikhLulusan', 'DESC')
                    ->get();
            } elseif (Auth::user()->role == 'jabatan') {
                //sini deh
                // $TotalPerm1 = DB::table('permohonans')
                // ->join('users', 'users.usersID', '=', 'permohonans.usersID')
                // ->where('users.jabatan', Auth::user()->jabatan)
                // ->where('statusPermohonan', '<>', 'simpanan')
                // // ->whereYear('tarikhMulaPerjalanan', $year)
                // ->count();
                $TotalPerm1 = DB::table('senarai_rekod_permohonan_suk')
                    ->Where('status_kelulusan', ['Gagal', 'Berjaya'])
                    ->Where(function ($query) {
                        $query->orWhere('statusPermohonan', 'Ketua Jabatan')->orWhere('jabatan_pemohon', Auth::user()->jabatan);
                    })
                    ->where('jabatan', Auth::user()->jabatan)
                    ->whereNotIn('JenisPermohonan', ['rombongan'])
                    ->count();

                $TotalPerm1Rom = DB::table('rombongans')
                    ->join('users', 'users.usersID', '=', 'rombongans.usersID')
                    ->where('statusPermohonanRom', '<>', 'simpanan')
                    // ->whereYear('tarikhMulaPerjalanan', $year)
                    ->where('users.jabatan', Auth::user()->jabatan)
                    ->count();

                $TotalBerjaya1 = DB::table('senarai_rekod_permohonan_suk')
                    ->where('status_kelulusan', 'Berjaya')
                    ->whereNotIn('JenisPermohonan', ['rombongan'])
                    ->where('jabatan_pemohon', Auth::user()->jabatan)
                    // ->whereYear('tarikhLulusan', $year)
                    ->count();

                $TotalBerjaya1Rom = DB::table('senarai_rekod_permohonan_rombongan_suk')
                    ->where('status_kelulusan', 'Berjaya')
                    ->where('jabatan_pemohon', Auth::user()->jabatan)
                    // ->whereNotIn('JenisPermohonan', ['rombongan'])
                    // ->whereYear('tarikhLulusan', $year)
                    ->count();

                $TotalGagal1 = DB::table('senarai_rekod_permohonan_suk')
                    ->where('status_kelulusan', '=', 'Gagal')
                    ->whereNotIn('JenisPermohonan', ['rombongan'])
                    ->where('jabatan_pemohon', Auth::user()->jabatan)
                    // ->whereYear('tarikhLulusan', $year)
                    ->count();

                $TotalGagal1Rom = DB::table('senarai_rekod_permohonan_rombongan_suk')
                    ->where('status_kelulusan', 'Gagal')
                    // ->whereNotIn('JenisPermohonan', ['rombongan'])
                    // ->whereYear('tarikhLulusan', $year)
                    ->count();

                $TotalProces1 = DB::table('senarai_rekod_permohonan_suk')
                    ->where('statusPermohonan', 'Ketua Jabatan')
                    ->whereNotIn('JenisPermohonan', ['rombongan'])
                    ->where('jabatan', Auth::user()->jabatan)
                    // ->whereYear('tarikhLulusan', $year)
                    ->count();

                $TotalProces1Rom = DB::table('rombongans')
                    ->whereNotIn('statusPermohonanRom', ['Permohonan Berjaya', 'Permohonan Gagal', 'simpanan'])
                    // ->whereYear('tarikhMulaPerjalanan', $year)
                    ->count();

                $senarai1 = DB::table('senarai_rekod_permohonan_suk')
                    ->wherein('statusPermohonan', ['Permohonan Berjaya', 'Permohonan Gagal'])
                    ->where('jabatan_pemohon', Auth::user()->jabatan)
                    ->orderBy('tarikh_kelulusan', 'DESC')
                    ->get();
            }

            $jumlahPermohonan = DB::table('permohonans')
                ->where('statusPermohonan', '=', 'Lulus Semakkan ketua Jabatan')
                // ->whereYear('tarikhLulusan', $year)
                ->count();

            $jumlahPendingKelulusanDato = DB::table('permohonans')
                ->whereIn('statusPermohonan', ['Lulus Semakan BPSM'])

                // ->whereYear('tarikhMulaPerjalanan', $year)
                ->count();

            $jumlahPendingrombo = DB::table('rombongans')
                ->whereIn('statusPermohonanRom', ['Lulus Semakan'])
                // ->whereYear('tarikhMulaPerjalanan', $year)
                ->count();

            $senaraiNegara = Permohonan::where('statusPermohonan', 'Permohonan Berjaya')
                ->distinct()
                ->get(['negara']);

            // foreach ($senaraiNegara as $key => $value)
            $listnegara = [];
            $listcount = [];

            foreach ($senaraiNegara as $negaras) {
                $namanegara = $negaras->negara;
                $countNegara = Permohonan::where('negara', $namanegara)->count();

                array_push($listnegara, $namanegara);
                array_push($listcount, $countNegara);
            }

            // --------------------Pengguna---------------------------------------------------------------------------------

            if ($role == 'pengguna') {
                return view('pengguna.homepage', compact('user', 'mula', 'TotalPerm', 'TotalPermRomb', 'TotalBerjaya', 'TotalBerjayaRomb', 'TotalGagal', 'TotalGagalRomb', 'TotalProces', 'TotalProcesRomb', 'senarai'));
            } elseif ($role == 'adminBPSM') {
                $bilrasmi = DB::table('jumlah_permohonan_negara_tahun')
                    ->where('statusPermohonan', 'Permohonan Berjaya')
                    ->orderBy('bil', 'desc')
                    ->where('JenisPermohonan', 'Rasmi')
                    ->get();

                $bilxrasmi = DB::table('jumlah_permohonan_negara_tahun')
                    ->where('statusPermohonan', 'Permohonan Berjaya')
                    ->orderBy('bil', 'desc')
                    ->where('JenisPermohonan', 'Tidak Rasmi')
                    ->get();

                $bilRombo = DB::table('jumlah_rombongan_negara_tahun')
                    ->where('status', 'Permohonan Berjaya')
                    ->orderBy('bil', 'desc')
                    ->get();

                return view('admin.homepage', compact('bilRombo', 'bilrasmi', 'bilxrasmi', 'user', 'mula', 'TotalPerm1', 'TotalPermRom', 'TotalBerjaya1', 'TotalBerjaya1Rom', 'TotalGagal1', 'TotalGagal1Rom', 'TotalProces1', 'TotalProces1Rom', 'senarai1'));
            } elseif ($role == 'DatoSUK') {
                $bilrasmi = DB::table('jumlah_permohonan_negara_tahun')
                    ->where('statusPermohonan', 'Permohonan Berjaya')
                    ->orderBy('bil', 'desc')
                    ->where('JenisPermohonan', 'Rasmi')
                    ->get();

                $bilxrasmi = DB::table('jumlah_permohonan_negara_tahun')
                    ->where('statusPermohonan', 'Permohonan Berjaya')
                    ->orderBy('bil', 'desc')
                    ->where('JenisPermohonan', 'Tidak Rasmi')
                    ->get();

                $bilRombo = DB::table('jumlah_rombongan_negara_tahun')
                    ->where('status', 'Permohonan Berjaya')
                    ->orderBy('bil', 'desc')
                    ->get();

                return view('ketua.homepage', compact('bilRombo', 'bilrasmi', 'bilxrasmi', 'user', 'mula', 'TotalBerjaya1', 'TotalBerjaya1Rom', 'TotalGagal1', 'TotalGagal1Rom', 'senarai1', 'jumlahPendingKelulusanDato', 'jumlahPendingrombo', 'listnegara', 'listcount'));
            } elseif ($role == 'jabatan') {
                return view('jabatan.homepage', compact('user', 'mula', 'TotalPerm1', 'TotalPerm1Rom', 'TotalBerjaya1', 'TotalBerjaya1Rom', 'TotalGagal1', 'TotalGagal1Rom', 'TotalProces1', 'TotalProces1Rom', 'senarai1'));
            }
        } else {
            return view('halamanUtama');
        }
    }

    public function tukarkatalaluan(Request $request)
    {
        $request->validate([
            'password' => ['required', 'min:8'],
            'confirmpassword' => ['same:password'],
        ]);

        User::where('usersID', Auth::user()->usersID)->update([
            'password' => Hash::make($request->password),
        ]);

        // flash('Kata laluan telah ditukar.')->success();
        Alert::Success('Makluman', 'Kata laluan telah ditukar.');

        return back();
    }

    public function individu($typeForm)
    {
        $userDetail = User::find(Auth::user()->usersID);
        $negara = Negara::all();
        //$options = Negara::pluck('namaNegara');

        return view('registerFormIndividuRasmi', compact('userDetail', 'negara', 'typeForm'));
    }

    public function rombongan()
    {
        $id = Auth::user()->usersID;

        $userDetail = User::find($id);
        $negara = Negara::all();

        return view('registerFormRombonganRasmi', compact('userDetail', 'negara'));
    }

    public function sertaiRombongan()
    {
        $id = Auth::user()->usersID;
        $userDetail = User::find($id);
        $negara = Negara::all();
        $options = Negara::pluck('namaNegara');
        // $userDetail = User::where('nokp', '=', $id)->firstOrFail();
        // echo $userDetail;
        return view('registerFormIndividuRombongan', compact('userDetail', 'options'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $id = $request->input('id');
        $tujuan = $request->input('tujuan');
        $nama = $request->input('nama');
        $nokp = $request->input('nokp');
        $jawatan = $request->input('jawatan');
        $jabatan = $request->input('jabatan');
        $negara = $request->input('negara');
        $negara_lebih_dari_satu = $request->input('negara_lebih');
        $negara_tambahan = implode(', ', $request->input('negara_tambahan'));
        $alamat = $request->input('alamat');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $namaPasangan = $request->input('namaPasangan');
        $hubungan = $request->input('hubungan');
        $alamatPasangan = $request->input('alamatPasangan');
        $phonePasangan = $request->input('phonePasangan');
        $emailPasangan = $request->input('emailPasangan');
        $tarikhBertugas = $request->input('tarikhKembaliBertugas');
        $tarikh = $request->input('tarikh');
        $jenisPermohonan = $request->input('jenisPermohonan');
        $jenisKew = $request->input('jenisKewangan');
        $catatan_permohonan = $request->input('catatan_permohonan');

        // echo $jenisKew;
        $tick = $request->input('tick');

        // dd($negara_lebih_dari_satu , $negara_tambahan);
        // $tempohPerjalanan = $request->input('tempohPerjalanan');
        // $datePer = explode(' - ', $tempohPerjalanan); // dateRange is you string
        // $dateFrom = $datePer[0];
        // $dateTo = $datePer[1];


        // dd($tempohPerjalanan, $tarikh, $dateFrom, $dateTo);

        // $DateNew1 = strtotime($dateFrom);
        // $DateNew2 = strtotime($dateTo);
        // $DateNew3 = strtotime($tarikhBertugas);
        // $DateNew4 = strtotime($tarikh);
        // $tarikhMulaPerjalanan = date('Y-m-d', $DateNew1);
        // $tarikhAkhirPerjalanan = date('Y-m-d', $DateNew2);
        // $tarikhKembaliBertugas = date('Y-m-d', $DateNew3);
        // $insuran = date('Y-m-d', $DateNew4);
        $dateFrom = $request->input('tarikhMula');
        $dateTo = $request->input('tarikhAkhir');

        $tarikhMulaPerjalanan = Carbon::parse($dateFrom)->format('Y-m-d');
        $tarikhAkhirPerjalanan = Carbon::parse($dateTo)->format('Y-m-d');
        $tarikhKembaliBertugas = Carbon::parse($tarikhBertugas)->format('Y-m-d');
        $insuran = Carbon::parse($tarikh)->format('Y-m-d');

        $end = Carbon::parse($tarikhMulaPerjalanan);
        $nowsaa = Carbon::now();

        $length = $end->diffInDays($nowsaa);

        $suk = User::where('role', 'DatoSUK')->get();
        // Notification::send($suk, new SenaraiKelulusan($suk));

        // return dd($length);
        $statusPermohonan = 'simpanan';

        if ($length <= 14) {
            Alert::info('Makluman', 'Permohonan mesti dibuat 14 hari sebelum perjalanan bermula');
            // flash('Permohonan mesti dibuat 14 hari sebelum perjalanan bermula')->error();
            return back()->withInput();
        } else {
            if ($jenisPermohonan == 'Rasmi') {
                //echo "string";
                // dd($negara_lebih_dari_satu, $negara_tambahan, $jenisPermohonan);
                $data = [
                    'tarikhMulaPerjalanan' => $tarikhMulaPerjalanan,
                    'tarikhAkhirPerjalanan' => $tarikhAkhirPerjalanan,
                    'tarikhInsuran' => $insuran,
                    'negara_tambahan' => $negara_tambahan,
                    'negara_lebih_dari_satu' => $negara_lebih_dari_satu,
                    'negara' => $negara,
                    'alamat' => $alamat,
                    'catatan_permohonan' => $catatan_permohonan,
                    'statusPermohonan' => $statusPermohonan,
                    'JenisPermohonan' => $jenisPermohonan,
                    'jenisKewangan' => $jenisKew,
                    'lainTujuan' => $tujuan,
                    'tick' => $tick,
                    'usersID' => $id,
                    'telefonPemohon' => $phone,
                    'created_at' => \Carbon\Carbon::now(), # \Datetime()
                    'updated_at' => \Carbon\Carbon::now(), # \Datetime()
                ];

                $idPermohonan =  Permohonan::insertGetId($data);

                // $permohon = DB::table('permohonans')
                //     ->where('tarikhMulaPerjalanan', '=', $tarikhMulaPerjalanan)
                //     ->where('tarikhAkhirPerjalanan', '=', $tarikhAkhirPerjalanan)
                //     ->where('negara', '=', $negara)
                //     ->where('alamat', '=', $alamat)
                //     ->where('JenisPermohonan', '=', $jenisPermohonan)
                //     ->where('lainTujuan', '=', $tujuan)
                //     ->where('statusPermohonan', '=', $statusPermohonan)
                //     ->where('usersID', '=', $id)
                //     ->first();

                // $idPermohonan = $permohon->permohonansID;

                $dataPasangan = [
                    'namaPasangan' => $namaPasangan,
                    'hubungan' => $hubungan,
                    'alamatPasangan' => $alamatPasangan,
                    'phonePasangan' => $phonePasangan,
                    'emailPasangan' => $emailPasangan,
                    'permohonansID' => $idPermohonan,
                    'created_at' => \Carbon\Carbon::now(), # \Datetime()
                    'updated_at' => \Carbon\Carbon::now(), # \Datetime()
                ];
                DB::table('pasangans')->insert($dataPasangan);

                if ($request->hasFile('filesokongan')) {
                    $files = $request->file('filesokongan');

                    foreach ($files as $file) {
                        $filename = $file->hashName();
                        $extension = $file->extension();

                        if ($extension == 'pdf' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'docx' || $extension == 'JPG' || $extension == 'DOC' || $extension == 'doc') {
                            // check folder for 'current year', if not exist, create one
                            $currYear = Carbon::now()->format('Y');

                            $storagePath = 'upload/dokumen_sokongan/' . $currYear;

                            $filePath = str_replace(base_path() . '/', '', $storagePath) . '/' . $filename;
                            $upload_success = $file->storeAs($storagePath, $filename);

                            if ($upload_success) {
                                $data = [
                                    'namaFile_sokongan' => $filename,
                                    'typeFile_sokongan' => $extension,
                                    'pathFile_sokongan' => $filePath,
                                    'permohonansID' => $idPermohonan,
                                    'created_at' => \Carbon\Carbon::now(), # \Datetime()
                                    'updated_at' => \Carbon\Carbon::now(), # \Datetime()
                                ];
                                DB::table('dokumen_sokongan')->insert($data);
                            } else {
                                flash::error('Muat naik tidak berjaya' . $doc_type);
                                Alert::error('Tidak Berjaya', 'Muat naik Dokumen Sokongan Tidak Berjaya ' . $doc_type);
                                return redirect('/senaraiPermohonanProses');
                            }
                        } else {
                            // echo '<div class="alert alert-warning"><strong>Warning!</strong> Sorry Only Upload png , jpg , doc</div>';
                            Alert::error('Tidak Berjaya', 'Muat naik tidak berjaya. Hanya fail berformat pdf,jpg,jpeg,png dan doc sahaja.' . $doc_type);
                            return redirect('/senaraiPermohonanProses');
                        }
                    }
                }

                if ($request->hasFile('fileRasmi')) {
                    // $allowedfileExtension=['pdf','jpg','png','docx'];
                    $files = $request->file('fileRasmi');

                    foreach ($files as $file) {
                        // $filename = $file->getClientOriginalName();
                        $filename = $file->hashName();
                        $extension = $file->extension();

                        // dd($filename, $filename2,$extension);
                        if ($extension == 'pdf' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'docx' || $extension == 'JPG' || $extension == 'DOC' || $extension == 'doc') {
                            // check folder for 'current year', if not exist, create one
                            $currYear = Carbon::now()->format('Y');
                            // $storagePath = public_path() . 'upload/dokumen/' . $currYear;
                            $storagePath = 'upload/dokumen/' . $currYear;
                            $filePath = str_replace(base_path() . '/', '', $storagePath) . '/' . $filename;

                            $upload_success = $file->storeAs($storagePath, $filename);

                            if ($upload_success) {
                                $data = [
                                    'namaFile' => $filename,
                                    'typeFile' => $extension,
                                    'pathFile' => $filePath,
                                    'permohonansID' => $idPermohonan,
                                    'created_at' => \Carbon\Carbon::now(), # \Datetime()
                                    'updated_at' => \Carbon\Carbon::now(), # \Datetime()
                                ];
                                Dokumen::create($data);
                            } else {
                                flash::error('Muat naik tidak berjaya' . $doc_type);
                                Alert::error('Tidak Berjaya', 'Muat naik dokumen rasmi tidak berjaya ' . $doc_type);
                                return redirect('/senaraiPermohonanProses');
                            }
                        } else {
                            // echo '<div class="alert alert-warning"><strong>Warning!</strong> Sorry Only Upload png , jpg , doc</div>';
                            Alert::error('Tidak Berjaya', 'Muat naik tidak berjaya. Hanya fail berformat pdf,jpg,jpeg,png dan doc sahaja.' . $doc_type);
                            return redirect('/senaraiPermohonanProses');
                        }
                    }
                    // flash('Permohonan berjaya didaftar.')->success();
                    Alert::success('Berjaya', 'Permohonan Berjaya DidaftarKan');
                    return redirect('/senaraiPermohonanProses');
                } else {
                    Alert::warning('Berjaya', 'Permohonan didaftar tanpa dokumen rasmi');
                    // flash('Berjaya didaftar tanpa dokumen rasmi!')->warning();
                    return redirect('/senaraiPermohonanProses');
                }
                
            } elseif ($jenisPermohonan == 'Tidak Rasmi') {
                // $tempohCuti = $request->input('tempohCuti');
                // $dateCuti = explode('-', $tempohCuti); // dateRange is you string
                // $dateFromCuti = $dateCuti[0];
                // $dateToCuti = $dateCuti[1];

                // $DateNew1Cuti = strtotime($dateFromCuti);
                // $DateNew2Cuti = strtotime($dateToCuti);
                // $tarikhMulaCuti = date('Y-m-d', $DateNew1Cuti);
                // $tarikhAkhirCuti = date('Y-m-d', $DateNew2Cuti);

                $dateFromCuti = $request->input('tarikhMulaCuti');
                $dateToCuti = $request->input('tarikhAkhirCuti');

                $tarikhMulaCuti = Carbon::parse($dateFromCuti)->format('Y-m-d');
                $tarikhAkhirCuti = Carbon::parse($dateToCuti)->format('Y-m-d');

                $data = [
                    'tarikhMulaPerjalanan' => $tarikhMulaPerjalanan,
                    'tarikhAkhirPerjalanan' => $tarikhAkhirPerjalanan,
                    'tarikhInsuran' => $insuran,
                    'negara' => $negara,
                    'negara_tambahan' => $negara_tambahan,
                    'negara_lebih_dari_satu' => $negara_lebih_dari_satu,
                    'alamat' => $alamat,
                    'statusPermohonan' => $statusPermohonan,
                    'JenisPermohonan' => $jenisPermohonan,
                    'jenisKewangan' => $jenisKew,
                    'lainTujuan' => $tujuan,
                    'tarikhMulaCuti' => $tarikhMulaCuti,
                    'tarikhAkhirCuti' => $tarikhAkhirCuti,
                    'tarikhKembaliBertugas' => $tarikhKembaliBertugas,
                    'catatan_permohonan' => $catatan_permohonan,
                    'tick' => $tick,
                    'usersID' => $id,
                    'telefonPemohon' => $phone,
                    'created_at' => \Carbon\Carbon::now(), # \Datetime()
                    'updated_at' => \Carbon\Carbon::now(), # \Datetime()
                ];

                $idPermohonan = Permohonan::insertGetId($data);

                // dd($tarikhMulaPerjalanan, $tarikhAkhirPerjalanan, $tarikhKembaliBertugas, $tarikhMulaCuti, $tarikhAkhirCuti);
                if ($request->hasFile('filesokongan')) {
                    $files = $request->file('filesokongan');

                    foreach ($files as $file) {
                        $filename = $file->hashName();
                        $extension = $file->extension();

                        if ($extension == 'pdf' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'docx' || $extension == 'JPG' || $extension == 'DOC' || $extension == 'doc') {
                            // check folder for 'current year', if not exist, create one
                            $currYear = Carbon::now()->format('Y');

                            $storagePath = 'upload/dokumen_sokongan/' . $currYear;

                            $filePath = str_replace(base_path() . '/', '', $storagePath) . '/' . $filename;
                            $upload_success = $file->storeAs($storagePath, $filename);

                            if ($upload_success) {
                                $data = [
                                    'namaFile_sokongan' => $filename,
                                    'typeFile_sokongan' => $extension,
                                    'pathFile_sokongan' => $filePath,
                                    'permohonansID' => $idPermohonan,
                                    'created_at' => \Carbon\Carbon::now(), # \Datetime()
                                    'updated_at' => \Carbon\Carbon::now(), # \Datetime()
                                ];
                                DB::table('dokumen_sokongan')->insert($data);
                            } else {
                                flash::error('Muat naik tidak berjaya' . $doc_type);
                                Alert::error('Tidak Berjaya', 'Muat naik Dokumen Sokongan Tidak Berjaya ' . $doc_type);
                                return redirect('/senaraiPermohonanProses');
                            }
                        } else {
                            // echo '<div class="alert alert-warning"><strong>Warning!</strong> Sorry Only Upload png , jpg , doc</div>';
                            Alert::error('Tidak Berjaya', 'Muat naik tidak berjaya. Hanya fail berformat pdf,jpg,jpeg,png dan doc sahaja.' . $doc_type);
                            return redirect('/senaraiPermohonanProses');
                        }
                    }
                }

                if ($request->hasFile('fileCuti')) {
                    // $allowedfileExtension=['pdf','jpg','png','docx'];
                    $files = $request->file('fileCuti');

                    foreach ($files as $file) {
                        $filename = $file->hashName();
                        // $filename = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();

                        // dd($filename);

                        if ($extension == 'pdf' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'docx' || $extension == 'JPG') {
                            // check folder for 'current year', if not exist, create one
                            $currYear = Carbon::now()->format('Y');
                            // $storagePath = public_path() . 'upload/dokumen/' . $currYear;
                            $storagePath = 'upload/dokumen/' . $currYear . '/cuti/' . $id . '';
                            // $storagePath = 'upload/dokumen/' . $currYear;
                            $filePath = str_replace(base_path() . '/', '', $storagePath) . '/' . $filename;

                            // if (!file_exists($storagePath)) {
                            //     mkdir($storagePath, 0777, true);
                            // }
                            $upload_success = $file->storeAs($storagePath, $filename);

                            if ($upload_success) {
                                $data = [
                                    'namaFileCuti' => $filename,
                                    'jenisFileCuti' => $extension,
                                    'pathFileCuti' => $filePath
                                ];
                                Permohonan::where('permohonanID', $idPermohonan)->update($data);
                            } else {
                                // Flash::error('Muat naik tidak berjaya.' . $doc_type);
                                Alert::error('Tidak Berjaya', 'Muat naik tidak berjaya ' . $doc_type);
                                return redirect('/senaraiPermohonanProses');
                            }
                        } else {
                            echo '<div class="alert alert-warning"><strong>Warning!</strong> Sorry Only Upload png , jpg , doc</div>';
                            return redirect('/senaraiPermohonanProses');
                        }
                    }
                }

                $dataPasangan = [
                    'namaPasangan' => $namaPasangan,
                    'hubungan' => $hubungan,
                    'alamatPasangan' => $alamatPasangan,
                    'phonePasangan' => $phonePasangan,
                    'emailPasangan' => $emailPasangan,
                    'permohonansID' => $idPermohonan,
                    'created_at' => \Carbon\Carbon::now(), # \Datetime()
                    'updated_at' => \Carbon\Carbon::now(), # \Datetime()
                ];

                DB::table('pasangans')->insert($dataPasangan);
                // flash('Permohonan berjaya didaftar.')->success();
                Alert::success('Berjaya', 'Permohonan Berjaya DidaftarKan');
                return redirect('/senaraiPermohonanProses');
            }
        }
    }

    public function storeRombongan(Request $request)
    {
        // dd($request);
        $id = $request->input('id');
        $dateInsuran = $request->input('tarikhInsuranRom');
        $tarikhmulaAkhir = $request->input('tarikhmulaAkhir');
        $tujuanRom = $request->input('tujuanRom');
        $negaraRom = $request->input('negaraRom');
        $negaraRom_lebih = $request->input('negaraRom_lebih');
        $negaraRom_tambahan = implode(', ', $request->input('negaraRom_tambahan'));
        $alamatRom = $request->input('alamatRom');
        $jenisKewanganRom = $request->input('jenisKewanganRom');
        $anggaranBelanja = $request->input('anggaranBelanja');
        $catatan_permohonan = $request->input('catatan_permohonan');
        $jenisRombongan = $request->input('jenisRombongan');

        $tarikhmulaAkhirCuti = $request->input('tarikhmulaAkhirCuti');
        $kembaliTugas = $request->input('tarikhKembaliBertugas');

        $statusPermohonan = 'simpanan';

        $reference_num_secs = time();
        $ref_no_date = date('ymdHis', $reference_num_secs);
        $code = 'ELN' . $ref_no_date;

        $dateFrom = $request->input('tarikhMulaRom');
        $dateTo = $request->input('tarikhAkhirRom');

        $tarikhMulaRom = Carbon::parse($dateFrom)->format('Y-m-d');
        $tarikhAkhirRom = Carbon::parse($dateTo)->format('Y-m-d');
        $tarikhInsuranRom = Carbon::parse($dateInsuran)->format('Y-m-d');

        // $date = explode('-', $tarikhmulaAkhir); // dateRange is you string
        // $dateFrom = $date[0];
        // $dateTo = $date[1];

        // $DateNew1 = strtotime($dateFrom);
        // $DateNew2 = strtotime($dateTo);
        // $DateNew3 = strtotime($dateInsuran);
        // $tarikhMulaRom = date('Y-m-d', $DateNew1);
        // $tarikhAkhirRom = date('Y-m-d', $DateNew2);
        // $tarikhInsuranRom = date('Y-m-d', $DateNew3);

        if ($jenisRombongan == 'Tidak Rasmi') {
            // $tt = explode('-', $tarikhmulaAkhirCuti); // dateRange is you string
            // $dari = $tt[0];
            // $hingga = $tt[1];

            // $tarikh1 = strtotime($dari);
            // $tarikh2 = strtotime($hingga);
            // $tarikh3 = strtotime($kembaliTugas);
            // $tarikhMulaCuti = date('Y-m-d', $tarikh1);
            // $tarikhAkhirCuti = date('Y-m-d', $tarikh2);
            // $tarikhKembaliBertugas = date('Y-m-d', $tarikh3);

            $dari = $request->input('tarikhMulaCuti');
            $hingga = $request->input('tarikhAkhirCuti');

            $tarikhMulaCuti = Carbon::parse($dari)->format('Y-m-d');
            $tarikhAkhirCuti = Carbon::parse($hingga)->format('Y-m-d');
            $tarikhKembaliBertugas = Carbon::parse($kembaliTugas)->format('Y-m-d');
        }

        $end = Carbon::parse($tarikhMulaRom);
        $nowsaa = Carbon::now();

        $length = $end->diffInDays($nowsaa);
        // return dd($length);

        if ($length <= 14) {
            Alert::info('Makluman', 'Permohonan mesti dibuat 14 hari sebelum perjalanan bermula');
            // flash('Permohonan mesti dibuat 14 hari sebelum perjalanan bermula')->error();
            return back()->withInput();
            $negara_tambahan = $request->input('negara_tambahan');
            $negara_lebih_dari_satu = $request->input('negara_lebih');
        } else {
            $data = [
                'tarikhMulaRom' => $tarikhMulaRom,
                'tarikhAkhirRom' => $tarikhAkhirRom,
                'tarikhInsuranRom' => $tarikhInsuranRom,
                'jenis_rombongan' => $jenisRombongan,
                'codeRom' => $code,
                'negaraRom' => $negaraRom,
                'negaraRom_tambahan' => $negaraRom_tambahan,
                'negaraRom_lebih' => $negaraRom_lebih,
                'alamatRom' => $alamatRom,
                'statusPermohonanRom' => $statusPermohonan,
                'catatan_permohonan' => $catatan_permohonan,
                'tujuanRom' => $tujuanRom,
                'jenisKewanganRom' => $jenisKewanganRom,
                'anggaranBelanja' => $anggaranBelanja,
                'usersID' => $id,
                'ketua_rombongan' => $id,
                'created_at' => \Carbon\Carbon::now(), # \Datetime()
                'updated_at' => \Carbon\Carbon::now(), # \Datetime()
            ];
            $getid = DB::table('rombongans')->insertGetId($data);

            $rombo = DB::table('rombongans')
                ->where('rombongans_id', '=', $getid)
                ->first();

            if ($rombo->jenis_rombongan == 'Rasmi') {
                $data2 = [
                    'tarikhMulaPerjalanan' => $tarikhMulaRom,
                    'tarikhAkhirPerjalanan' => $tarikhAkhirRom,
                    'negara' => $negaraRom,
                    'negara_tambahan' => $negaraRom_tambahan,
                    'negara_lebih_dari_satu' => $negaraRom_lebih,
                    'alamat' => $alamatRom,
                    'statusPermohonan' => 'Lulus Semakan BPSM',
                    'JenisPermohonan' => 'rombongan',
                    'catatan_permohonan' => $catatan_permohonan,
                    'lainTujuan' => $tujuanRom,
                    'tick' => 'yes',
                    'usersID' => $id,
                    'rombongans_id' => $getid,
                    'created_at' => \Carbon\Carbon::now(), # \Datetime()
                    'updated_at' => \Carbon\Carbon::now(), # \Datetime()
                ];
                Permohonan::create($data2);

                $co = $rombo->rombongans_id;

                if ($request->hasFile('fileRasmiRom')) {
                    // $allowedfileExtension=['pdf','jpg','png','docx'];
                    $files = $request->file('fileRasmiRom');

                    foreach ($files as $file) {
                        $filename = $file->hashName();
                        // $filename = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();

                        //dd($extension);
                        if ($extension == 'pdf' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'docx' || $extension == 'JPG' || $extension == 'doc') {
                            // check folder for 'current year', if not exist, create one
                            $currYear = Carbon::now()->format('Y');
                            $storagePath = 'upload/dokumen/' . $currYear . '/rombongan/rasmi/' . $id . '';
                            $filePath = str_replace(base_path() . '/', '', $storagePath) . '/' . $filename;

                            // if (!file_exists($storagePath)) {
                            //     mkdir($storagePath, 0777, true);
                            // }
                            $upload_success = $file->storeAs($storagePath, $filename);

                            if ($upload_success) {
                                $data = [
                                    'namaFile' => $filename,
                                    'typeFile' => $extension,
                                    'pathFile' => $filePath,
                                    'rombongans_id' => $co,
                                ];
                                Dokumen::create($data);
                            } else {
                                Flash::error('Muat naik tidak berjaya' . $doc_type);
                                return back();
                            }
                        } else {
                            echo '<div class="alert alert-warning"><strong>Warning!</strong> Sorry Only Upload png , jpg , doc</div>';
                            // flash('Sorry Only Upload png , jpg , doc.')->warning();
                            return redirect('/senaraiPermohonanProses');
                        }
                    }
                }
                 // flash('Permohonan berjaya didaftar.')->success();
                 Alert::success('Berjaya', 'Permohonan Berjaya DidaftarKan');
                 return redirect('/senaraiPermohonanProses');
            } elseif ($rombo->jenis_rombongan == 'Tidak Rasmi') {
                $co = $rombo->rombongans_id;

                $data = [
                    'tarikhMulaPerjalanan' => $tarikhMulaRom,
                    'tarikhAkhirPerjalanan' => $tarikhAkhirRom,
                    'negara' => $negaraRom,
                    'negara_tambahan' => $negaraRom_tambahan,
                    'negara_lebih_dari_satu' => $negaraRom_lebih,
                    'alamat' => $alamatRom,
                    'statusPermohonan' => 'Lulus Semakan BPSM',
                    'tarikhMulaCuti' => $tarikhMulaCuti,
                    'tarikhAkhirCuti' => $tarikhAkhirCuti,
                    'tarikhKembaliBertugas' => $tarikhKembaliBertugas,
                    'JenisPermohonan' => 'rombongan',
                    'catatan_permohonan' => $catatan_permohonan,
                    'lainTujuan' => $tujuanRom,
                    'tick' => 'yes',
                    'usersID' => $id,
                    'rombongans_id' => $co,
                    'created_at' => \Carbon\Carbon::now(), # \Datetime()
                    'updated_at' => \Carbon\Carbon::now(), # \Datetime()
                ];
                $id_permohonan_rombongan = Permohonan::insertGetID($data);

                if ($request->hasFile('fileCuti')) {
                    // $allowedfileExtension=['pdf','jpg','png','docx'];
                    // $file = $request->file('fileCuti');
                    foreach ($request->file('fileCuti') as $file) {
                        $filename = $file->hashName();
                        // $filename = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();

                        // dd($filename, $extension);
                        if ($extension == 'pdf' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'docx' || $extension == 'JPG' || $extension == 'doc') {
                            // check folder for 'current year', if not exist, create one
                            $currYear = Carbon::now()->format('Y');
                            $storagePath = 'upload/dokumen/' . $currYear . '/rombongan/cuti';
                            $filePath = str_replace(base_path() . '/', '', $storagePath) . '/' . $filename;

                            echo $currYear;
                            // if (!file_exists($storagePath)) {
                            //     mkdir($storagePath, 0777, true);
                            // }
                            $upload_success = $file->storeAs($storagePath, $filename);

                            if ($upload_success) {

                                $data = [
                                    'namaFileCuti' => $filename,
                                    'jenisFileCuti' => $extension,
                                    'pathFileCuti' => $filePath,                                  
                                    'updated_at' => \Carbon\Carbon::now(), # \Datetime()
                                ];
                                Permohonan::where('permohonansID', $id_permohonan_rombongan)->update($data);
                            } else {
                                Flash::error('Error uploading ' . $doc_type);
                                return back();
                            }
                        } else {
                            // flash('Permohonan berjaya didaftar.')->error();
                            echo '<div class="alert alert-warning"><strong>Warning!</strong> Sorry Only Upload png , jpg , doc</div>';
                            return back('');
                        }
                    }
                }
                // flash('Permohonan berjaya didaftar.')->success();
                Alert::success('Berjaya', 'Permohonan Berjaya DidaftarKan');
                return redirect('/senaraiPermohonanProses');
            }
        }
    }

    public function storeIndividuRombongan(Request $request)
    {
        $id = $request->input('id');
        $kodRombo = $request->input('kodRombo');
        $tarikhmulaAkhirCuti = $request->input('tarikhmulaAkhirCuti');
        $kembaliTugas = $request->input('tarikhKembaliBertugas');
        $catatan_permohonan = $request->input('catatan_permohonan');
        $tick = $request->input('tick');

        $user = User::where('usersID', '=', $id)->first();

        $statusJawatan = $user->userJawatan->statusDato;

        // dd($id, $statusJawatan);
        // $check = Rombongan::where('codeRom', $kodRombo)->first();

        // $per = Permohonan::where('rombongans_id', $check->rombongans_id)->first();

        // dd($per->rombongans_id);

        $tarikhMulaCuti = Carbon::parse($request->input('tarikhMulaCuti'))->format('Y-m-d');
        $tarikhAkhirCuti = Carbon::parse($request->input('tarikhAkhirCuti'))->format('Y-m-d');
        $tarikhKembaliBertugas = Carbon::parse($request->input('tarikhKembaliBertugas'))->format('Y-m-d');

        // $date = explode('-', $tarikhmulaAkhirCuti); // dateRange is you string
        // $dateFrom = $date[0];
        // $dateTo = $date[1];

        // $DateNew1 = strtotime($dateFrom);
        // $DateNew2 = strtotime($dateTo);
        // $DateNew3 = strtotime($kembaliTugas);
        // $tarikhMulaCuti = date('Y-m-d', $DateNew1);
        // $tarikhAkhirCuti = date('Y-m-d', $DateNew2);
        // $tarikhKembaliBertugas = date('Y-m-d', $DateNew3);

        // $statusPermohonan = 'Ketua Jabatan';

        $rombo = DB::table('rombongans')
            ->where('codeRom', '=', $kodRombo)
            ->where('statusPermohonanRom', '=', 'simpanan')
            ->first();

        $bil =  DB::table('permohonans')
            ->where('rombongans_id', $rombo->rombongans_id)
            ->where('usersID', $id)
            ->whereNotIn('statusPermohonan', ['Permohonan Gagal'])
            ->count();
        $ketua = User::where('role', 'jabatan')->where('jabatan', $user->jabatan)->get();
        $suk = User::where('role', 'DatoSUK')->get();

        // dd($bil, $id, $rombo->rombongans_id);

        if ($rombo == null) {
            // user doesn't exist
            Alert::error('', 'Kod Rombongan tidak wujud atau permohonan rombongan telah dihantar');
            // flash('Kod Rombongan tidak wujud atau permohonan rombongan telah dihantar kepada ketua bahagian')->error();
            return back()->withInput();
        } else {
            $tarikhMulaRom = $rombo->tarikhMulaRom;
            $tarikhAkhirRom = $rombo->tarikhAkhirRom;
            $tarikhInsuranRom = $rombo->tarikhInsuranRom;
            $negaraRom = $rombo->negaraRom;
            $negaraRom_tambahan = $rombo->negaraRom_tambahan;
            $negaraRom_lebih = $rombo->negaraRom_lebih;

            $alamatRom = $rombo->alamatRom;
            $tujuanRom = $rombo->tujuanRom;
            $idRom = $rombo->rombongans_id;

            $end = Carbon::parse($tarikhMulaRom);
            $nowsaa = Carbon::now();

            $length = $end->diffInDays($nowsaa);

            if ($bil > 0) {
                Alert::error('', 'Rombongan ini telah disertai oleh anda');
                return back()->withInput();
            } else {
                if ($length <= 14) {
                    Alert::info('Makluman', 'Permohonan mesti dibuat 14 hari sebelum perjalanan bermula');
                    // flash('Permohonan mesti dibuat 14 hari sebelum perjalanan bermula')->error();
                    return back()->withInput();
                } else {
                    $jenisPermohonanrombongan = 'rombongan';
                    if ($rombo->jenis_rombongan == 'Rasmi') {
                        if ($statusJawatan == 'Tidak Aktif') {
                            $statusPermohonan = 'Ketua Jabatan';

                            $data = [
                                'tarikhMulaPerjalanan' => $tarikhMulaRom,
                                'tarikhAkhirPerjalanan' => $tarikhAkhirRom,
                                'negara' => $negaraRom,
                                'negara_tambahan' => $negaraRom_tambahan,
                                'alamat' => $alamatRom,
                                'negara_lebih_dari_satu' => $negaraRom_lebih,
                                'statusPermohonan' => $statusPermohonan,
                                'tarikhMulaCuti' => $tarikhMulaCuti,
                                'tarikhAkhirCuti' => $tarikhAkhirCuti,
                                'tarikhKembaliBertugas' => $tarikhKembaliBertugas,
                                'JenisPermohonan' => $jenisPermohonanrombongan,
                                'catatan_permohonan' => $catatan_permohonan,
                                'lainTujuan' => $tujuanRom,
                                'tick' => $tick,
                                'usersID' => $id,
                                'rombongans_id' => $idRom,
                                'created_at' => \Carbon\Carbon::now(), # \Datetime()
                                'updated_at' => \Carbon\Carbon::now(), # \Datetime()
                            ];
                            Permohonan::create($data);

                            Notification::send($ketua, new SenaraiSokongan($ketua));
                        } elseif ($statusJawatan == 'Aktif') {
                            $statusPermohonan = 'Lulus Semakan BPSM';

                            $data = [
                                'tarikhMulaPerjalanan' => $tarikhMulaRom,
                                'tarikhAkhirPerjalanan' => $tarikhAkhirRom,
                                'negara' => $negaraRom,
                                'alamat' => $alamatRom,
                                'negara_tambahan' => $negaraRom_tambahan,
                                'statusPermohonan' => $statusPermohonan,
                                'negara_lebih_dari_satu' => $negaraRom_lebih,
                                'tarikhMulaCuti' => $tarikhMulaCuti,
                                'tarikhAkhirCuti' => $tarikhAkhirCuti,
                                'tarikhKembaliBertugas' => $tarikhKembaliBertugas,
                                'JenisPermohonan' => $jenisPermohonanrombongan,
                                'catatan_permohonan' => $catatan_permohonan,
                                'lainTujuan' => $tujuanRom,
                                'tick' => $tick,
                                'usersID' => $id,
                                'rombongans_id' => $idRom,
                                'created_at' => \Carbon\Carbon::now(), # \Datetime()
                                'updated_at' => \Carbon\Carbon::now(), # \Datetime()
                            ];
                            $idd = Permohonan::insertGetId($data);

                            Eln_pengesahan_bahagian::insertGetId([
                                'id_permohonan' => $idd,
                                'id_rombongan' => $idRom,
                                'id_pemohon' => Auth::user()->usersID,
                                'jawatan_pemohon' => $user->userJawatan->namaJawatan,
                                'gred_pemohon' => '' . $user->userGredKod->gred_kod_abjad . ' ' . $user->userGredAngka->gred_angka_nombor . '',
                                'jabatan_pemohon' => $user->userJabatan->jabatan_id,
                                'taraf_pemohon' => $user->taraf,
                                'id_pengesah' => Auth::user()->usersID,
                                'jawatan_pengesah' => 'Terus Dato',
                                'gred_pengesah' => 'Terus Dato',
                                // 'gred_pengesah' => ''.$pengesah->userGredKod->gred_kod_abjad.''.$pengesah->userGredAngka->gred_angka_nombor.'',
                                // 'jabatan_pengesah' => $pengesah->userJabatan->jabatan_id,
                                'jabatan_pengesah' => 'Terus Dato',
                                'ulasan' => 'Disokong',
                                'status_pengesah' => 'disokong',
                                'created_at' => \Carbon\Carbon::now(), # new \Datetime()
                                'updated_at' => \Carbon\Carbon::now(), # new \Datetime()
                            ]);

                            Notification::send($suk, new SenaraiKelulusan($suk));
                        }
                        // flash('Permohonan berjaya didaftar.')->success();
                        Alert::success('Berjaya', 'Permohonan Berjaya DidaftarKan');
                        return redirect('/senaraiPermohonanProses');
                    } elseif ($rombo->jenis_rombongan == 'Tidak Rasmi') {
                        // $validated = $request->validate([
                        //     'tarikhMulaCuti' => 'required',
                        //     'tarikhAkhirCuti' => 'required',
                        //     'tarikhKembaliBertugas' => 'required',
                        //     'fileCuti' => 'required',
                        // ]);
                        if ($request->hasFile('fileCuti')) {
                            // $allowedfileExtension=['pdf','jpg','png','docx'];
                            // $file = $request->file('fileCuti');
                            foreach ($request->file('fileCuti') as $file) {
                                $filename = $file->hashName();
                                // $filename = $file->getClientOriginalName();
                                $extension = $file->getClientOriginalExtension();

                                // dd($filename, $extension);
                                if ($extension == 'pdf' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'docx' || $extension == 'JPG' || $extension == 'doc') {
                                    // check folder for 'current year', if not exist, create one
                                    $currYear = Carbon::now()->format('Y');
                                    $storagePath = 'upload/dokumen/' . $currYear;
                                    $filePath = str_replace(base_path() . '/', '', $storagePath) . '/' . $filename;

                                    echo $currYear;
                                    // if (!file_exists($storagePath)) {
                                    //     mkdir($storagePath, 0777, true);
                                    // }
                                    $upload_success = $file->storeAs($storagePath, $filename);

                                    if ($upload_success) {
                                        if ($statusJawatan == 'Tidak Aktif') {
                                            $statusPermohonan = 'Ketua Jabatan';

                                            $data = [
                                                'tarikhMulaPerjalanan' => $tarikhMulaRom,
                                                'tarikhAkhirPerjalanan' => $tarikhAkhirRom,
                                                'negara' => $negaraRom,
                                                'negara_lebih_dari_satu' => $negaraRom_lebih,
                                                'negara_tambahan' => $negaraRom_tambahan,
                                                'alamat' => $alamatRom,
                                                'statusPermohonan' => $statusPermohonan,
                                                'tarikhMulaCuti' => $tarikhMulaCuti,
                                                'tarikhAkhirCuti' => $tarikhAkhirCuti,
                                                'tarikhKembaliBertugas' => $tarikhKembaliBertugas,
                                                'JenisPermohonan' => $jenisPermohonanrombongan,
                                                'catatan_permohonan' => $catatan_permohonan,
                                                'namaFileCuti' => $filename,
                                                'jenisFileCuti' => $extension,
                                                'pathFileCuti' => $filePath,
                                                'lainTujuan' => $tujuanRom,
                                                'tick' => $tick,
                                                'usersID' => $id,
                                                'rombongans_id' => $idRom,
                                                'created_at' => \Carbon\Carbon::now(), # \Datetime()
                                                'updated_at' => \Carbon\Carbon::now(), # \Datetime()
                                            ];
                                            Permohonan::create($data);

                                            Notification::send($ketua, new SenaraiSokongan($ketua));
                                        } elseif ($statusJawatan == 'Aktif') {
                                            $statusPermohonan = 'Lulus Semakan BPSM';

                                            $data = [
                                                'tarikhMulaPerjalanan' => $tarikhMulaRom,
                                                'tarikhAkhirPerjalanan' => $tarikhAkhirRom,
                                                'negara' => $negaraRom,
                                                'negara_lebih_dari_satu' => $negaraRom_lebih,
                                                'negara_tambahan' => $negaraRom_tambahan,
                                                'alamat' => $alamatRom,
                                                'statusPermohonan' => $statusPermohonan,
                                                'tarikhMulaCuti' => $tarikhMulaCuti,
                                                'tarikhAkhirCuti' => $tarikhAkhirCuti,
                                                'tarikhKembaliBertugas' => $tarikhKembaliBertugas,
                                                'JenisPermohonan' => $jenisPermohonanrombongan,
                                                'catatan_permohonan' => $catatan_permohonan,
                                                'namaFileCuti' => $filename,
                                                'jenisFileCuti' => $extension,
                                                'pathFileCuti' => $filePath,
                                                'lainTujuan' => $tujuanRom,
                                                'tick' => $tick,
                                                'usersID' => $id,
                                                'rombongans_id' => $idRom,
                                                'created_at' => \Carbon\Carbon::now(), # \Datetime()
                                                'updated_at' => \Carbon\Carbon::now(), # \Datetime()
                                            ];

                                            $idd = Permohonan::insertGetId($data);

                                            Eln_pengesahan_bahagian::insertGetId([
                                                'id_permohonan' => $idd,
                                                'id_rombongan' => $idRom,
                                                'id_pemohon' => Auth::user()->usersID,
                                                'jawatan_pemohon' => $user->userJawatan->namaJawatan,
                                                'gred_pemohon' => '' . $user->userGredKod->gred_kod_abjad . ' ' . $user->userGredAngka->gred_angka_nombor . '',
                                                'jabatan_pemohon' => $user->userJabatan->jabatan_id,
                                                'taraf_pemohon' => $user->taraf,
                                                'id_pengesah' => Auth::user()->usersID,
                                                'jawatan_pengesah' => 'Terus Dato',
                                                'gred_pengesah' => 'Terus Dato',
                                                // 'gred_pengesah' => ''.$pengesah->userGredKod->gred_kod_abjad.''.$pengesah->userGredAngka->gred_angka_nombor.'',
                                                // 'jabatan_pengesah' => $pengesah->userJabatan->jabatan_id,
                                                'jabatan_pengesah' => 'Terus Dato',
                                                'ulasan' => 'Disokong',
                                                'status_pengesah' => 'disokong',
                                                'created_at' => \Carbon\Carbon::now(), # new \Datetime()
                                                'updated_at' => \Carbon\Carbon::now(), # new \Datetime()
                                            ]);

                                            Notification::send($suk, new SenaraiKelulusan($suk));
                                        }

                                        // $data = [
                                        //     'tarikhMulaPerjalanan' => $tarikhMulaRom,
                                        //     'tarikhAkhirPerjalanan' => $tarikhAkhirRom,
                                        //     'negara' => $negaraRom,
                                        //     'alamat' => $alamatRom,
                                        //     'statusPermohonan' => $statusPermohonan,
                                        //     'tarikhMulaCuti' => $tarikhMulaCuti,
                                        //     'tarikhAkhirCuti' => $tarikhAkhirCuti,
                                        //     'tarikhKembaliBertugas' => $tarikhKembaliBertugas,
                                        //     'JenisPermohonan' => $jenisPermohonanrombongan,
                                        //     'catatan_permohonan' => $catatan_permohonan,
                                        //     'namaFileCuti' => $filename,
                                        //     'jenisFileCuti' => $extension,
                                        //     'pathFileCuti' => $filePath,
                                        //     'lainTujuan' => $tujuanRom,
                                        //     'tick' => $tick,
                                        //     'usersID' => $id,
                                        //     'rombongans_id' => $idRom,
                                        //     'created_at' => \Carbon\Carbon::now(), # \Datetime()
                                        //     'updated_at' => \Carbon\Carbon::now(), # \Datetime()
                                        // ];
                                        // Permohonan::create($data);

                                        // flash('Permohonan berjaya didaftar.')->success();
                                        Alert::success('Berjaya', 'Permohonan Berjaya DidaftarKan');
                                        return redirect('/senaraiPermohonanProses');
                                    } else {
                                        Flash::error('Error uploading ' . $doc_type);
                                        return back();
                                    }
                                } else {
                                    // flash('Permohonan berjaya didaftar.')->error();
                                    echo '<div class="alert alert-warning"><strong>Warning!</strong> Sorry Only Upload png , jpg , doc</div>';
                                    return back('');
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function show($id)
    {
        $userDetail = User::find($id);
        $negara = Negara::all();
        $options = Negara::pluck('namaNegara');

        return view('registerForm', compact('userDetail', 'options'));
    }

    public function hantarIndividu($id)
    {
        $id = Hashids::decode($id);
        $permohonan = Permohonan::with('user')
            ->where('permohonansID', '=', $id)
            ->first();

        $statusJawatan = $permohonan->user->userJawatan->statusDato;

        $tarikhmulajalan = $permohonan->tarikhMulaPerjalanan;

        $end = Carbon::parse($tarikhmulajalan);
        $nowsaa = Carbon::today();

        $length = $end->diffInDays($nowsaa); //panjang hari sebelum berlepas
        // dd($length);

        $d = DB::table('permohonans')
            ->where('permohonansID', '=', $id)
            ->whereNotNull('namaFileCuti')
            ->count();
        $dokumenRasmi = DB::table('dokumens')
            ->where('permohonansID', '=', $id)
            ->count();
        $per = DB::table('permohonans')
            ->where('permohonansID', '=', $id)
            ->first();

        $status = $per->JenisPermohonan;

        $jabatan = User::where('usersID', Auth::user()->usersID)->first();

        $user = User::where('role', 'jabatan')
            ->where('jabatan', $jabatan->jabatan)
            ->get();

        // dd($user);
        $suk = User::where('role', 'DatoSUK')->get();

        if ($status == 'Rasmi') {
            if ($dokumenRasmi == 0) {
                flash('Permohonan Rasmi memerlukan dokumen rasmi.')->error();
                return back();
            } else {
                if ($statusJawatan == 'Tidak Aktif') {
                    $ubah = 'Ketua Jabatan';

                    Permohonan::where('permohonansID', '=', $id)->update(['statusPermohonan' => $ubah]);

                    Notification::send($user, new SenaraiSokongan($user));
                } elseif ($statusJawatan == 'Aktif') {
                    $ubah = 'Lulus Semakan BPSM';

                    Eln_pengesahan_bahagian::insertGetId([
                        'id_permohonan' => $id,
                        'id_rombongan' => $permohonan->rombongans_id,
                        'id_pemohon' => Auth::user()->usersID,
                        'jawatan_pemohon' => $permohonan->user->userJawatan->namaJawatan,
                        'gred_pemohon' => '' . $permohonan->user->userGredKod->gred_kod_abjad . ' ' . $permohonan->user->userGredAngka->gred_angka_nombor . '',
                        'jabatan_pemohon' => $permohonan->user->userJabatan->jabatan_id,
                        'taraf_pemohon' => $permohonan->user->taraf,
                        'id_pengesah' => Auth::user()->usersID,
                        'jawatan_pengesah' => 'Terus Dato',
                        'gred_pengesah' => 'Terus Dato',
                        // 'gred_pengesah' => ''.$pengesah->userGredKod->gred_kod_abjad.''.$pengesah->userGredAngka->gred_angka_nombor.'',
                        // 'jabatan_pengesah' => $pengesah->userJabatan->jabatan_id,
                        'jabatan_pengesah' => 'Terus Dato',
                        'ulasan' => 'disokong',
                        'status_pengesah' => 'disokong',
                        'created_at' => \Carbon\Carbon::now(), # new \Datetime()
                        'updated_at' => \Carbon\Carbon::now(), # new \Datetime()

                    ]);

                    Permohonan::where('permohonansID', '=', $id)->update([
                        'jumlahHariPermohonanBerlepas' => $length,
                        'statusPermohonan' => $ubah,
                    ]);

                    Notification::send($suk, new SenaraiKelulusan($suk));
                }

                // Alert::success('Berjaya', 'Permohonan Berjaya dihantar');
                toast('Permohonan Berjaya dihantar', 'success')->position('top-end');
                return back();
            }
        } elseif ($status == 'Tidak Rasmi') {
            if ($statusJawatan == 'Tidak Aktif') {
                $ubah = 'Ketua Jabatan';
                Permohonan::where('permohonansID', '=', $id)->update(['statusPermohonan' => $ubah]);
                Notification::send($user, new SenaraiSokongan($user));
            } elseif ($statusJawatan == 'Aktif') {
                $ubah = 'Lulus Semakan BPSM';

                Eln_pengesahan_bahagian::insertGetId([
                    'id_permohonan' => $id,
                    'id_rombongan' => $permohonan->rombongans_id,
                    'id_pemohon' => Auth::user()->usersID,
                    'jawatan_pemohon' => $permohonan->user->userJawatan->namaJawatan,
                    'gred_pemohon' => '' . $permohonan->user->userGredKod->gred_kod_abjad . ' ' . $permohonan->user->userGredAngka->gred_angka_nombor . '',
                    'jabatan_pemohon' => $permohonan->user->userJabatan->jabatan_id,
                    'taraf_pemohon' => $permohonan->user->taraf,
                    'id_pengesah' => Auth::user()->usersID,
                    'jawatan_pengesah' => 'Terus Dato',
                    'gred_pengesah' => 'Terus Dato',
                    // 'gred_pengesah' => ''.$pengesah->userGredKod->gred_kod_abjad.''.$pengesah->userGredAngka->gred_angka_nombor.'',
                    // 'jabatan_pengesah' => $pengesah->userJabatan->jabatan_id,
                    'jabatan_pengesah' => 'Terus Dato',
                    'ulasan' => 'disokong',
                    'status_pengesah' => 'disokong',
                    'created_at' => \Carbon\Carbon::now(), # new \Datetime()
                    'updated_at' => \Carbon\Carbon::now(), # new \Datetime()
                ]);

                Permohonan::where('permohonansID', '=', $id)->update([
                    'jumlahHariPermohonanBerlepas' => $length,
                    'statusPermohonan' => $ubah,
                ]);

                Notification::send($suk, new SenaraiKelulusan($suk));
            }

            toast('Permohonan Berjaya dihantar', 'success')->position('top-end');
            return back();
        }
    }

    public function hantarRombongan($id)
    {
        $errorcheck = Permohonan::where('rombongans_id', $id)
            ->whereNotIn('statusPermohonan', ['Permohonan Berjaya', 'Permohonan Gagal', 'Lulus Semakan BPSM'])
            ->count();

        $d = DB::table('dokumens')
            ->where('rombongans_id', '=', $id)
            ->count();

        $peserta = DB::table('permohonans')
            ->where('rombongans_id', '=', $id)
            ->count();

        $rombo = DB::table('rombongans')
            ->where('rombongans_id', $id)
            ->first();

        $user = User::where('usersID', $rombo->usersID)->first();

        $users = User::where('role', 'jabatan')
            ->where('jabatan', $user->jabatan)
            ->get();

        // Notification::send($users, new SenaraiSokonganRombongan($users));

        $pemohon = Permohonan::with('user')
            ->where('usersID', $user->usersID)
            ->where('rombongans_id', $id)
            ->first();

        $suk = User::where('role', 'DatoSUK')->get();


        $statusJawatan = $user->userJawatan->statusDato;
        // dd($pemohon->user->userJawatan->namaJawatan, $pemohon->user->userJabatan->jabatan_id);
        //echo $peserta;
        if ($d >= 1 && $peserta >= 2) {
            if ($statusJawatan == 'Aktif') {
                Rombongan::where('rombongans_id', $id)->update([
                    'statusPermohonanRom' => 'Lulus Semakan',
                ]);

                Eln_pengesahan_bahagian::insertGetId([
                    'id_permohonan' => $pemohon->permohonansID,
                    'id_rombongan' => $id,
                    'id_pemohon' => Auth::user()->usersID,
                    'jawatan_pemohon' => $pemohon->user->userJawatan->namaJawatan,
                    'gred_pemohon' => '' . $pemohon->user->userGredKod->gred_kod_abjad . ' ' . $pemohon->user->userGredAngka->gred_angka_nombor . '',
                    'jabatan_pemohon' => $pemohon->user->userJabatan->jabatan_id,
                    'taraf_pemohon' => $permohonan->user->taraf,
                    'id_pengesah' => Auth::user()->usersID,
                    'jawatan_pengesah' => 'Terus Dato',
                    'gred_pengesah' => 'Terus Dato',
                    'jabatan_pengesah' => 'Terus Dato',
                    'ulasan' => 'Disokong',
                    'status_pengesah' => 'disokong',
                    'created_at' => \Carbon\Carbon::now(), # new \Datetime()
                    'updated_at' => \Carbon\Carbon::now(), # new \Datetime()
                ]);

                DB::table('eln_pengesahan_bahagian_rombongan')->insertGetId([
                    'id_rombongan' => $id,
                    'id_pemohon' => Auth::user()->usersID,
                    'jawatan_pemohon' => $user->userJawatan->namaJawatan,
                    'gred_pemohon' => '' . $user->userGredKod->gred_kod_abjad . ' ' . $user->userGredAngka->gred_angka_nombor . '',
                    'jabatan_pemohon' => $user->userJabatan->jabatan_id,
                    'taraf_pemohon' => $user->taraf,
                    'id_pengesah' => Auth::user()->usersID,
                    'jawatan_pengesah' => 'Terus Dato',
                    'gred_pengesah' => 'Terus Dato',
                    'jabatan_pengesah' => 'Terus Dato',
                    'ulasan_pengesahan' => 'Disokong',
                    'status_pengesah' => 'disokong',
                    'tarikh_pengesah' => \Carbon\Carbon::now(), # new \Datetime()
                    'created_at' => \Carbon\Carbon::now(), # new \Datetime()
                    'updated_at' => \Carbon\Carbon::now(), # new \Datetime()
                ]);

                Notification::send($suk, new SenaraiKelulusanRombongan($suk));

                Permohonan::where('rombongans_id', $id)
                    ->whereNotIn('statusPermohonan', ['Permohonan Berjaya', 'Lulus Semakan BPSM'])
                    ->update([
                        'statusPermohonan' => 'Permohonan Gagal',
                    ]);

                toast('Permohonan Berjaya dihantar', 'success')->position('top-end');
                return back();
            } elseif ($statusJawatan == 'Tidak Aktif') {
                Rombongan::where('rombongans_id', $id)->update([
                    'statusPermohonanRom' => 'Pending',
                ]);

                Notification::send($users, new SenaraiSokonganRombongan($users));

                Permohonan::where('rombongans_id', $id)
                    ->whereNotIn('statusPermohonan', ['Permohonan Berjaya', 'Lulus Semakan BPSM'])
                    ->update([
                        'statusPermohonan' => 'Permohonan Gagal',
                    ]);

                toast('Permohonan Berjaya dihantar', 'success')->position('top-end');
                return back();
            }

            Permohonan::where('rombongans_id', $id)
                ->whereNotIn('statusPermohonan', ['Permohonan Berjaya', 'Lulus Semakan BPSM'])
                ->update([
                    'statusPermohonan' => 'Permohonan Gagal',
                ]);

            toast('Permohonan Berjaya dihantar', 'success')->position('top-end');
            return back();
        } elseif ($d == 0 && $peserta == 0) {
            if ($rombo->jenis_rombongan == 'Rasmi') {
                Alert::info('Makluman', 'Permohonan rombongan memerlukan dokumen rasmi dan peserta');
                // flash('Permohonan rombongan memerlukan dokumen rasmi dan peserta.')->error();
                return back();
            }
        } elseif ($d == 0) {
            if ($rombo->jenis_rombongan == 'Rasmi') {
                Alert::info('Makluman', 'Permohonan rombongan memerlukan dokumen rasmi');
                // flash('Permohonan rombongan memerlukan dokumen rasmi.')->error();
                return back();
            }
        } elseif ($peserta < 2) {
            Alert::info('Makluman', 'Permohonan rombongan memerlukan sekurang-kurang 2 orang peserta');
            // flash('Permohonan rombongan memerlukan sekurang-kurang 2 orang peserta.')->error();
            return back();
        }
    }

    public function hapus($id)
    {
        $permohonan = DB::table('permohonans')
            ->where('permohonansID', '=', $id)
            ->first();

        if ($permohonan != null) {
            $pathC = $permohonan->pathFileCuti;
            $dokumen = DB::table('dokumens')
                ->where('permohonansID', '=', $id)
                ->first();

            if ($dokumen > 0) {
                $path = $dokumen->pathFile;
                $pas = Pasangan::where('permohonansID', $id)->delete();
                $per = Permohonan::where('permohonansID', $id)->delete();
                $doku = Dokumen::where('permohonansID', $id)->delete();
                // unlink($path);
                Storage::Delete($path);
                Storage::Delete($pathC);
                // unlink($pathC);
                // flash('Dokumen berjaya dipadamkan.')->success();
                Alert::success('Berjaya', 'Dokumen telah dipadam');
                return redirect()->back();
            } elseif ($dokumen == null) {
                $pas = Pasangan::where('permohonansID', $id)->delete();
                $per = Permohonan::where('permohonansID', $id)->delete();
                // flash('Dokumen berjaya dipadamkan.')->success();
                Alert::success('Berjaya', 'Dokumen telah dipadam');
                return redirect()->back();
            } else {
                $pas = Pasangan::where('permohonansID', $id)->delete();
                $per = Permohonan::where('permohonansID', $id)->delete();
                // unlink($pathC);
                Storage::Delete($pathC);
                // flash('Dokumen berjaya dipadamkan.')->success();
                Alert::success('Berjaya', 'Dokumen telah dipadam');
                return redirect()->back();
            }
        } else {
            flash('Dokumen tidak berjaya dipadamkan.')->success();
            Alert::error('Tidak Berjaya', 'Dokumen tidak berjaya dipadam');
            return redirect()->back();
        }
    }

    public function batalpermohonan(Request $request)
    {
        $validated = $request->validate([
            'sebab_batal' => 'required',
        ]);

        $id = $request->input('id');

        Permohonan::where('permohonansID', $id)->update([
            'pengesahan_pembatalan' => 1,
            'sebab_pembatalan' => $request->input('sebab_batal'),
            'tarikh_batal' => Carbon::now(),
        ]);

        Alert::success('Berjaya', 'Permohonan telah dibatalkan');
        // flash('Permohonan telah dibatalkan.')->success();
        return back();
    }

    public function padamrombongan($id)
    {
        $id = Hashids::decode($id);
        
        $permohonan = DB::table('permohonans')
            ->where('rombongans_id', '=', $id)
            ->get();

        foreach ($permohonan as $p) {
            $pathCuti = $p->pathFileCuti;
            if ($pathCuti ?? '') {
            Storage::delete($pathCuti);
            $per = Permohonan::where('rombongans_id', $id)->delete();
            }
        }

        $dokumen = DB::table('dokumens')
            ->where('rombongans_id', '=', $id)
            ->first();

        if (!$dokumen) {
            $rombong = Rombongan::where('rombongans_id', $id)->delete();
            Alert::success('Berjaya', 'Dokumen berjaya dipadamkan');
            // flash('Dokumen berjaya dipadamkan.')->success();
            return redirect()->back();
        } else {
            $path = $dokumen->pathFile;
            Storage::delete($path);
            Dokumen::where('rombongans_id', $id)->delete();
            Rombongan::where('rombongans_id', $id)->delete();

            Alert::success('Berjaya', 'Permohonan Rombongan berjaya dipadamkan');
            // flash('Permohonan Rombongan berjaya dipadamkan.')->success();
            return redirect()->back();
        }
    }

    public function tamatIndividu($id)
    {
        $id = Hashids::decode($id);
        // return dd($id);
        $delfilecuti = Permohonan::where('permohonansID', $id)->first();
        // dd($delfilecuti->all());
        if ($delfilecuti->pathFileCuti ?? '') {
            Storage::delete($delfilecuti->pathFileCuti); // Padam file cuti

        }

        Permohonan::where('permohonansID', $id)->delete(); // Padam data permohonan

        Pasangan::where('permohonansID', $id)->delete(); // Padam data pasangan

        $doc = Dokumen::where('permohonansID', $id)->get();

        foreach ($doc as $file) {
            $url = $file->pathFile;

            Storage::delete($url); //Padam Setiap Fail Dokumen Rasmi
        }

        Dokumen::where('permohonansID', $id)->delete(); //Padam data Dokumen Rasmi

        Alert::success('Berjaya', 'Rekod berjaya dipadamkan');
        // flash('Rekod berjaya dipadamkan.')->success();
        return redirect()->back();
    }

    public function deleteFileCuti($id)
    {
        $perm = Permohonan::findOrFail($id);
        if (is_null($perm->pathFileCuti)) {
            $nul = '';
            Permohonan::where('permohonansID', '=', $id)->update([
                'namaFileCuti' => $nul,
                'jenisFileCuti' => $nul,
                'pathFileCuti' => $nul,
            ]);
        } else {
            // unlink($perm->pathFileCuti);
            Storage::Delete($perm->pathFileCuti);

            Permohonan::where('permohonansID', '=', $id)->update([
                'namaFileCuti' => null,
                'jenisFileCuti' => null,
                'pathFileCuti' => null,
            ]);
        }

        flash('Dokumen cuti telah dipadamkan.')->success();
        return redirect()->back();
    }

    public function deleteFileRasmi($id)
    {
        //echo $id;
        $dokumen = Dokumen::findOrFail($id);
        // dd($dokumen);
        $pathFile = $dokumen->pathFile;
        // echo $pathFile;
        // dd($pathFile);
        Storage::Delete($pathFile);

        $per = Dokumen::where('dokumens_id', $id)->delete();

        flash('Dokumen telah dipadamkan.')->success();
        return redirect()->back();
    }

    public function deleteFileSokongan($id)
    {
        //echo $id;
        $dokumen = DB::table('dokumen_sokongan')->where('dokumens_id_sokongan', $id)->first();
        // dd($dokumen);
        $pathFile = $dokumen->pathFile_sokongan;

        Storage::Delete($pathFile);

        $per = DB::table('dokumen_sokongan')->where('dokumens_id_sokongan', $id)->delete();

        flash('Dokumen telah dipadamkan.')->success();
        return redirect()->back();
    }

    public function kemaskiniPermohonan($id)
    {
        $id = Hashids::decode($id);

        $permohonan = Permohonan::with('pasanganPermohonan')
            // ->with('user')
            ->where('permohonansID', '=', $id)
            ->first();
        // dd($permohonan);
        $negara = Negara::all();
        $dokumen = Dokumen::where('permohonansID', $id)->get();
        $dokumen_sokongan = DB::table('dokumen_sokongan')->where('permohonansID', $id)->get();
        $jenis = $permohonan->JenisPermohonan;

        // dd($jenis);
        // $a=$permohonan->pasanganPermohonan->pasangansID;
        // echo $a;
        if ($jenis == 'Rasmi') {
            $typeForm = 'rasmi';
            return view('editFormIndividuRasmi', compact('permohonan', 'negara', 'typeForm', 'dokumen', 'dokumen_sokongan'));
        } elseif ($jenis == 'Tidak Rasmi') {
            $typeForm = 'tidakRasmi';
            return view('editFormIndividuRasmi', compact('permohonan', 'negara', 'typeForm', 'dokumen', 'dokumen_sokongan'));
        }
    }

    public function updatePermohonan(Request $request, $id)
    {
        
        // dd($request->all());
        $id = $request->input('id');
        $tarikhinsu = $request->input('tarikh');
        $tarikhMulaPerjalanan1 = $request->input('tarikhMulaPerjalanan');
        $tarikhAkhirPerjalanan1 = $request->input('tarikhAkhirPerjalanan');
        $negara = $request->input('negara');
        $negara_tambahan = implode(', ', $request->input('negara_tambahan'));
        $negara_lebih_dari_satu = $request->input('negara_lebih');
        $tujuan = $request->input('tujuan');
        $alamat = $request->input('alamat');
        $phone = $request->input('phone');
        $jenisKewangan = $request->input('jenisKewangan');
        $namaPasangan = $request->input('namaPasangan');
        $emailPasangan = $request->input('emailPasangan');
        $hubungan = $request->input('hubungan');
        $alamatPasangan = $request->input('alamatPasangan');
        $phonePasangan = $request->input('phonePasangan');
        $jenisPermohonan = $request->input('jenisPermohonan');
        $pasanganID = $request->input('pasanganID');

        $DateNew11 = strtotime($tarikhinsu);
        $DateNew22 = strtotime($tarikhMulaPerjalanan1);
        $DateNew33 = strtotime($tarikhAkhirPerjalanan1);
        $tarikh = date('Y-m-d', $DateNew11);
        $tarikhMulaPerjalanan = date('Y-m-d', $DateNew22);
        $tarikhAkhirPerjalanan = date('Y-m-d', $DateNew33);

        if ($jenisPermohonan == 'Rasmi') {
            Permohonan::where('permohonansID', '=', $id)->update([
                'tarikhInsuran' => $tarikh,
                'tarikhMulaPerjalanan' => $tarikhMulaPerjalanan,
                'tarikhAkhirPerjalanan' => $tarikhAkhirPerjalanan,
                'negara' => $negara,
                'negara_tambahan' => $negara_tambahan,
                'negara_lebih_dari_satu' => $negara_lebih_dari_satu,
                'lainTujuan' => $tujuan,
                'alamat' => $alamat,
                'telefonPemohon' => $phone,
                'jenisKewangan' => $jenisKewangan,
                'catatan_permohonan' => $request->input('catatan_permohonan'),
            ]);

            Pasangan::where('pasangansID', '=', $pasanganID)->update(['namaPasangan' => $namaPasangan, 'hubungan' => $hubungan, 'alamatPasangan' => $alamatPasangan, 'phonePasangan' => $phonePasangan, 'emailPasangan' => $emailPasangan]);

            if ($request->hasFile('filesokongan')) {
                $files = $request->file('filesokongan');

                foreach ($files as $file) {
                    $filename = $file->hashName();
                    $extension = $file->extension();

                    if ($extension == 'pdf' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'docx' || $extension == 'JPG' || $extension == 'DOC' || $extension == 'doc') {
                        // check folder for 'current year', if not exist, create one
                        $currYear = Carbon::now()->format('Y');

                        $storagePath = 'upload/dokumen_sokongan/' . $currYear;

                        $filePath = str_replace(base_path() . '/', '', $storagePath) . '/' . $filename;
                        $upload_success = $file->storeAs($storagePath, $filename);

                        if ($upload_success) {
                            $data = [
                                'namaFile_sokongan' => $filename,
                                'typeFile_sokongan' => $extension,
                                'pathFile_sokongan' => $filePath,
                                'permohonansID' => $id,
                                'created_at' => \Carbon\Carbon::now(), # \Datetime()
                                'updated_at' => \Carbon\Carbon::now(), # \Datetime()
                            ];
                            DB::table('dokumen_sokongan')->insert($data);
                        } else {
                            flash::error('Muat naik tidak berjaya' . $doc_type);
                            Alert::error('Tidak Berjaya', 'Muat naik Dokumen Sokongan Tidak Berjaya ' . $doc_type);
                            return redirect('/senaraiPermohonanProses');
                        }
                    } else {
                        // echo '<div class="alert alert-warning"><strong>Warning!</strong> Sorry Only Upload png , jpg , doc</div>';
                        Alert::error('Tidak Berjaya', 'Muat naik tidak berjaya. Hanya fail berformat pdf,jpg,jpeg,png dan doc sahaja.' . $doc_type);
                        return redirect('/senaraiPermohonanProses');
                    }
                }
            }

            if ($request->hasFile('fileRasmi')) {
                // $allowedfileExtension=['pdf','jpg','png','docx'];
                $files = $request->file('fileRasmi');

                foreach ($files as $file) {
                    $filename = $file->hashName();
                    // $filename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();

                    //dd($extension);
                    if ($extension == 'pdf' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'docx' || $extension == 'JPG') {
                        // check folder for 'current year', if not exist, create one
                        $currYear = Carbon::now()->format('Y');
                        // $storagePath = public_path() . 'upload/dokumen/' . $currYear;
                        $storagePath = 'upload/dokumen/' . $currYear;
                        $filePath = str_replace(base_path() . '/', '', $storagePath) . '/' . $filename;

                        // if (!file_exists($storagePath)) {
                        //     mkdir($storagePath, 0777, true);
                        // }
                        $upload_success = $file->storeAs($storagePath, $filename);

                        if ($upload_success) {
                            $data = [
                                'namaFile' => $filename,
                                'typeFile' => $extension,
                                'pathFile' => $filePath,
                                'permohonansID' => $id,
                                'created_at' => \Carbon\Carbon::now(), # \Datetime()
                                'updated_at' => \Carbon\Carbon::now(), # \Datetime()
                            ];
                            Dokumen::create($data);

                            // Alert::success('Berjaya', 'Permohonan berjaya dikemaskini');
                            toast('Permohonan berjaya dikemaskini', 'success')->position('top-end');
                            // flash('Permohonan berjaya dikemaskini.')->success();
                            return back();
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

            // Alert::success('Berjaya', 'Permohonan berjaya dikemaskini');
            toast('Permohonan berjaya dikemaskini', 'success')->position('top-end');
            // flash('Berjaya dikemaskini.')->success();
            return back();
        } elseif ($jenisPermohonan == 'Tidak Rasmi') {
            $tarikhMulaCuti = $request->input('tarikhMulaCuti');
            $tarikhAkhirCuti = $request->input('tarikhAkhirCuti');
            $tarikhKembaliBertugas = $request->input('tarikhKembaliBertugas');

            $DateNew111 = strtotime($tarikhMulaCuti);
            $DateNew222 = strtotime($tarikhAkhirCuti);
            $DateNew333 = strtotime($tarikhKembaliBertugas);
            $mulacuti = date('Y-m-d', $DateNew111);
            $habiscuti = date('Y-m-d', $DateNew222);
            $mulakijo = date('Y-m-d', $DateNew333);

            Permohonan::where('permohonansID', '=', $id)->update([
                'tarikhInsuran' => $tarikh,
                'tarikhMulaPerjalanan' => $tarikhMulaPerjalanan,
                'tarikhAkhirPerjalanan' => $tarikhAkhirPerjalanan,
                'negara' => $negara,
                'negara_tambahan' => $negara_tambahan,
                'negara_lebih_dari_satu' => $negara_lebih_dari_satu,
                'lainTujuan' => $tujuan,
                'alamat' => $alamat,
                'telefonPemohon' => $phone,
                'jenisKewangan' => $jenisKewangan,
                'tarikhMulaCuti' => $mulacuti,
                'tarikhAkhirCuti' => $habiscuti,
                'tarikhKembaliBertugas' => $mulakijo,
                'catatan_permohonan' => $request->input('catatan_permohonan')
            ]);

            Pasangan::where('pasangansID', '=', $pasanganID)->update(['namaPasangan' => $namaPasangan, 'hubungan' => $hubungan, 'alamatPasangan' => $alamatPasangan, 'phonePasangan' => $phonePasangan, 'emailPasangan' => $emailPasangan]);

            if ($request->hasFile('filesokongan')) {
                $files = $request->file('filesokongan');

                foreach ($files as $file) {
                    $filename = $file->hashName();
                    $extension = $file->extension();

                    if ($extension == 'pdf' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'docx' || $extension == 'JPG' || $extension == 'DOC' || $extension == 'doc') {
                        // check folder for 'current year', if not exist, create one
                        $currYear = Carbon::now()->format('Y');

                        $storagePath = 'upload/dokumen_sokongan/' . $currYear;

                        $filePath = str_replace(base_path() . '/', '', $storagePath) . '/' . $filename;
                        $upload_success = $file->storeAs($storagePath, $filename);

                        if ($upload_success) {
                            $data = [
                                'namaFile_sokongan' => $filename,
                                'typeFile_sokongan' => $extension,
                                'pathFile_sokongan' => $filePath,
                                'permohonansID' => $id,
                                'created_at' => \Carbon\Carbon::now(), # \Datetime()
                                'updated_at' => \Carbon\Carbon::now(), # \Datetime()
                            ];
                            DB::table('dokumen_sokongan')->insert($data);
                        } else {
                            flash::error('Muat naik tidak berjaya' . $doc_type);
                            Alert::error('Tidak Berjaya', 'Muat naik Dokumen Sokongan Tidak Berjaya ' . $doc_type);
                            return redirect('/senaraiPermohonanProses');
                        }
                    } else {
                        // echo '<div class="alert alert-warning"><strong>Warning!</strong> Sorry Only Upload png , jpg , doc</div>';
                        Alert::error('Tidak Berjaya', 'Muat naik tidak berjaya. Hanya fail berformat pdf,jpg,jpeg,png dan doc sahaja.' . $doc_type);
                        return redirect('/senaraiPermohonanProses');
                    }
                }
            }

            if ($request->hasFile('fileCuti')) {
                // $allowedfileExtension=['pdf','jpg','png','docx'];
                $files = $request->file('fileCuti');

                foreach ($files as $file) {
                    $filename = $file->hashName();
                    // $filename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();

                    //dd($extension);
                    if ($extension == 'pdf' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'docx' || $extension == 'JPG') {
                        // check folder for 'current year', if not exist, create one
                        $currYear = Carbon::now()->format('Y');
                        // $storagePath = public_path() . 'upload/dokumen/' . $currYear;
                        $storagePath = 'upload/dokumen/' . $currYear . '/cuti/' . $id . '';
                        $filePath = str_replace(base_path() . '/', '', $storagePath) . '/' . $filename;

                        // if (!file_exists($storagePath)) {
                        //     mkdir($storagePath, 0777, true);
                        // }
                        $upload_success = $file->storeAs($storagePath, $filename);

                        if ($upload_success) {
                            $perm = Permohonan::findOrFail($id);
                            if (is_null($perm->pathFileCuti)) {
                                Permohonan::where('permohonansID', '=', $id)->update([
                                    'namaFileCuti' => $filename,
                                    'jenisFileCuti' => $extension,
                                    'pathFileCuti' => $filePath,
                                    'created_at' => \Carbon\Carbon::now(), # \Datetime()
                                    'updated_at' => \Carbon\Carbon::now(), # \Datetime()
                                ]);
                            } else {
                                // unlink(storage_path($perm->pathFileCuti));
                                Storage::Delete($perm->pathFileCuti);

                                Permohonan::where('permohonansID', '=', $id)->update([
                                    'namaFileCuti' => $filename,
                                    'jenisFileCuti' => $extension,
                                    'pathFileCuti' => $filePath,
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
            // Alert::success('Berjaya', 'Permohonan berjaya dikemaskini');
            toast('Permohonan berjaya dikemaskini', 'success')->position('top-end');
            // flash('Berjaya dikemaskini.')->success();
            return back();
        }
    }

    public function senaraiPermohonanProses()
    {
        $id = Auth::user()->usersID;

        $userDetail = User::find($id);

        $permohonan = Permohonan::where('usersID', $id)
            ->whereNotIn('statusPermohonan', ['Permohonan Berjaya', 'Permohonan Gagal'])
            ->orderBy('created_at', 'desc')
            ->get();

        $rombongan = Rombongan::where('usersID', $id)
            ->whereNotIn('statusPermohonanRom', ['Permohonan Berjaya', 'Permohonan Gagal'])
            ->get();

        $allPermohonan = Permohonan::with('user')->get();

        //dd($ss);
        return view('pengguna.senaraiPermohonan', compact('permohonan', 'rombongan', 'userDetail', 'allPermohonan'));
    }

    public function senaraiPermohonanIndividu()
    {
        $id = Auth::user()->usersID;

        $permohonan = Permohonan::where('permohonans.usersID', $id)
            ->leftjoin('rombongans', 'rombongans.rombongans_id', '=', 'permohonans.rombongans_id')
            ->whereIn('permohonans.statusPermohonan', ['Permohonan Berjaya', 'Permohonan Gagal'])
            ->orderBy('permohonans.created_at', 'desc')
            ->get();

        $rombongan = Rombongan::where('usersID', $id)->get();

        // $allPermohonan = Permohonan::with('user')->get();

        return view('pengguna.senaraiPermohonanIndividu', compact('permohonan', 'rombongan'));
    }

    public function senaraiPermohonanRombongan()
    {
        $id = Auth::user()->usersID;

        // $rombongan = Rombongan::with('user','jabatan')->where('usersID', $id)
        //     ->whereIn('statusPermohonanRom', ['Permohonan Berjaya', 'Permohonan Gagal'])
        //      ->get();

        $rombongan = DB::table('senarai_rekod_permohonan_rombongan_suk')->where('usersID', $id)
            ->whereIn('status_kelulusan', ['Berjaya', 'Gagal'])
            ->get();

        $allPermohonan = Permohonan::with('user')->get();

        $peserta = Permohonan::with('user')
            ->where('rombongans_id', $id)
            ->get();

        // return dd($rombongan->surat);
        return view('pengguna.senaraiPermohonanRombongan', compact('rombongan', 'allPermohonan'));
    }

    public function tolakrombongan($id)
    {
        $ubah = 'Permohonan Gagal';

        Permohonan::where('permohonansID', $id)->update([
            'statusPermohonan' => $ubah,
        ]);

        flash('Permohonan Ditolak.')->success();
        return redirect()->back();
    }

    public function sendEmail()
    {
        $user = User::where('usersID', Auth::user()->usersID)->get();
        dd($user);

        Notification::send($user, new SenaraiSokongan($user));

        Notification::send($user, new SenaraiSokonganRombongan($user));

        Notification::send($user, new SenaraiKelulusan($user));
        Notification::send($user, new SenaraiKelulusanRombongan($user));

        Notification::send($user, new KeputusanPermohonan($user));
        // Notification::send($user, new PermohonanBerjaya($user));
    }
}
