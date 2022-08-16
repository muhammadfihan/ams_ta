<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;
use DateTimeZone;
use App\Models\Absensi;
use App\Models\JamAbsen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class AbsensiController extends Controller
{
    public function absenmasuk(Request $request){
        $timezone = 'Asia/Jakarta'; 
        $date = new DateTime('now', new DateTimeZone($timezone)); 
        $tanggal = $date->format('Y-m-d');
        $localtime = $date->format('H:i:s');
        $presensi = DB::table('absensipegawai')
            ->select('*')
            ->whereDate('tanggal', $tanggal)
            ->where('id', Auth::user()->id)
            ->first();
        $izin = DB::table('izin')
            ->select('*')
            ->whereDate('tanggal', $tanggal)
            ->where('email', Auth::user()->email)
            ->where('status_izin', '=', 'Diterima')
            ->first();
        if($izin){
            return response()->json([
                'sudahizin' => $izin,
                'success' => false,
                'status' => false,
                'message' => 'Anda Sedang izin !',
            ]);
        }        
        if ($presensi){
            return response()->json([
                'sudahabsen' => $presensi,
                'success' => false,
                'message' => 'Sudah Presensi!',
            ]);
        }else{
            $filename="";
            $file_path = "upload/";
            $webcam_image = $request->selfie_masuk;
            $image_parts = explode(";base64,", $webcam_image); // split the base64 image
            $image_type_aux = explode("image/", $image_parts[0]); 
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]); // decode the second part of the image
            $filename = uniqid() . '.png';
            $file = $file_path . $filename; 
            file_put_contents($file, $image_base64);

            $masuk = DB::table('jamabsen')
            ->select('*')
            ->where('id_admin', Auth::user()->id_admin)
            ->pluck('jam_masuk')
            ->first();

            $absen = Absensi::create([
                'id' => Auth::user()->id,
                'email' => Auth::user()->email,
                'id_admin' => Auth::user()->id_admin,
                'name' => Auth::user()->name,
                'nama_lengkap' => Auth::user()->name,
                'selfie_masuk' => $filename,
                'tanggal' => $tanggal,
                'jam_masuk' => $localtime,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ]);
            if ($absen->jam_masuk <= $masuk){
                $ket = [
                    'keterangan' => "On Time",
                ];
                $ontime = Absensi::where([
                    ['id','=', Auth::user()->id],
                    ['email','=', Auth::user()->email],
                    ['tanggal','=',$tanggal],
                ])->first();
                $ontime->update($ket);
                return response()->json([
                    'absensi' => $absen,
                    'data' => $ket,
                    'jam' => $masuk,
                    'message' => 'on time',
                    'success' => true
                ]);
            }
            if ($absen->jam_masuk >= $masuk){
                $ket = [
                    'keterangan' => "Terlambat",
                ];
                $telat = Absensi::where([
                    ['id','=', Auth::user()->id],
                    ['email','=', Auth::user()->email],
                    ['tanggal','=',$tanggal],
                ])->first();
                $telat->update($ket);
                return response()->json([
                    'absensi' => $absen,
                    'data' => $ket,
                    'jam' => $masuk,
                    'message' => 'terlambat',
                    'success' => true
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Berhasil Presensi',
                'absenmasuk' => $absen
            ]);
        }
    }
    public function tampilabsen(){
            $data = DB::table('absensipegawai')
                ->select('*')
                ->where('id_admin', Auth::user()->id)
                ->latest()
                ->paginate(10);
            return response()->json([
                'data' => $data,
                'message' => 'get data berhasil',
                'status' => true
            ]);
    }
    public function searchabsen($key)
    {
            $result = DB::table('absensipegawai')
                ->select('*')
                ->where('absensipegawai.id_admin', Auth::user()->id)
                ->where('email', 'like', '%' . $key . '%')
                ->orWhere('name', 'like', '%' . $key . '%')
                ->orWhere('nama_lengkap', 'like', '%' . $key . '%')
                ->orWhere('lokasi', 'like', '%' . $key . '%')
                ->orWhere('keterangan', 'like', '%' . $key . '%')
                ->orWhere('tanggal', 'like', '%' . $key . '%')
                ->orWhere('jam_masuk', 'like', '%' . $key . '%')
                ->orWhere('jam_pulang', 'like', '%' . $key . '%')
                ->where('absensipegawai.id_admin', Auth::user()->id)
                ->latest()
                ->paginate(10);

            return $result;

    }
    public function searchabsenpeg($key)
    {
            $result = DB::table('absensipegawai')
                ->select('*')
                ->where('absensipegawai.email', Auth::user()->email)
                ->where('tanggal', 'like', '%' . $key . '%')
                ->orWhere('jam_masuk', 'like', '%' . $key . '%')
                ->orWhere('keterangan', 'like', '%' . $key . '%')
                ->orWhere('jam_pulang', 'like', '%' . $key . '%')
                ->where('absensipegawai.email', Auth::user()->email)
                ->latest()
                ->paginate(10);

            return $result;

    }
    public function tampilpegawai(){
        $data = DB::table('absensipegawai')
            ->select('*')
            ->where('id', Auth::user()->id)
            ->latest()
            ->paginate(10);
        return response()->json([
            'data' => $data,
            'message' => 'get data berhasil',
            'status' => true
        ]);
}
    public function absendashboard(){
        $timezone = 'Asia/Jakarta'; 
        $date = new DateTime('now', new DateTimeZone($timezone)); 
        $tanggal = $date->format('Y-m-d');
        $data = DB::table('absensipegawai')
                ->select('*')
                ->where('id_admin', Auth::user()->id)
                ->whereDate('tanggal', $tanggal)
                ->latest()
                ->get();
            return response()->json([
                'data' => $data,
                'message' => 'get data berhasil',
                'status' => true
            ]);
    }
    public function counthadir(){
        $timezone = 'Asia/Jakarta'; 
        $date = new DateTime('now', new DateTimeZone($timezone)); 
        $tanggal = $date->format('Y-m-d');
        $data = DB::table('absensipegawai')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->whereDate('tanggal', $tanggal)
        ->count();
  
    return response()->json([
        'data' => $data,
        'message' => 'get jumlah berhasil',
        'status' => true
    ]);
    }

    public function counttidakhadir(){
        $timezone = 'Asia/Jakarta'; 
        $date = new DateTime('now', new DateTimeZone($timezone)); 
        $tanggal = $date->format('Y-m-d');
        $data = DB::table('absensipegawai')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->where('tanggal', $tanggal)
        ->count();
        
        $count = DB::table('users')
        ->select('*')
        ->where('id', Auth::user()->id)
        ->pluck('jumlah_karyawan');

        $tidak_hadir = $count - $data;

    return response()->json([
        'data' => $tidak_hadir,
        'message' => 'get jumlah berhasil',
        'status' => true
    ]);
    }

    public function absenpulang(Request $request){
        $timezone = 'Asia/Jakarta'; 
        $date = new DateTime('now', new DateTimeZone($timezone)); 
        $tanggal = $date->format('Y-m-d');
        $localtime = $date->format('H:i:s');

        $filename="";
        $file_path = "upload/";
        $webcam_image = $request->selfie_pulang;
        //$webcam_image = $request->input('image');
        //dd($webcam_image);
        $image_parts = explode(";base64,", $webcam_image); // split the base64 image
        $image_type_aux = explode("image/", $image_parts[0]); 
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]); // decode the second part of the image
        $filename = uniqid() . '.png';
        $file = $file_path . $filename; 
        file_put_contents($file, $image_base64);

        $presensi = Absensi::where('id', Auth::user()->id)
        // ->where('uid', $request->uid)
        ->whereDate('tanggal', $tanggal)
        ->first();

        $tes = JamAbsen::where('id_admin', Auth::user()->id_admin)
        ->first();

        // $hasilblm = strtotime($tes->jam_pulang);
        // $hasiltgl = strtotime($tanggal);

        if ($presensi == null){
            return response()->json([
                'sudahabsen' => $presensi,
                'status' => false,
                'message' => 'Harap Presensi Terlebih Dahulu',
            ]);
        }
        elseif ($localtime < $tes->jam_pulang){
            return response()->json([
                'status' => false,
                'message' => 'Tunggu Pulang',
            ]);
        }

        $dt=[
            'jam_pulang' => $localtime,
            'jam_kerja' => date('H:i:s', strtotime($localtime) - strtotime($presensi->jam_masuk)),
            'selfie_pulang' => $filename,
        ];   

        if ($presensi->jam_pulang == ""){
            $hasil = DB::table('absensipegawai')
            ->where('id', Auth::user()->id)
            ->whereDate('tanggal', $tanggal)
            ->update($dt);

            $totaljamkerja = DB::table('pegawais')
                ->select('*')
                ->where('id', Auth::user()->id)
                ->first();
            $jamkerja = DB::table('absensipegawai')
                ->select('*')
                ->where('id', Auth::user()->id)
                ->whereDate('tanggal', $tanggal)
                ->first();
            $jumlahkerja = DB::table('pegawais')
                ->select('*')
                ->where('id', Auth::user()->id)
                ->first();    
            $total = date('H:i:s' , strtotime($totaljamkerja->jam_kerja) + strtotime($jamkerja->jam_kerja));
            $jmlh = $jumlahkerja->jumlah_kerja + 1 ;
            $hasil = DB::table('datagaji')
            ->where('id' , Auth::user()->id)
            ->update([
                'jam_kerja' => $total
            ]);
            $hasil2 = DB::table('pegawais')
            ->where('id' , Auth::user()->id)
            ->update([
                'jam_kerja' => $total
            ]);
            $hasilkerja = DB::table('pegawais')
            ->where('id' , Auth::user()->id)
            ->update([
                'jumlah_kerja' => $jmlh
            ]);
            if($hasilkerja = 365){
                $jatahcuti = DB::table('pegawais')
                ->where('id' , Auth::user()->id)
                ->update([
                    'jatah_cuti' => 12
                ]);   
            }
            return response()->json([
                'data' => $dt,
                'jatah_cuti' => $jatahcuti,
                'jumlah_kerja' => $hasilkerja,
                'updategaji' => $hasil2,
                'data_lagi' => $hasil,
                'tanggal' => $tanggal,
                'total_jamkerja' => $total,
                'message' => 'presensi pulang berhasil',
                'success' => true
            ]);
        }else{
            return response()->json([
                'message' => 'Sudah presensi pulang',
                'success' => false
            ]);
        }
    }

    public function detailabsen($uid)
    {
       $detabsen = DB::table('absensipegawai')
       ->where('uid' ,$uid)
       ->get();
       return response([
           'data' => $detabsen,
           'message' => 'get data berhasil',
           'status' => true,
       ]);

    }
    public function tes(Request $request)
    {
        $timezone = 'Asia/Jakarta'; 
        $date = new DateTime('now', new DateTimeZone($timezone)); 
        $tanggal = $date->format('Y-m-d');
        $localtime = $date->format('H:i:s');

        $presensi = DB::table('absensipegawai')
        ->where('id', Auth::user()->id)
        ->where('uid', $request->uid)
        ->where('jam_pulang','=', null)
        ->where('tanggal', $tanggal)
        ->first();

        return response()->json([
            'data' => $presensi,
            'message' => 'presensi pulang berhasil',
            'success' => true
        ]);

    }
}
