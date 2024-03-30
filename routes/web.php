<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\SppController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\TransaksiController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/pembayaran',[PembayaranController::class,'index']);
Route::get('/profile/{nisn}',[PembayaranController::class,'profile'])->name('profile');
Route::put('/profile', [PembayaranController::class,'update'])->name('profile.update');
Route::get('history/{id}',[PembayaranController::class,'history'])->name('history');
Route::get('data-pembayaran/{id}',[PembayaranController::class,'dataPembayaran'])->name('data-pembayaran');

Route::get('tagihan-siswa/{id}',[KeuanganController::class,'tagihan_siswa'])->name('tagihan-siswa');
Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');
Route::get('/pembayaran',[PembayaranController::class,'index']);
Route::get('/get_pm',[PaymentMethodController::class,'getTagihan']);
Route::get('/get_tagihan',[PembayaranController::class,'getTagihan']);
Route::get('/get_spp',[PembayaranController::class,'getSpp']);
Route::get('get_code',[PembayaranController::class,'getCode']);
Route::get('simpan_pembayaran',[PembayaranController::class,'simpanPembayaran']);
// Route::get('pembayaran',[PembayaranController::class,'index'])->name('pembayaran');
Route::post('/pembayaran/{id}',[PembayaranController::class,'store'])->name('pembayaran');
Route::post('add-token',[PembayaranController::class,'cekToken'])->name('add-token');

Route::group(['middleware'=>['guest']],function (){
    Route::get('login',[LoginController::class,'index'])->name('login');
    Route::post('login',[LoginController::class,'login']);
    Route::get('login-siswa',[RegisterController::class,'index'])->name('login-siswa');
    Route::post('register',[RegisterController::class,'store']);



    Route::get('forgot-password',[ForgotPasswordController::class,'index'])->name('forgot-password');
    Route::post('forgot-password',[ForgotPasswordController::class,'reset']);
});

Route::group(['middleware'=>['auth']],function (){
    Route::get('dashboard',[HomeController::class,'index'])->name('dashboard');
    Route::get('logout',[LogoutController::class,'index'])->name('logout');


    Route::get('payment-method',[PaymentMethodController::class,'index'])->name('payment');
    Route::post('payment-method/store',[PaymentMethodController::class,'store'])->name('add-payment');
    Route::get('payment-method/{product}',[PaymentMethodController::class,'show'])->name('edit-payment');

    Route::get('keuangan',[KeuanganController::class,'index'])->name('keuangan');
    Route::get('kategori/create',[KeuanganController::class,'create'])->name('add-kategori');
    Route::get('kategori',[KeuanganController::class,'kategori_keuangan'])->name('kategori');
    Route::get('kategori/{product}',[KeuanganController::class,'show'])->name('edit-kategori');

    Route::get('tagihan',[KeuanganController::class,'tagihan'])->name('tagihan');

    Route::post('tagihan',[KeuanganController::class,'store_tagihan'])->name('add-tagihan');
    Route::get('tagihan/{id}',[KeuanganController::class,'edit_tagihan'])->name('edit-tagihan');
    Route::post('tagihan/{id}',[KeuanganController::class,'update_tagihan']);
    Route::get('send-notif',[KeuanganController::class,'sendNotif']);
    Route::post('kategori/create',[KeuanganController::class,'store']);
    Route::get('delete-tagihan/{id}',[KeuanganController::class,'destroy']);
    Route::get('kirim-tagihan/{id}',[KeuanganController::class,'kirim']);
    Route::post('kategori/{id}',[KeuanganController::class,'update']);
    Route::delete('kategori',[KeuanganController::class,'destroy']);


    Route::get('transaksi',[TransaksiController::class,'index'])->name('transaksi');
    Route::get('transaksi/create',[TransaksiController::class,'create'])->name('add-transaksi');
    Route::post('transaksi/create',[TransaksiController::class,'store']);
    Route::get('transaksi/{transaksi}',[TransaksiController::class,'show'])->name('edit-transaksi');
    Route::post('transaksi/{transaksi}',[TransaksiController::class,'update']);
    Route::get('riwayat', [TransaksiController::class, 'riwayat'])->name('riwayat');
    Route::get('get_siswa',[TransaksiController::class,'getSiswa']);

    Route::get('/siswa/export_excel', [SekolahController::class,'export_excel']);
    Route::post('/siswa/import_excel', [SekolahController::class,'import_excel'])->name('import-siswa');
    Route::get('siswa',[SekolahController::class,'index'])->name('siswa');
    Route::get('jurusan',[SekolahController::class,'index_jurusan'])->name('jurusan');
    Route::post('add-jurusan',[SekolahController::class,'store'])->name('add-jurusan');
    Route::get('add-siswa',[SekolahController::class,'create'])->name('add-siswa');
    Route::post('add-siswa',[SekolahController::class,'store_sekolah']);
    Route::get('siswa/{siswa}',[SekolahController::class,'show'])->name('edit-siswa');
    Route::get('jurusan/{jurusan}',[SekolahController::class,'show_jurusan'])->name('edit-jurusan');
    Route::post('siswa /{siswa}',[SekolahController::class,'update'])->name('update-siswa');
    Route::get('jurusan',[SekolahController::class,'index_jurusan'])->name('jurusan');
    Route::post('add-jurusan',[SekolahController::class,'store'])->name('add-jurusan');
    Route::put('jurusan/{id}',[SekolahController::class,'update_jurusan']);
    Route::get('delete-jurusan/{id}',[SekolahController::class,'delete_jurusan']);
    Route::get('tentang',[SekolahController::class,'tentang'])->name('tentang');
    Route::get('tentang/{id}',[SekolahController::class,'detail_tentang'])->name('edit-tentang');
    Route::post('tentang/{id}',[SekolahController::class,'update_tentang']);
    Route::get('delete-siswa/{id}',[SekolahController::class,'destroy']);
    Route::get('data-kelas',[SekolahController::class,'index_kelas'])->name('kelas');
    Route::post('add-kelas',[SekolahController::class,'store_kelas'])->name('add-kelas');
    Route::put('data-kelas/{id}',[SekolahController::class,'update_kelas']);
    Route::get('data-kelas/{kelas}',[SekolahController::class,'show_kelas'])->name('edit-kelas');
    Route::get('delete-kelas/{id}',[SekolahController::class,'delete_kelas'])->name('delete_kelas');




    Route::get('/export_excel', [SppController::class,'export_excel'])->name('export-excel-tagihan');
    Route::post('/import_excel', [SppController::class,'import_excel'])->name('import-excel-tagihan');
    Route::get('spp',[SppController::class,'index'])->name('spp');
    Route::post('add-spp',[SppController::class,'store'])->name('add-spp');
    Route::get('spp/{id}',[SppController::class,'show'])->name('edit-spp');
    Route::post('spp/{spp}',[SppController::class,'update']);
    Route::delete('purchases',[SppController::class,'destroy']);

    Route::get( 'users',[UserController::class,'index'])->name('users');
    Route::post('users',[UserController::class,'store']);
    Route::put('users',[UserController::class,'update']);
    Route::delete('users',[UserController::class,'destroy']);

    Route::get('reports',[ReportController::class,'index'])->name('reports');
    Route::post('reports',[ReportController::class,'getData']);

});

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Route::get('/about', function () {
//     return view('about');
// })->name('about');
