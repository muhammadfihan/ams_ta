<?php

use App\Http\Controllers\API\AbsensiController;
use App\Http\Controllers\API\DataGajiController;
use App\Http\Controllers\API\DataPegawaiController;
use App\Http\Controllers\API\GajiController;
use App\Http\Controllers\API\JabatanController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\IzinController;
use App\Http\Controllers\API\GolonganController;
use App\Http\Controllers\API\SuperAdminController;
use App\Http\Controllers\API\JamAbsenController;
use App\Http\Controllers\API\ReqAbsenController;
use App\Http\Controllers\API\CutiController;
use App\Http\Controllers\API\LemburController;
use App\Http\Controllers\API\LaporanController;
use App\Http\Controllers\API\ForgotPasswordController;
use App\Models\ReqAbsen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', [UserController::class, 'login']);
Route::post('loginpegawai', [UserController::class, 'loginpegawai']);
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::post('lupa', [ForgotPasswordController::class, 'postEmail']);
Route::post('submitlupa', [ForgotPasswordController::class, 'submitlupa']);

Route::middleware(['auth:sanctum'])->group(function () {
   
    Route::post('addAkunPegawai', [UserController::class, 'addAkunPegawai'])->middleware('role:Manager,Admin');
    Route::get('allUser', [UserController::class, 'allUser'])->middleware('role:Manager,Admin');
    Route::get('editUser/{id}', [UserController::class, 'editUser'])->middleware('role:Manager,Admin');
    Route::post('updateUser', [UserController::class, 'updateUser'])->middleware('role:Manager,Admin');
    Route::delete('hapusUser/{id}', [UserController::class, 'hapusUser'])->middleware('role:Manager,Admin');
    Route::get('getakun', [UserController::class, 'getakun'])->middleware('role:Admin,Pegawai');

    Route::delete('hapusAdmin/{id}', [UserController::class, 'hapusAdmin'])->middleware('role:Manager,Admin');

    Route::get('tampilsuperadmin', [SuperAdminController::class, 'tampilsuperadmin'])->middleware('role:Manager');

    Route::get('infopt', [UserController::class, 'infopt'])->middleware('role:Admin,Pegawai');
    Route::get('infoptpeg', [UserController::class, 'infoptpeg'])->middleware('role:Admin,Pegawai');
    Route::get('getakunAdmin', [UserController::class, 'getakunAdmin'])->middleware('role:Admin,Pegawai');

    Route::get('jabatan',[JabatanController::class, 'jabatan'])->middleware('role:Manager,Admin,Pegawai');
    Route::get('alljabatan',[JabatanController::class, 'alljabatan'])->middleware('role:Manager,Admin,Pegawai');
    Route::get('jabatanpaginate',[JabatanController::class, 'jabatanpaginate'])->middleware('role:Manager,Admin,Pegawai');
    Route::get('jabatanpegawai',[JabatanController::class, 'jabatanpegawai'])->middleware('role:Manager,Admin,Pegawai');
    Route::post('tambahjabatan', [JabatanController::class, 'tambahjabatan'])->middleware('role:Manager,Admin');
    Route::get('editjabatan/{id}',[JabatanController::class, 'editjabatan'])->middleware('role:Manager,Admin');
    Route::post('updatejabatan',[JabatanController::class, 'updatejabatan'])->middleware('role:Manager,Admin');
    Route::delete('hapusjabatan/{id}', [JabatanController::class, 'hapusjabatan'])->middleware('role:Manager,Admin');

    Route::get('alltunjangan',[GajiController::class, 'alltunjangan'])->middleware('role:Manager,Admin,Pegawai');
    Route::get('allgaji',[DataGajiController::class, 'allgaji'])->middleware('role:Manager,Admin,Pegawai');
    Route::post('buatgaji',[DataGajiController::class, 'buatgaji'])->middleware('role:Manager,Admin,Pegawai');
    Route::get('sudahisi',[DataGajiController::class, 'sudahisi'])->middleware('role:Manager,Admin,Pegawai');
    Route::get('riwayatgaji',[DataGajiController::class, 'riwayatgaji'])->middleware('role:Manager,Admin,Pegawai');
    Route::get('riwayatgajipeg',[DataGajiController::class, 'riwayatgajipeg'])->middleware('role:Manager,Admin,Pegawai');
    Route::get('detailgaji/{id}',[DataGajiController::class, 'detailgaji'])->middleware('role:Manager,Admin,Pegawai');
    Route::get('detriwayatgaji/{id}',[DataGajiController::class, 'detriwayatgaji'])->middleware('role:Manager,Admin,Pegawai');

    Route::post('ambilgaji',[DataGajiController::class, 'ambilgaji'])->middleware('role:Manager,Admin,Pegawai');
    Route::post('updategaji',[DataGajiController::class, 'updategaji'])->middleware('role:Manager,Admin,Pegawai');

    Route::get('gajipegawai',[DataGajiController::class, 'gajipegawai'])->middleware('role:Manager,Admin,Pegawai');
    Route::get('detgajipeg/{id}',[DataGajiController::class, 'detgajipeg'])->middleware('role:Manager,Admin,Pegawai');
    Route::delete('hapusgaji/{id}',[DataGajiController::class, 'hapusgaji'])->middleware('role:Manager,Admin,Pegawai');

    Route::post('tambahtunjangan', [GajiController::class, 'tambahtunjangan'])->middleware('role:Manager,Admin');
    Route::post('updatetunjangan',[GajiController::class, 'updatetunjangan'])->middleware('role:Manager,Admin');
    Route::delete('hapustunjangan/{id}', [GajiController::class, 'hapustunjangan'])->middleware('role:Manager,Admin');
    
    Route::get('allbonus',[GajiController::class, 'allbonus'])->middleware('role:Manager,Admin,Pegawai');
    Route::post('tambahbonus', [GajiController::class, 'tambahbonus'])->middleware('role:Manager,Admin');
    Route::post('updatebonus',[GajiController::class, 'updatebonus'])->middleware('role:Manager,Admin');
    Route::delete('hapusbonus/{id}', [GajiController::class, 'hapusbonus'])->middleware('role:Manager,Admin');

    Route::get('allpotongan',[GajiController::class, 'allpotongan'])->middleware('role:Manager,Admin,Pegawai');
    Route::post('tambahpotongan', [GajiController::class, 'tambahpotongan'])->middleware('role:Manager,Admin');
    Route::post('updatepotongan',[GajiController::class, 'updatepotongan'])->middleware('role:Manager,Admin');
    Route::delete('hapuspotongan/{id}', [GajiController::class, 'hapuspotongan'])->middleware('role:Manager,Admin');

    Route::get('golonganpegawai',[GolonganController::class, 'golonganpegawai'])->middleware('role:Manager,Admin,Pegawai'); 
    Route::get('allgolongan',[GolonganController::class, 'allgolongan'])->middleware('role:Manager,Admin,Pegawai');
    Route::post('tambahgolongan', [GolonganController::class, 'tambahgolongan'])->middleware('role:Manager,Admin');
    Route::post('updategolongan',[GolonganController::class, 'updategolongan'])->middleware('role:Manager,Admin');
    Route::delete('hapusgolongan/{id}', [GolonganController::class, 'hapusgolongan'])->middleware('role:Manager,Admin');

    Route::post('isibiodata', [DataPegawaiController::class, 'isibiodata'])->middleware('role:Pegawai');
    Route::get('getprofile', [DataPegawaiController::class, 'getprofile'])->middleware('role:Pegawai');
    Route::post('updatedata', [DataPegawaiController::class, 'updatedata'])->middleware('role:Pegawai');

    Route::get('datapegawai', [DataPegawaiController::class, 'datapegawai'])->middleware('role:Manager,Admin,Pegawai');
    Route::get('datpeg', [DataPegawaiController::class, 'datpeg'])->middleware('role:Manager,Admin,Pegawai');
    Route::get('detailpegawai/{id}', [DataPegawaiController::class, 'detailpegawai'])->middleware('role:Manager,Admin');
    Route::get('editpegawai/{id}', [DataPegawaiController::class, 'editpegawai'])->middleware('role:Admin, Pegawai');
    Route::post('updatepegawai', [DataPegawaiController::class, 'updatepegawai'])->middleware('role:Admin,Pegawai');
    Route::delete('hapuspegawai/{id}' , [DataPegawaiController::class, 'hapuspegawai'])->middleware('role:Admin, Pegawai');
    Route::post('absenmasuk', [AbsensiController::class, 'absenmasuk'])->middleware('role:Pegawai');
    Route::post('absenpulang/{uid}', [AbsensiController::class, 'absenpulang'])->middleware('role:Pegawai');

    Route::get('tampilabsen', [AbsensiController::class, 'tampilabsen'])->middleware('role:Admin');
    Route::get('tampilpegawai', [AbsensiController::class, 'tampilpegawai'])->middleware('role:Pegawai');
    Route::get('detailabsen/{uid}', [AbsensiController::class, 'detailabsen'])->middleware('role:Manager,Admin');

    Route::post('aturjamabsen', [JamAbsenController::class, 'aturjamabsen'])->middleware('role:Admin');
    Route::post('updateabsen', [JamAbsenController::class, 'updateabsen'])->middleware('role:Admin');
    Route::get('tampil', [JamAbsenController::class, 'tampil'])->middleware('role:Admin,Pegawai');
    Route::get('tampiljampeg', [JamAbsenController::class, 'tampiljampeg'])->middleware('role:Admin,Pegawai');

    Route::get('absendashboard', [AbsensiController::class, 'absendashboard'])->middleware('role:Admin');
    Route::get('counthadir', [AbsensiController::class, 'counthadir'])->middleware('role:Admin');
    Route::get('counttidakhadir', [AbsensiController::class, 'counttidakhadir'])->middleware('role:Admin');

    Route::get('allizin', [IzinController::class, 'allizin'])->middleware('role:Admin');
    Route::get('allizinpegawai', [IzinController::class, 'allizinpegawai'])->middleware('role:Admin,Pegawai');
    Route::post('ajukanizin', [IzinController::class, 'ajukanizin'])->middleware('role:Admin,Pegawai');
    Route::post('approveizin', [IzinController::class, 'approveizin'])->middleware('role:Admin,Pegawai');
    Route::post('updateizin', [IzinController::class, 'updateizin'])->middleware('role:Admin,Pegawai');
    Route::delete('hapusizin/{id}', [IzinController::class, 'hapusizin'])->middleware('role:Admin,Pegawai');

    Route::get('allreq', [ReqAbsenController::class, 'allreq'])->middleware('role:Admin');
    Route::get('allreqpegawai', [ReqAbsenController::class, 'allreqpegawai'])->middleware('role:Admin,Pegawai');
    Route::post('ajukanreqabsen', [ReqAbsenController::class, 'ajukanreqabsen'])->middleware('role:Admin,Pegawai');
    Route::post('approvereqabsen', [ReqAbsenController::class, 'approvereqabsen'])->middleware('role:Admin,Pegawai');
    Route::post('updatereqabsen', [ReqAbsenController::class, 'updatereqabsen'])->middleware('role:Admin,Pegawai');
    Route::delete('hapusreqabsen/{uid}', [ReqAbsenController::class, 'hapusreqabsen'])->middleware('role:Admin,Pegawai');

    Route::get('tampilcuti',[CutiController::class, 'tampilcuti'])->middleware('role:Admin');
    Route::get('tampilcutip',[CutiController::class, 'tampilcutip'])->middleware('role:Admin,Pegawai');
    Route::post('tambahcuti',[CutiController::class, 'tambahcuti'])->middleware('role:Admin,Pegawai');
    Route::post('updatecuti',[CutiController::class, 'updatecuti'])->middleware('role:Admin,Pegawai');
    Route::post('confirmcuti',[CutiController::class, 'confirmcuti'])->middleware('role:Admin,Pegawai');
    Route::delete('hapuscuti/{id}',[CutiController::class, 'hapuscuti'])->middleware('role:Admin,Pegawai');
    Route::get('detailcuti/{id}',[CutiController::class, 'detailcuti'])->middleware('role:Admin,Pegawai');

    //Search
    Route::get('searchdata/{data}',[DataPegawaiController::class, 'searchdata'])->middleware('role:Manager,Admin,Pegawai');
    Route::get('searchuser/{data}',[UserController::class, 'searchuser'])->middleware('role:Manager,Admin,Pegawai');
    Route::get('searchabsen/{data}',[AbsensiController::class, 'searchabsen'])->middleware('role:Manager,Admin,Pegawai');
    Route::get('searchabsenpeg/{data}',[AbsensiController::class, 'searchabsenpeg'])->middleware('role:Manager,Admin,Pegawai');
    Route::get('searchcuti/{data}',[CutiController::class, 'searchcuti'])->middleware('role:Manager,Admin,Pegawai');
    Route::get('searchcutipeg/{data}',[CutiController::class, 'searchcutipeg'])->middleware('role:Manager,Admin,Pegawai');
    Route::get('searchjabatan/{data}',[JabatanController::class, 'searchjabatan'])->middleware('role:Manager,Admin,Pegawai');
    Route::get('searchriwayat/{data}',[DataGajiController::class, 'searchriwayat'])->middleware('role:Manager,Admin,Pegawai');
    Route::get('searchgaji/{data}',[DataGajiController::class, 'searchgaji'])->middleware('role:Manager,Admin,Pegawai');
    Route::get('searchlembur/{data}',[LemburController::class, 'searchlembur'])->middleware('role:Manager,Admin,Pegawai');
    Route::get('searchlemburpeg/{data}',[LemburController::class, 'searchlemburpeg'])->middleware('role:Manager,Admin,Pegawai');
    Route::get('searchizin/{data}',[IzinController::class, 'searchizin'])->middleware('role:Manager,Admin,Pegawai');
    Route::get('searchizinpeg/{data}',[IzinController::class, 'searchizinpeg'])->middleware('role:Manager,Admin,Pegawai');
    Route::get('searchreqabsen/{data}',[ReqAbsenController::class, 'searchreqabsen'])->middleware('role:Manager,Admin,Pegawai');
    Route::get('searchreqabsenpeg/{data}',[ReqAbsenController::class, 'searchreqabsenpeg'])->middleware('role:Manager,Admin,Pegawai');   
    Route::get('searchlaporan/{data}',[LaporanController::class, 'searchlaporan'])->middleware('role:Manager,Admin,Pegawai');   
    Route::get('searchlaporanpeg/{data}',[LaporanController::class, 'searchlaporanpeg'])->middleware('role:Manager,Admin,Pegawai');  
    Route::get('searchtunjangan/{data}',[GajiController::class, 'searchtunjangan'])->middleware('role:Manager,Admin,Pegawai'); 
    Route::get('searchbonus/{data}',[GajiController::class, 'searchbonus'])->middleware('role:Manager,Admin,Pegawai'); 
    Route::get('searchpotongan/{data}',[GajiController::class, 'searchpotongan'])->middleware('role:Manager,Admin,Pegawai'); 
    Route::get('searchgolongan/{data}',[GolonganController::class, 'searchgolongan'])->middleware('role:Manager,Admin,Pegawai'); 
    
    Route::get('tampillembur', [LemburController::class, 'tampillembur'])->middleware('role:Admin');
    Route::get('tampillemburpegawai', [LemburController::class, 'tampillemburpegawai'])->middleware('role:Admin,Pegawai');
    Route::post('tambahlembur', [LemburController::class, 'tambahlembur'])->middleware('role:Admin,Pegawai');
    Route::post('updatelembur', [LemburController::class, 'updatelembur'])->middleware('role:Admin,Pegawai');
    Route::post('confirmlembur',[LemburController::class, 'confirmlembur'])->middleware('role:Admin,Pegawai');
    Route::get('detaillembur/{id}', [LemburController::class, 'detaillembur'])->middleware('role:Admin,Pegawai');
    Route::delete('hapuslembur/{id}', [LemburController::class, 'hapuslembur'])->middleware('role:Admin,Pegawai');

    Route::get('tampillaporan', [LaporanController::class, 'tampillaporan'])->middleware('role:Admin,Pegawai');
    Route::get('tampillaporanpegawai', [LaporanController::class, 'tampillaporanpegawai'])->middleware('role:Admin,Pegawai');
    Route::post('tambahlaporan',[LaporanController::class, 'tambahlaporan'])->middleware('role:Admin,Pegawai');
    Route::post('updatelaporan',[LaporanController::class, 'updatelaporan'])->middleware('role:Admin,Pegawai');
    Route::post('confirmlaporan',[LaporanController::class, 'confirmlaporan'])->middleware('role:Admin,Pegawai');
    Route::get('editlaporan/{id}',[LaporanController::class, 'editlaporan'])->middleware('role:Admin,Pegawai');
    Route::get('detaillaporan/{id}',[LaporanController::class, 'detaillaporan'])->middleware('role:Admin,Pegawai');
    Route::delete('hapuslaporan/{id}',[LaporanController::class, 'hapuslaporan'])->middleware('role:Admin,Pegawai');

});
