<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Penggajian;
use App\Models\Gaji;
use App\Models\RiwayatGaji;

class DataGajiController extends Controller
{
    public function sudahisi(Request $request){
        $sudah = Gaji::where('id_admin' ,Auth::user()->id)->get();
            return response([
                'data' => $sudah,
                'message' => 'get data berhasil',
                'status' => true,
            ]);
       
    }
    public function riwayatgaji(Request $request){
        $riwayat = RiwayatGaji::where('id_admin' ,Auth::user()->id)->latest()->get();
            return response([
                'data' => $riwayat,
                'message' => 'get data berhasil',
                'status' => true,
            ]);
       
    }
    public function searchriwayat($key)
    {
            $result = DB::table('riwayatgaji')
                ->select('*')
                ->where('riwayatgaji.id_admin', Auth::user()->id)
                ->where('email', 'like', '%' . $key . '%')
                ->orWhere('tanggal_ambil', 'like', '%' . $key . '%')
                ->where('riwayatgaji.id_admin', Auth::user()->id)
                ->get();

            return $result;

    }
    public function riwayatgajipeg(Request $request){
        $riwayat = RiwayatGaji::where('email' ,Auth::user()->email)->latest()->get();
            return response([
                'data' => $riwayat,
                'message' => 'get data berhasil',
                'status' => true,
            ]);
       
    }
    public function searchgaji($key)
    {
            $result = DB::table('penggajian')
                ->select('*')
                ->where('penggajian.id_admin', Auth::user()->id)
                ->where('email', 'like', '%' . $key . '%')
                ->orWhere('tanggal', 'like', '%' . $key . '%')
                ->orWhere('status', 'like', '%' . $key . '%')
                ->where('penggajian.id_admin', Auth::user()->id)
                ->get()->toArray();

                foreach($result as $i => $tes){
                    $tun[$i] = explode(',', $tes->id_tunjangan);
                    foreach($tun[$i] as $index => $row){ 
                        $data[$i][$index] = DB::table('tunjangan')->where('id', $row)->first();
                        $nominalALL[$i][$index] = $data[$i][$index]->nominal;
                        $jenis[$i][$index] = $data[$i][$index]->jenis_tunjangan;
                        $val[$i] = $jenis[$i];
                        $nom[$i] = $nominalALL[$i];
                        $totaltun[$i] = array_sum($nominalALL[$i]);
                    }
                }
                foreach($result as $j => $tes2){
                    $bon[$j] = explode(',', $tes2->id_bonus);
                    foreach($bon[$j] as $nus => $coba){ 
                        $databon[$j][$nus] = DB::table('bonus')->where('id', $coba)->first();
                        $nominalBon[$j][$nus] = $databon[$j][$nus]->nominal;
                        $jenisBon[$j][$nus] = $databon[$j][$nus]->jenis_bonus;
                        $valBon[$j] = $jenisBon[$j];
                        $nomBon[$j] = $nominalBon[$j];
                        $totalbon[$j] = array_sum($nominalBon[$j]);
                        
                    }
                }
                foreach($result as $x => $tes3){
                    $pot[$x] = explode(',', $tes3->id_potongan);
                    foreach($pot[$x] as $tongan => $coba2){ 
                        $datapot[$x][$tongan] = DB::table('potongan')->where('id', $coba2)->first();
                        $nominalPot[$x][$tongan] = $datapot[$x][$tongan]->nominal;
                        $jenisPot[$x][$tongan] = $datapot[$x][$tongan]->jenis_potongan;
                        $valPot[$x] = $jenisPot[$x];
                        $nomPot[$x] = $nominalPot[$x];
                        $totalpot[$x] = array_sum($nominalPot[$x]);
                        
                    }
                }
                foreach($result as $a => $jab){
                    $jabat[$a] = explode(',', $jab->id_jabatan);
        
                    foreach($jabat[$a] as $batan => $tan){ 
                        $datajab[$a][$batan] = DB::table('jabatan')->where('id', $tan)->first();
                        $jabgaji[$a][$batan] = $datajab[$a][$batan]->gaji;
                        $jenisjab[$a][$batan] = $datajab[$a][$batan]->jabatan;
                        $valjab[$a] = $jenisjab[$a];
                        $nomjab[$a] = array_sum($jabgaji[$a]);
                        
                    }
                }

                if($result != null){
                    foreach (array_keys($totaltun + $totalbon + $totalpot + $nomjab) as $key) {
                        $akhir[$key] = array($totaltun[$key] + $nomjab[$key] +$totalbon[$key] - $totalpot[$key]);
                        
                    }
                    return response()->json([
                        'data' => $result,
                        'tunjangan' => $val,
                        'nominal' => $nom,
                        'jabatan' => $valjab,
                        'gaji' => $nomjab,
                        'total_tunjangan' => $totaltun,
                        'bonus' => $valBon,
                        'nominal_bonus' => $nomBon,
                        'total_bonus' => $totalbon,
                        'potongan' => $valPot,
                        'nominal_potongan' => $nomPot,
                        'total_potongan' => $totalpot,
                        'hasil' => $akhir,
                        'message' => 'get data berhasil',
                        'status' => true
                    ]);
                }else{
                    return response()->json([
                        'message' => 'tidak ada data',
                        'status' => true
                    ]);
                }
                
                

    }
    public function allgaji(Request $request){
        $tunjangan = DB::table('penggajian')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->latest()
        ->get()->toArray();

        foreach($tunjangan as $i => $tes){
            $tun[$i] = explode(',', $tes->id_tunjangan);
            foreach($tun[$i] as $index => $row){ 
                $data[$i][$index] = DB::table('tunjangan')->where('id', $row)->first();
                $nominalALL[$i][$index] = $data[$i][$index]->nominal;
                $jenis[$i][$index] = $data[$i][$index]->jenis_tunjangan;
                $val[$i] = $jenis[$i];
                $nom[$i] = $nominalALL[$i];
                $totaltun[$i] = array_sum($nominalALL[$i]);
            }
        }
        foreach($tunjangan as $j => $tes2){
            $bon[$j] = explode(',', $tes2->id_bonus);
            foreach($bon[$j] as $nus => $coba){ 
                $databon[$j][$nus] = DB::table('bonus')->where('id', $coba)->first();
                $nominalBon[$j][$nus] = $databon[$j][$nus]->nominal;
                $jenisBon[$j][$nus] = $databon[$j][$nus]->jenis_bonus;
                $valBon[$j] = $jenisBon[$j];
                $nomBon[$j] = $nominalBon[$j];
                $totalbon[$j] = array_sum($nominalBon[$j]);
                
            }
        }
        foreach($tunjangan as $x => $tes3){
            $pot[$x] = explode(',', $tes3->id_potongan);
            foreach($pot[$x] as $tongan => $coba2){ 
                $datapot[$x][$tongan] = DB::table('potongan')->where('id', $coba2)->first();
                $nominalPot[$x][$tongan] = $datapot[$x][$tongan]->nominal;
                $jenisPot[$x][$tongan] = $datapot[$x][$tongan]->jenis_potongan;
                $valPot[$x] = $jenisPot[$x];
                $nomPot[$x] = $nominalPot[$x];
                $totalpot[$x] = array_sum($nominalPot[$x]);
                
            }
        }
        foreach($tunjangan as $a => $jab){
            $jabat[$a] = explode(',', $jab->id_jabatan);
            foreach($jabat[$a] as $batan => $tan){ 
                $datajab[$a][$batan] = DB::table('jabatan')->where('id', $tan)->first();
                $jabgaji[$a][$batan] = $datajab[$a][$batan]->gaji;
                $jenisjab[$a][$batan] = $datajab[$a][$batan]->jabatan;
                $valjab[$a] = $jenisjab[$a];
                $nomjab[$a] = array_sum($jabgaji[$a]);
                
            }
        }
            if($tunjangan != null){
                foreach (array_keys($totaltun + $totalbon + $totalpot + $nomjab) as $key) {
                    $akhir[$key] = array($totaltun[$key] + $nomjab[$key] +$totalbon[$key] - $totalpot[$key]);
                    
                }
               
            return response()->json([
                'data' => $tunjangan,
                'tunjangan' => $val,
                'nominal' => $nom,
                'jabatan' => $valjab,
                'gaji' => $nomjab,
                'total_tunjangan' => $totaltun,
                'bonus' => $valBon,
                'nominal_bonus' => $nomBon,
                'total_bonus' => $totalbon,
                'potongan' => $valPot,
                'nominal_potongan' => $nomPot,
                'total_potongan' => $totalpot,
                'hasil' => $akhir,
                'message' => 'get data berhasil',
                'status' => true
            ]);
            }else{
                return response()->json([
                    'message' => 'tidak ada data',
                    'status' => true
                ]);
            }
    }
    public function buatgaji(Request $request)
    {   
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'id_bonus' => 'required',
            'id_jabatan' => 'required',
            'id_tunjangan' => 'required',
            'id_potongan' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak lengkap',
            ]);
        }else{
            $tunjanganArray = implode(",",$request->id_tunjangan);
            $bonusArray = implode(",",$request->id_bonus);
            $potonganArray = implode(",",$request->id_potongan);
            $buatgaji =  Penggajian::create([
                'id_admin' => Auth::user()->id,
                'email' => $request->email,
                'id_jabatan' => $request->id_jabatan,
                'id_golongan' => $request->id_golongan,
                'tanggal' => Carbon::now(),
                'id_tunjangan' => $tunjanganArray,
                'id_bonus' => $bonusArray,
                'id_potongan' =>  $potonganArray
            ]);
            $buatgaji2 =  RiwayatGaji::create([
                'id_admin' => Auth::user()->id,
                'email' => $request->email,
                'id_jabatan' => $request->id_jabatan,
                'tanggal_ambil' => Carbon::now(),
                'id_golongan' => $request->id_golongan,
            ]);
                return response()->json([
                    'data' => $buatgaji,
                    'riwayat' => $buatgaji2,
                    'success' => true,
                    'message' => 'Buat Gaji Berhasil!',
                ]);
        }
        

    }
    public function updategaji(Request $request)
    {    
        $validate = Validator::make($request->all(), [
        'id_bonus' => 'required',
        'id_tunjangan' => 'required',
        'id_potongan' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak lengkap',
            ]);
        }else{
            $tunjanganArray = implode(",",$request->id_tunjangan);
            $bonusArray = implode(",",$request->id_bonus);
            $potonganArray = implode(",",$request->id_potongan);
            $updategaji = DB::table('penggajian')->where('id', $request->id)->update([
            'id_tunjangan' => $tunjanganArray,
            'id_bonus' => $bonusArray,
            'id_potongan' => $potonganArray,
        ]);
            return response()->json([
                'data' => $updategaji,
                'success' => true,
                'message' => 'Update Gaji Berhasil!',
            ]);
        }
           

    }
    public function detailgaji($id)
    {
       $detgaji = DB::table('penggajian')
       ->where('id' ,$id)
       ->get()->toArray();
       foreach($detgaji as $i => $tes){
        $tun[$i] = explode(',', $tes->id_tunjangan);
        foreach($tun[$i] as $index => $row){ 
            $data[$i][$index] = DB::table('tunjangan')->where('id', $row)->first();
            $nominalALL[$i][$index] = $data[$i][$index]->nominal;
            $jenis[$i][$index] = $data[$i][$index]->jenis_tunjangan;
            $val[$i] = $jenis[$i];
            $nom[$i] = $nominalALL[$i];
            $totaltun[$i] = array_sum($nominalALL[$i]);
            $arrtun[$i] = array($totaltun[$i]);
        }
    }
    foreach($detgaji as $j => $tes2){
        $bon[$j] = explode(',', $tes2->id_bonus);
        foreach($bon[$j] as $nus => $coba){ 
            $databon[$j][$nus] = DB::table('bonus')->where('id', $coba)->first();
            $nominalBon[$j][$nus] = $databon[$j][$nus]->nominal;
            $jenisBon[$j][$nus] = $databon[$j][$nus]->jenis_bonus;
            $valBon[$j] = $jenisBon[$j];
            $nomBon[$j] = $nominalBon[$j];
            $totalbon[$j] = array_sum($nominalBon[$j]);
            $arrbon[$j] = array($totalbon[$j]);
            
        }
    }
    foreach($detgaji as $x => $tes3){
        $pot[$x] = explode(',', $tes3->id_potongan);
        foreach($pot[$x] as $tongan => $coba2){ 
            $datapot[$x][$tongan] = DB::table('potongan')->where('id', $coba2)->first();
            $nominalPot[$x][$tongan] = $datapot[$x][$tongan]->nominal;
            $jenisPot[$x][$tongan] = $datapot[$x][$tongan]->jenis_potongan;
            $valPot[$x] = $jenisPot[$x];
            $nomPot[$x] = $nominalPot[$x];
            $totalpot[$x] = array_sum($nominalPot[$x]);
            $arrpot[$x] = array($totalpot[$x]);
            
        }
    }
    foreach($detgaji as $a => $jab){
        $jabat[$a] = explode(',', $jab->id_jabatan);

        foreach($jabat[$a] as $batan => $tan){ 
            $datajab[$a][$batan] = DB::table('jabatan')->where('id', $tan)->first();
            $jabgaji[$a][$batan] = $datajab[$a][$batan]->gaji;
            $jenisjab[$a][$batan] = $datajab[$a][$batan]->jabatan;
            $valjab[$a] = $jenisjab[$a];
            $nomjab[$a] = array_sum($jabgaji[$a]);
            $arrjab[$a] = array($nomjab[$a]);
            
        }
    }
    foreach (array_keys($totaltun + $totalbon + $totalpot + $nomjab) as $key) {
        $akhir[$key] = array($totaltun[$key] + $nomjab[$key] +$totalbon[$key] - $totalpot[$key]);
        
    }
    foreach (array_keys($totaltun + $totalbon + $nomjab) as $key) {
        $subtotal[$key] = array($totaltun[$key] + $nomjab[$key] +$totalbon[$key]);
        
    }
   
    return response()->json([
        'data' => $detgaji,
        'tunjangan' => $val,
        'arrtun' => $arrtun,
        'arrbon' => $arrbon,
        'arrpot' => $arrpot,
        'arrjab' => $arrjab,
        'nominal' => $nom,
        'jabatan' => $valjab,
        'gaji' => $nomjab,
        'total_tunjangan' => $totaltun,
        'bonus' => $valBon,
        'nominal_bonus' => $nomBon,
        'total_bonus' => $totalbon,
        'potongan' => $valPot,
        'nominal_potongan' => $nomPot,
        'total_potongan' => $totalpot,
        'hasil' => $akhir,
        'subtotal' => $subtotal,
        'message' => 'get data berhasil',
        'status' => true
    ]);

    }
    public function gajipegawai(){
        $gajipeg = Penggajian::where('email' ,Auth::user()->email)->latest()->get();
            foreach($gajipeg as $i => $tes){
                $tun[$i] = explode(',', $tes->id_tunjangan);
                foreach($tun[$i] as $index => $row){ 
                    $data[$i][$index] = DB::table('tunjangan')->where('id', $row)->first();
                    $nominalALL[$i][$index] = $data[$i][$index]->nominal;
                    $jenis[$i][$index] = $data[$i][$index]->jenis_tunjangan;
                    $val[$i] = $jenis[$i];
                    $nom[$i] = $nominalALL[$i];
                    $totaltun[$i] = array_sum($nominalALL[$i]);
                }
            }
            foreach($gajipeg as $j => $tes2){
                $bon[$j] = explode(',', $tes2->id_bonus);
                foreach($bon[$j] as $nus => $coba){ 
                    $databon[$j][$nus] = DB::table('bonus')->where('id', $coba)->first();
                    $nominalBon[$j][$nus] = $databon[$j][$nus]->nominal;
                    $jenisBon[$j][$nus] = $databon[$j][$nus]->jenis_bonus;
                    $valBon[$j] = $jenisBon[$j];
                    $nomBon[$j] = $nominalBon[$j];
                    $totalbon[$j] = array_sum($nominalBon[$j]);
                    
                }
            }
            foreach($gajipeg as $x => $tes3){
                $pot[$x] = explode(',', $tes3->id_potongan);
                foreach($pot[$x] as $tongan => $coba2){ 
                    $datapot[$x][$tongan] = DB::table('potongan')->where('id', $coba2)->first();
                    $nominalPot[$x][$tongan] = $datapot[$x][$tongan]->nominal;
                    $jenisPot[$x][$tongan] = $datapot[$x][$tongan]->jenis_potongan;
                    $valPot[$x] = $jenisPot[$x];
                    $nomPot[$x] = $nominalPot[$x];
                    $totalpot[$x] = array_sum($nominalPot[$x]);
                    
                }
            }
            foreach($gajipeg as $a => $jab){
                $jabat[$a] = explode(',', $jab->id_jabatan);
    
                foreach($jabat[$a] as $batan => $tan){ 
                    $datajab[$a][$batan] = DB::table('jabatan')->where('id', $tan)->first();
                    $jabgaji[$a][$batan] = $datajab[$a][$batan]->gaji;
                    $jenisjab[$a][$batan] = $datajab[$a][$batan]->jabatan;
                    $valjab[$a] = $jenisjab[$a];
                    $nomjab[$a] = array_sum($jabgaji[$a]);
                    
                }
            }
            foreach (array_keys($totaltun + $totalbon + $totalpot + $nomjab) as $key) {
                $akhir[$key] = array($totaltun[$key] + $nomjab[$key] +$totalbon[$key] - $totalpot[$key]);
                
            }
           
        return response()->json([
            'data' => $gajipeg,
            'tunjangan' => $val,
            'nominal' => $nom,
            'jabatan' => $valjab,
            'gaji' => $nomjab,
            'total_tunjangan' => $totaltun,
            'bonus' => $valBon,
            'nominal_bonus' => $nomBon,
            'total_bonus' => $totalbon,
            'potongan' => $valPot,
            'nominal_potongan' => $nomPot,
            'total_potongan' => $totalpot,
            'hasil' => $akhir,
            // 'subtotal' => $subtotal,
            'message' => 'get data berhasil',
            'status' => true
        ]);    
    }
    public function detgajipeg($id){
        $detgaji = DB::table('penggajian')
        ->where('id' ,$id)
        ->get()->toArray();
        foreach($detgaji as $i => $tes){
         $tun[$i] = explode(',', $tes->id_tunjangan);
         foreach($tun[$i] as $index => $row){ 
             $data[$i][$index] = DB::table('tunjangan')->where('id', $row)->first();
             $nominalALL[$i][$index] = $data[$i][$index]->nominal;
             $jenis[$i][$index] = $data[$i][$index]->jenis_tunjangan;
             $val[$i] = $jenis[$i];
             $nom[$i] = $nominalALL[$i];
             $totaltun[$i] = array_sum($nominalALL[$i]);
             $arrtun[$i] = array($totaltun[$i]);
         }
     }
     foreach($detgaji as $j => $tes2){
         $bon[$j] = explode(',', $tes2->id_bonus);
         foreach($bon[$j] as $nus => $coba){ 
             $databon[$j][$nus] = DB::table('bonus')->where('id', $coba)->first();
             $nominalBon[$j][$nus] = $databon[$j][$nus]->nominal;
             $jenisBon[$j][$nus] = $databon[$j][$nus]->jenis_bonus;
             $valBon[$j] = $jenisBon[$j];
             $nomBon[$j] = $nominalBon[$j];
             $totalbon[$j] = array_sum($nominalBon[$j]);
             $arrbon[$j] = array($totalbon[$j]);
             
         }
     }
     foreach($detgaji as $x => $tes3){
         $pot[$x] = explode(',', $tes3->id_potongan);
         foreach($pot[$x] as $tongan => $coba2){ 
             $datapot[$x][$tongan] = DB::table('potongan')->where('id', $coba2)->first();
             $nominalPot[$x][$tongan] = $datapot[$x][$tongan]->nominal;
             $jenisPot[$x][$tongan] = $datapot[$x][$tongan]->jenis_potongan;
             $valPot[$x] = $jenisPot[$x];
             $nomPot[$x] = $nominalPot[$x];
             $totalpot[$x] = array_sum($nominalPot[$x]);
             $arrpot[$x] = array($totalpot[$x]);
             
         }
     }
     foreach($detgaji as $a => $jab){
         $jabat[$a] = explode(',', $jab->id_jabatan);
 
         foreach($jabat[$a] as $batan => $tan){ 
             $datajab[$a][$batan] = DB::table('jabatan')->where('id', $tan)->first();
             $jabgaji[$a][$batan] = $datajab[$a][$batan]->gaji;
             $jenisjab[$a][$batan] = $datajab[$a][$batan]->jabatan;
             $valjab[$a] = $jenisjab[$a];
             $nomjab[$a] = array_sum($jabgaji[$a]);
             $arrjab[$a] = array($nomjab[$a]);
             
         }
     }
     foreach (array_keys($totaltun + $totalbon + $totalpot + $nomjab) as $key) {
         $akhir[$key] = array($totaltun[$key] + $nomjab[$key] +$totalbon[$key] - $totalpot[$key]);
         
     }
     foreach (array_keys($totaltun + $totalbon + $nomjab) as $key) {
        $subtotal[$key] = array($totaltun[$key] + $nomjab[$key] +$totalbon[$key]);
        
    }
    
    
     return response()->json([
         'data' => $detgaji,
         'tunjangan' => $val,
         'arrtun' => $arrtun,
         'arrbon' => $arrbon,
         'arrpot' => $arrpot,
         'arrjab' => $arrjab,
         'nominal' => $nom,
         'jabatan' => $valjab,
         'gaji' => $nomjab,
         'total_tunjangan' => $totaltun,
         'bonus' => $valBon,
         'nominal_bonus' => $nomBon,
         'total_bonus' => $totalbon,
         'potongan' => $valPot,
         'nominal_potongan' => $nomPot,
         'total_potongan' => $totalpot,
         'hasil' => $akhir,
         'subtotal' => $subtotal,
         'message' => 'get data berhasil',
         'status' => true
     ]);
 
    }

    public function ambilgaji(Request $request){
           $confirm = DB::table('penggajian')->where('id', $request->id)->update([
                'status' => $request->status,
            ]);
            if($confirm = 'Sudah Diambil'){
                $detgaji = DB::table('penggajian')
                ->where('id' ,$request->id)
                ->get()->toArray();
                foreach($detgaji as $i => $tes){
                 $tun[$i] = explode(',', $tes->id_tunjangan);
                 foreach($tun[$i] as $index => $row){ 
                     $data[$i][$index] = DB::table('tunjangan')->where('id', $row)->first();
                     $nominalALL[$i][$index] = $data[$i][$index]->nominal;
                     $jenis[$i][$index] = $data[$i][$index]->jenis_tunjangan;
                     $val[$i] = $jenis[$i];
                     $nom[$i] = $nominalALL[$i];
                     $totaltun[$i] = array_sum($nominalALL[$i]);
                     $arrtun[$i] = array($totaltun[$i]);
                 }
             }
             foreach($detgaji as $j => $tes2){
                 $bon[$j] = explode(',', $tes2->id_bonus);
                 foreach($bon[$j] as $nus => $coba){ 
                     $databon[$j][$nus] = DB::table('bonus')->where('id', $coba)->first();
                     $nominalBon[$j][$nus] = $databon[$j][$nus]->nominal;
                     $jenisBon[$j][$nus] = $databon[$j][$nus]->jenis_bonus;
                     $valBon[$j] = $jenisBon[$j];
                     $nomBon[$j] = $nominalBon[$j];
                     $totalbon[$j] = array_sum($nominalBon[$j]);
                     $arrbon[$j] = array($totalbon[$j]);
                     
                 }
             }
             foreach($detgaji as $x => $tes3){
                 $pot[$x] = explode(',', $tes3->id_potongan);
                 foreach($pot[$x] as $tongan => $coba2){ 
                     $datapot[$x][$tongan] = DB::table('potongan')->where('id', $coba2)->first();
                     $nominalPot[$x][$tongan] = $datapot[$x][$tongan]->nominal;
                     $jenisPot[$x][$tongan] = $datapot[$x][$tongan]->jenis_potongan;
                     $valPot[$x] = $jenisPot[$x];
                     $nomPot[$x] = $nominalPot[$x];
                     $totalpot[$x] = array_sum($nominalPot[$x]);
                     $arrpot[$x] = array($totalpot[$x]);
                     
                 }
             }
             foreach($detgaji as $a => $jab){
                 $jabat[$a] = explode(',', $jab->id_jabatan);
         
                 foreach($jabat[$a] as $batan => $tan){ 
                     $datajab[$a][$batan] = DB::table('jabatan')->where('id', $tan)->first();
                     $jabgaji[$a][$batan] = $datajab[$a][$batan]->gaji;
                     $jenisjab[$a][$batan] = $datajab[$a][$batan]->jabatan;
                     $valjab[$a] = $jenisjab[$a];
                     $nomjab[$a] = array_sum($jabgaji[$a]);
                     $arrjab[$a] = array($nomjab[$a]);
                     
                 }
             }
             foreach (array_keys($totaltun + $totalbon + $totalpot + $nomjab) as $key) {
                 $akhir[$key] = array($totaltun[$key] + $nomjab[$key] +$totalbon[$key] - $totalpot[$key]);
                 
             }
             foreach (array_keys($totaltun + $totalbon + $nomjab) as $key) {
                $subtotal[$key] = array($totaltun[$key] + $nomjab[$key] +$totalbon[$key]);
                
            }

                $riwayat = RiwayatGaji::where('id', $request->id)->update([
                    'id_admin' => Auth::user()->id_admin,
                    'email' => Auth::user()->email,
                    'tanggal_ambil' => Carbon::now(),
                    'id_jabatan' => Auth::user()->id_jabatan,
                    'id_golongan' => Auth::user()->id_golongan,
                    'tunjangan' => implode(",",$val[$i]),
                    'nominal_tunjangan' => implode(",",$nom[$i]), 
                    'total_tunjangan'=> implode(",", $arrtun[$i]),
                    'bonus' => implode(",", $valBon[$j]),
                    'nominal_bonus' => implode(",", $nomBon[$j]), 
                    'total_bonus'=> implode(",", $arrbon[$j]),
                    'potongan' => implode(",", $valPot[$x]),
                    'nominal_potongan' => implode(",", $nomPot[$x]), 
                    'total_potongan'=> implode(",", $arrpot[$x]),
                    'gaji_kotor'=> implode(",", $subtotal[$key]),
                    'gaji_bersih' => implode(",", $akhir[$key]),
                    'gaji_pokok' => implode(",", $arrjab[$a]),
                    'status' => 'Sudah Diambil'


                ]);

                return response()->json([
                    'data' => $confirm,
                    'riwayat' => $riwayat,
                    'tes' => $val,
                    'success' => true,
                    'message' => 'Berhasil Ambil cuk!',
                ]);   
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal lah
                    ',
                ]);   
            }

            
    }
    public function detriwayatgaji($id){
        $detgaji = DB::table('riwayatgaji')
        ->where('id' ,$id)
        ->get()->toArray();
        foreach($detgaji as $i => $tes){
         $tun[$i] = explode(',', $tes->tunjangan);
         $nomtun[$i] = explode(',', $tes->nominal_tunjangan);
         $bon[$i] = explode(',', $tes->bonus);
         $nombon[$i] = explode(',', $tes->nominal_bonus);
         $pot[$i] = explode(',', $tes->potongan);
         $nompot[$i] = explode(',', $tes->nominal_potongan);

        }
     return response()->json([
         'data' => $detgaji,
         'tunjangan' => $tun,
         'nomtun' => $nomtun,
         'bonus' => $bon,
         'nombon' => $nombon,
         'potongan' => $pot,
         'nompot' => $nompot,
         'message' => 'get data berhasil',
         'status' => true
     ]);
 
    }
    public function hapusgaji(Request $request, $id)
    {
        $data = Penggajian::findOrFail($id);
        $data->delete();
        return response()->json([
            'success' => true,
            'message' => 'Hapus data berhasil'
        ]);
    }
    

  
}
