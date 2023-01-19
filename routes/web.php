<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', function () {
    return view('welcome');
});


// Password reset link request routes...
Route::get('password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.email');
Route::post('password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail']);

// Password reset routes...
// Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.request');
Route::post('password/update', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/panduan-pengguna', [App\Http\Controllers\PdfController::class, 'manualpengguna'])->name('panduan-pengguna');
Route::get('/panduan-penggunaKetua', [App\Http\Controllers\PdfController::class, 'manualpenggunaKetua'])->name('panduan-penggunaKetua');
Route::get('/perananKetuaJabatan', [App\Http\Controllers\PdfController::class, 'perananKetuaJabatan'])->name('perananKetuaJabatan');

// Route::get('/',[HomeController::class, 'index'])->name('home');
Route::get('registerBaru', [App\Http\Controllers\permohonanController::class, 'registerBaru'])->name('registerBaru');
Route::get('registerForm/{id}', [App\Http\Controllers\permohonanController::class, 'show'])->name('registerForm');

Route::get('/logout', function () {
    Auth::logout();
    return Redirect::to('login');
});

Route::middleware(['auth'])->group(function () {
	Route::get('send', [App\Http\Controllers\permohonanController::class, 'sendEmail']);
	Route::get('/', [App\Http\Controllers\permohonanController::class, 'index2'])->name('halamanUtama');
	Route::get('kemaskini-permohonan-individu/{id}', [App\Http\Controllers\permohonanController::class, 'kemaskiniPermohonan']);
	// Route::POST('/proLogin','LoginController@proLogin');
	// Route::get('/home',[HomeController::class, 'index']);//untuk login../home
	Route::get('profil', [App\Http\Controllers\AdminController::class, 'profil'])->name('profil');
	Route::POST('kemaskini-profil', [App\Http\Controllers\AdminController::class, 'kemaskiniprofil'])->name('kemaskiniprofil');
	Route::POST('kemaskini-katalaluan', [App\Http\Controllers\AdminController::class, 'kemaskinikatalaluan'])->name('kemaskinikatalaluan');
	Route::POST('tukar-password', [App\Http\Controllers\permohonanController::class, 'tukarkatalaluan'])->name('kemaskinikatalaluan');
	//untuk individu
	Route::get('registerFormIndividu/{typeForm}', [App\Http\Controllers\permohonanController::class, 'individu'])->name('registerFormIndividu');
	Route::get('sertai-rombongan', [App\Http\Controllers\permohonanController::class, 'sertaiRombongan'])->name('sertai-rombongan');
	
	//untuk rombongan
	Route::get('permohonan-rombongan', [App\Http\Controllers\permohonanController::class, 'rombongan'])->name('permohonan-rombongan');
	//Route::get('senaraiPermohonan/{id}',[App\Http\Controllers\permohonanController::class, 'senarai')->name('senaraiPermohonan');
	Route::POST('daftarPermohonan/{id}', [App\Http\Controllers\permohonanController::class, 'store']);
	
	Route::POST('sertai-rombongan/{id}', [App\Http\Controllers\permohonanController::class, 'storeIndividuRombongan']);
	Route::POST('daftar-rombongan/{id}', [App\Http\Controllers\permohonanController::class, 'storeRombongan']);
	Route::POST('updatePermohonan/{id}', [App\Http\Controllers\permohonanController::class, 'updatePermohonan']);
	
	
	Route::get('keputusan-rombongan', [App\Http\Controllers\permohonanController::class, 'senaraiPermohonanRombongan'])->name('keputusan-rombongan');
	Route::get('keputusan-permohonan', [App\Http\Controllers\permohonanController::class, 'senaraiPermohonanIndividu'])->name('keputusan-permohonan');
	Route::get('senaraiPermohonanProses', [App\Http\Controllers\permohonanController::class, 'senaraiPermohonanProses'])->name('senaraiPermohonanProses');
	
	// Route::get('/senaraiPermohonan/{id}',[
	// 	// 'middleware' =>'admin',
	// 	'uses'=>[permohonanController::class, 'senarai']);
	
	Route::get('hantar-permohonan-individu/{id}', [App\Http\Controllers\permohonanController::class, 'hantarIndividu']);
	
	Route::get('/hantarRombongan/{id}', [App\Http\Controllers\permohonanController::class, 'hantarRombongan']);
	
	Route::get('/padam/{id}', [App\Http\Controllers\permohonanController::class, 'hapus']);
	
	// Route::get('/tolak-permohonan/{id}', [App\Http\Controllers\permohonanController::class, 'tolakrombongan']);

	Route::post('/batal-permohonan', [App\Http\Controllers\permohonanController::class, 'batalpermohonan']);
	
	Route::get('/senaraiPermohonan/{id}/edit', [App\Http\Controllers\permohonanController::class, 'editIndividu'])->name('editPermohonan.edit');
	
	Route::get('/padam-rombongan/{id}', [App\Http\Controllers\permohonanController::class, 'padamrombongan']);
	
	Route::get('/padam-permohonan/{id}', [App\Http\Controllers\permohonanController::class, 'tamatIndividu']);
	
	// Route::get('/tolak-permohonan/{id}', [App\Http\Controllers\permohonanController::class, 'tolakIndividu']);

	Route::get('padam-dokumen-cuti/{id}',[App\Http\Controllers\permohonanController::class, 'deleteFileCuti'])->name('detailPermohonan.deleteFileCuti');
	Route::get('padam-dokumen-rasmi/{id}', [App\Http\Controllers\permohonanController::class, 'deleteFileRasmi'])->name('detailPermohonan.deleteFileRasmi');
	Route::get('padam-dokumen-sokongan/{id}', [App\Http\Controllers\permohonanController::class, 'deleteFileSokongan'])->name('detailPermohonan.deleteFileSokongan');

	// ------------------------admin----------------------
	Route::get('senaraiPending', [App\Http\Controllers\AdminController::class, 'index'])->name('senaraiPending');
	Route::get('senaraiRekodIndividu', [App\Http\Controllers\AdminController::class, 'senaraiRekodIndividu'])->name('senaraiRekodIndividu');
	Route::get('senaraiPendingRombongan', [App\Http\Controllers\AdminController::class, 'indexRombongan'])->name('senaraiPendingRombongan');
	Route::get('senaraiRekodRombongan', [App\Http\Controllers\AdminController::class, 'senaraiRekodRombongan'])->name('senaraiRekodRombongan');
	Route::post('/sebab', [App\Http\Controllers\AdminController::class, 'sebab']);
	
	Route::post('/sebabRombongan', [App\Http\Controllers\AdminController::class, 'sebabRombongan']);
	
	Route::get('/senaraiPending/{id}/hantar', [App\Http\Controllers\AdminController::class, 'hantar'])->name('senaraiPending.hantar');
	
	Route::get('/sokong-Permohonan-rombongan/{id}', [App\Http\Controllers\AdminController::class, 'hantarRombo'])->name('sokong-permohonan-rombongan');
	
	Route::get('detailPermohonan/{id}/download', [App\Http\Controllers\AdminController::class, 'download'])->name('detailPermohonan.download');
	Route::get('detailPermohonanDokumen/{id}/download', [App\Http\Controllers\AdminController::class, 'downloadDokumen'])->name('detailPermohonanDokumen.download');
	Route::get('detailPermohonanDokumensokongan/{id}/download', [App\Http\Controllers\AdminController::class, 'downloadDokumensokongan'])->name('detailPermohonanDokumensokongan.download');
	
	Route::get('detailPermohonan/{id}', [App\Http\Controllers\AdminController::class, 'show']);
	Route::get('detailPermohonanRombongan/{id}', [App\Http\Controllers\AdminController::class, 'showRombongan']);
	Route::get('pesertaRombongan/{id}', [App\Http\Controllers\AdminController::class, 'pesertaRombongan']);
	
	Route::get('/images/{name}', [App\Http\Controllers\AdminController::class, 'gambar']);
	
	Route::get('kemaskini-rombongan/{id}', [App\Http\Controllers\AdminController::class, 'editPaparanRombongan']);
	Route::post('kemaskini-rombongan', [App\Http\Controllers\AdminController::class, 'kemaskinirombongan']);
	
	Route::get('daftarPic', [App\Http\Controllers\AdminController::class, 'daftarPic'])->name('daftarPic');
	
	Route::POST('daftarJabatan', [App\Http\Controllers\AdminController::class, 'daftarJabatan'])->name('daftarJabatan');
	Route::POST('kemaskiniDataPengguna', [App\Http\Controllers\AdminController::class, 'kemaskiniDataPengguna'])->name('kemaskiniDataPengguna');
	Route::get('senaraiPic', [App\Http\Controllers\AdminController::class, 'senaraiPic'])->name('senaraiPic');
	Route::get('senaraiPengguna', [App\Http\Controllers\AdminController::class, 'senaraiPengguna'])->name('senaraiPengguna');
	Route::get('senaraiPIC/{id}/edit', [App\Http\Controllers\AdminController::class, 'editPIC']);
	Route::get('kemaskini-pengguna/{id}', [App\Http\Controllers\AdminController::class, 'kemaskiniPengguna'])->name('kemaskini-pengguna');
	Route::get('kemaskini-pentadbir/{id}', [App\Http\Controllers\AdminController::class, 'kemaskiniPengguna'])->name('kemaskini-pentadbir');
	Route::get('reset-kata-laluan/{id}', [App\Http\Controllers\AdminController::class, 'resetKatalaluan']);
	
	
	Route::PUT('senaraiPIC/{id}', [App\Http\Controllers\AdminController::class, 'updateDataPIC']);
	
	//Konfigurasi------------------------------------------------------------------------------
	Route::get('senaraiJabatan', [App\Http\Controllers\AdminController::class, 'senaraiJabatan'])->name('senaraiJabatan');
	Route::POST('prosesTambahJab', [App\Http\Controllers\AdminController::class, 'prosesTambahJab'])->name('prosesTambahJab');
	Route::POST('kemaskini-jabatan', [App\Http\Controllers\AdminController::class, 'kemaskinijabatan'])->name('kemaskini-jabatan');
	Route::get('padam-jabatan', [App\Http\Controllers\AdminController::class, 'padamjabatan'])->name('padam-jabatan');
	
	Route::get('senaraiJawatan', [App\Http\Controllers\AdminController::class, 'senaraiJawatan'])->name('senaraiJawatan');
	Route::get('tambahJawatan', [App\Http\Controllers\AdminController::class, 'tambahJawatan'])->name('tambahJawatan');
	Route::POST('prosesTambahJaw', [App\Http\Controllers\AdminController::class, 'prosesTambahJaw'])->name('prosesTambahJaw');
	Route::POST('kemaskini-jawatan', [App\Http\Controllers\AdminController::class, 'kemaskinijawatan'])->name('kemaskini-jawatan');
	Route::get('padam-jawatan', [App\Http\Controllers\AdminController::class, 'padamjawatan'])->name('padam-jawatan');
	
	
	Route::get('senaraiGredAngka', [App\Http\Controllers\AdminController::class, 'senaraiGredAngka'])->name('senaraiGredAngka');
	Route::get('tambahGredAngka', [App\Http\Controllers\AdminController::class, 'tambahGredAngka'])->name('tambahGredAngka');
	Route::POST('prosesTambahGredAngka', [App\Http\Controllers\AdminController::class, 'prosesTambahGredAngka'])->name('prosesTambahGredAngka');
	Route::POST('kemaskini-angkagred', [App\Http\Controllers\AdminController::class, 'kemaskiniangkagred'])->name('kemaskini-angkagred');
	Route::get('padam-angkagred', [App\Http\Controllers\AdminController::class, 'padamangkagred'])->name('padam-angkagred');
	
	Route::get('senaraiGredKod', [App\Http\Controllers\AdminController::class, 'senaraiGredKod'])->name('senaraiGredKod');
	Route::get('tambahGredKod', [App\Http\Controllers\AdminController::class, 'tambahGredKod'])->name('tambahGredKod');
	Route::POST('prosesTambahGredKod', [App\Http\Controllers\AdminController::class, 'prosesTambahGredKod'])->name('prosesTambahGredKod');
	Route::POST('kemaskini-kodgred', [App\Http\Controllers\AdminController::class, 'kemaskinigredkod'])->name('kemaskini-kodgred');
	Route::get('padam-kodgred', [App\Http\Controllers\AdminController::class, 'padamgredkod'])->name('padam-kodgred');
	
	Route::get('terusDato', [App\Http\Controllers\AdminController::class, 'terusDato'])->name('terusDato');
	Route::get('sokongantsuk', [App\Http\Controllers\AdminController::class, 'sokongantsuk'])->name('sokongantsuk');
	Route::get('tambahterusDato', [App\Http\Controllers\AdminController::class, 'tambahterusDato'])->name('tambahterusDato');
	Route::post('tambahsokongantsukpem', [App\Http\Controllers\AdminController::class, 'tambahsokongantsukpem'])->name('tambahsokongantsukpem');
	Route::post('tambahsokongantsukpen', [App\Http\Controllers\AdminController::class, 'tambahsokongantsukpen'])->name('tambahsokongantsukpen');
	Route::POST('prosesTambahterusDato', [App\Http\Controllers\AdminController::class, 'prosesTambahterusDato'])->name('prosesTambahterusDato');
	Route::get('padamTerusDato/{id}', [App\Http\Controllers\AdminController::class, 'padamTerusDato'])->name('padamTerusDato');
	Route::get('padamtsukpen/{id}', [App\Http\Controllers\AdminController::class, 'padamtsukpen'])->name('padamtsukpen');
	Route::get('padamtsukpem/{id}', [App\Http\Controllers\AdminController::class, 'padamtsukpem'])->name('padamtsukpem');
	Route::get('infoSurat', [App\Http\Controllers\AdminController::class, 'infoSurat'])->name('infoSurat');
	
	Route::POST('prosesTambahCoganKata', [App\Http\Controllers\AdminController::class, 'prosesTambahCoganKata'])->name('prosesTambahCoganKata');
	Route::POST('prosesTambahNamaPenolongPengarah', [App\Http\Controllers\AdminController::class, 'prosesTambahNamaPenolongPengarah'])->name('prosesTambahNamaPenolongPengarah');
	
	//laporan
	Route::get('laporanDato', [App\Http\Controllers\AdminController::class, 'laporanDato'])->name('laporanDato');
	Route::get('laporan-jantina', [App\Http\Controllers\AdminController::class, 'laporanjantina'])->name('laporan-jantina');
	Route::get('laporan-jabatan', [App\Http\Controllers\AdminController::class, 'laporanjabatan'])->name('laporan-jabatan');
	Route::get('laporan-negara', [App\Http\Controllers\AdminController::class, 'laporannegara'])->name('laporan-negara');
	Route::get('laporan-bulanan', [App\Http\Controllers\AdminController::class, 'laporanbulanan'])->name('laporan-bulanan');
	Route::get('laporan-butiran-bulanan/{tahun}/{bulan}', [App\Http\Controllers\AdminController::class, 'laporanbutiranbulanan'])->name('laporan-butiran-bulanan');
	Route::get('laporan-butiran-bulanan', [App\Http\Controllers\AdminController::class, 'laporanbutiranbulanan2'])->name('laporan-butiran-bulanan2');
	Route::get('laporan-tahunan', [App\Http\Controllers\AdminController::class, 'laporantahunan'])->name('laporan-tahunan');
	Route::get('laporan-individu', [App\Http\Controllers\AdminController::class, 'laporanindividu'])->name('laporan-individu');
	Route::get('butiran-individu/{id}', [App\Http\Controllers\AdminController::class, 'butiranindividu'])->name('butiran-individu');
	
	Route::get('laporanLP/{tahun}', [App\Http\Controllers\PdfController::class, 'laporanLP'])->name('laporanLP');
	Route::get('cetak-butiran-individu/{id}', [App\Http\Controllers\PdfController::class, 'laporanindi'])->name('cetak-butiran-individu');
	Route::get('laporanJabatan/{tahun}', [App\Http\Controllers\PdfController::class, 'laporanJabatan'])->name('laporanJabatan');
	Route::get('laporanIndividu', [App\Http\Controllers\PdfController::class, 'laporanIndividu'])->name('laporanIndividu');
	Route::get('laporanTahunan', [App\Http\Controllers\PdfController::class, 'laporanTahunan'])->name('laporanTahunan');
	Route::get('laporanNegara/{tahun}', [App\Http\Controllers\PdfController::class, 'laporanNegara'])->name('laporanNegara');
	Route::get('laporanViewIndividu', [App\Http\Controllers\PdfController::class, 'laporanViewIndividu'])->name('laporanViewIndividu');
	Route::get('laporanBulanan/{tahun}', [App\Http\Controllers\PdfController::class, 'laporanBulanan'])->name('laporanBulanan');
	Route::get('laporanViewBG', [App\Http\Controllers\PdfController::class, 'laporanViewBG'])->name('laporanViewBG');
	Route::POST('proViewBG', [App\Http\Controllers\PdfController::class, 'proViewBG'])->name('proViewBG');
	
	Route::get('laporanViewTahun', [App\Http\Controllers\PdfController::class, 'laporanViewTahun'])->name('laporanViewTahun');
	Route::POST('proViewTahun', [App\Http\Controllers\PdfController::class, 'proViewTahun'])->name('proViewTahun');
	
	//surat kelulusan
	Route::get('suratRasmi/{id}', [App\Http\Controllers\PdfController::class, 'suratLulusRasmi'])->name('suratRasmi');
	Route::get('suratTidakRasmi/{id}', [App\Http\Controllers\PdfController::class, 'suratLulusTidakRasmi'])->name('suratTidakRasmi');
	//memo
	Route::get('memoRasmi/{id}', [App\Http\Controllers\PdfController::class, 'memoLulusRasmi'])->name('memoRasmi');
	Route::get('memoTidakRasmi/{id}', [App\Http\Controllers\PdfController::class, 'memoTidakRasmi'])->name('memoTidakRasmi');
	
	Route::get('surat-rombongan/{id}', [App\Http\Controllers\PdfController::class, 'suratrombongan'])->name('surat-rombongan');
	Route::get('memo-rombongan/{id}', [App\Http\Controllers\PdfController::class, 'memorombongan'])->name('memo-rombongan');
	// ------------------------dato----------------------
	
	Route::get('senarai-semak', [App\Http\Controllers\KetuaController::class, 'index'])->name('senarai-semak');
	Route::get('senaraiRombonganKetua', [App\Http\Controllers\KetuaController::class, 'senaraiRombonganKetua'])->name('senaraiRombonganKetua');
	
	Route::get('/luluskan-permohonan/{id}', [App\Http\Controllers\KetuaController::class, 'hantar'])->name('senaraiPermohonan.hantar');
	
	Route::get('/tolak-permohonan/{id}', [App\Http\Controllers\KetuaController::class, 'tolakPermohonan'])->name('senaraiPermohonan.tolakPermohonan');
	
	Route::get('senaraiPermohonanDiluluskan', [App\Http\Controllers\KetuaController::class, 'senaraiLulus'])->name('senaraiPermohonanDiluluskan');
	
	Route::get('kelulusan/proses', [App\Http\Controllers\KetuaController::class, 'editPermohonan']);
	
	Route::get('luluskan-rombongan/{id}', [App\Http\Controllers\KetuaController::class, 'lulusrombongan']);
	Route::get('tolak-rombongan/{id}', [App\Http\Controllers\KetuaController::class, 'ketuaRejectRombongan']);
	Route::get('cetak-butiran-rombongan/{id}', [App\Http\Controllers\KetuaController::class, 'cetakRombongan'])->name('cetak-butiran-rombongan');
	Route::get('cetak-butiran-permohonan/{id}', [App\Http\Controllers\KetuaController::class, 'cetakPermohonan'])->name('cetak-butiran-permohonan');
	
	Route::get('cetak-senarai-permohonan', [App\Http\Controllers\KetuaController::class, 'cetakSenaraiPermohonan'])->name('cetak-senarai-permohonan');
	Route::get('cetak-senarai-rombongan', [App\Http\Controllers\KetuaController::class, 'cetakSenarairombongan'])->name('cetak-senarai-rombongan');
	
	
	Route::get('tukarstatuskelulusan', [App\Http\Controllers\KetuaController::class, 'tukarstatuskelulusan']);
	Route::get('ubahstatusrombongan', [App\Http\Controllers\KetuaController::class, 'ubahstatusrombongan']);
	Route::get('tukarstatussekongan', [App\Http\Controllers\KetuaController::class, 'tukarstatussekongan']);

	Route::get('ketua-tolak-permohonan/{id}', [App\Http\Controllers\KetuaController::class, 'permohonanGagalKetua']);
	
	Route::get('jumlahKeluarnegara', [App\Http\Controllers\KetuaController::class, 'jumlahKeluarnegara'])->name('jumlahKeluarnegara');
	
	// ----------------------------Admin Jabatan-------------------------------------------------------------
	
	Route::get('senaraiPermohonanJabatan', [App\Http\Controllers\AdminController::class, 'senaraiPermohonanJabatan'])->name('senaraiPermohonanJabatan');
	Route::get('rekod-permohonan', [App\Http\Controllers\AdminController::class, 'senaraiPermohonanLepas'])->name('senaraiPermohonanLepas');
	Route::get('daftarPenggunaJabatan', [App\Http\Controllers\AdminController::class, 'daftarPenggunaJabatan'])->name('daftarPenggunaJabatan');
	Route::get('senaraiPenggunaJabatan', [App\Http\Controllers\AdminController::class, 'senaraiPenggunaJabatan'])->name('senaraiPenggunaJabatan');
	Route::get('pengesahan-permohonan', [App\Http\Controllers\AdminController::class, 'hantarJabatan']);
	Route::get('pengesahan-permohonan-tolak', [App\Http\Controllers\AdminController::class, 'pengesahanTolak']);
	Route::PUT('tukar-ketua-rombongan', [App\Http\Controllers\AdminController::class, 'tukarketuarombongan']);
});



