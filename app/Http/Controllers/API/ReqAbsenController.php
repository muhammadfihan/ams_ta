<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\DataPegawai;
use App\Models\Absensi;
use App\Models\ReqAbsen;
use Illuminate\Support\Facades\Validator;

class ReqAbsenController extends Controller
{
    public function allreq(){
        $reqabsen = DB::table('reqabsen')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->latest()
        ->paginate(10);
    return response([
        'data' => $reqabsen,
        'message' => 'get data berhasil',
        'status' => true
    ]);
    }
    public function searchreqabsen($key)
    {
            $result = DB::table('reqabsen')
                ->select('*')
                ->where('reqabsen.id_admin', Auth::user()->id)
                ->where('name', 'like', '%' . $key . '%')
                ->orWhere('nama_lengkap', 'like', '%' . $key . '%')
                ->orWhere('email', 'like', '%' . $key . '%')
                ->orWhere('no_pegawai', 'like', '%' . $key . '%')
                ->orWhere('status_req', 'like', '%' . $key . '%')
                ->orWhere('tanggal_req', 'like', '%' . $key . '%')
                ->where('reqabsen.id_admin', Auth::user()->id)
                ->paginate(10);

            return $result;

    }

    public function allreqpegawai(){
        $reqabsen = DB::table('reqabsen')
        ->select('*')
        ->where('id_admin', Auth::user()->id_admin)
        ->latest()
        ->get();
    return response([
        'data' => $reqabsen,
        'message' => 'get data berhasil',
        'status' => true
    ]);

    }
    public function searchreqabsenpeg($key)
    {
            $result = DB::table('reqabsen')
                ->select('*')
                ->where('reqabsen.email', Auth::user()->email)
                ->where('tanggal', 'like', '%' . $key . '%')
                ->orWhere('alasan', 'like', '%'. $key . '%')
                ->orWhere('status_req', 'like', '%' . $key . '%')
                ->orWhere('tanggal_req', 'like', '%' . $key . '%')
                ->where('reqabsen.email', Auth::user()->email)
                ->latest()
                ->paginate(10);

            return $result;

    }

    public function ajukanreqabsen(Request $request){
        if($request->hasfile('bukti_pendukung')){
            $file_path = "files/";
            $filename = str_replace('','',$request->file('bukti_pendukung')->getClientOriginalName());
            $request->file('bukti_pendukung')->move($file_path, $filename);

            $user = DataPegawai::where('id', Auth::user()->id)->first();
            $reqabsen = ReqAbsen::create([
                'id' => Auth::user()->id,
                'id_admin' => Auth::user()->id_admin,
                'email' => Auth::user()->email,
                'name' => Auth::user()->name,
                'nama_lengkap' => $user->nama_lengkap,
                'no_pegawai' => $user->no_pegawai,
                'tanggal_req' => $request->tanggal_req,
                'alasan' => $request->alasan,
                'bukti_pendukung' => $filename,
            ]);
            $reqabsen->save();
            $success = true;
            return response()->json([
                'data' => $reqabsen,
                'message' =>'Izin successfully added',
                'success' => $success
    
                ]);
        }

    }
    
    public function approvereqabsen(Request $request){
        $validate = Validator::make($request->all(), [
            'status_req' => 'required',
         ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            $jam = DB::table('jamabsen')->where('id_admin', Auth::user()->id)->first();
            $status =  DB::table('reqabsen')->where('uid', $request->uid)->update([
                'status_req' => $request->status_req,
            ]);
            $inputabsen = DB::table('reqabsen')->where('uid', $request->uid)->first();
            if($inputabsen->status_req == "Ditolak"){
                return response()->json([

                    'success' => true,
                    'message' => 'Ditolak',
                ]);
            }
            
            $absen = Absensi::create([
                        'id' => $inputabsen->id,
                        'email' => $inputabsen->email,
                        'id_admin' => $inputabsen->id_admin,
                        'name' => $inputabsen->name,
                        'nama_lengkap' => $inputabsen->name,
                        'selfie_masuk' => 0,
                        'tanggal' => $inputabsen->tanggal_req,
                        'jam_masuk' => 0,
                        'jam_pulang' => 0,
                        'jam_kerja' => date('H:i:s', strtotime($jam->jam_pulang) - strtotime($jam->jam_masuk)),
                        'keterangan' => 'Request Attendance',
                        'lokasi' => 0
                    ]);
            return response()->json([
                'absen' => $absen,
                'data' => $status,
                'success' => true,
                'message' => 'Update Status Berhasil!',
            ]);
            // if($request->status == "Ditolak"){
            //     return response()->json([
            //         'data' => $status,
            //         'success' => true,
            //         'message' => 'Ditolak !',
            //     ]);
            // }
            // if($request->status == "Diterima"){
            //     $absen = Absensi::create([
            //         'id' => null,
            //         'email' => Auth::user()->email,
            //         'id_admin' => Auth::user()->id_admin,
            //         'name' => Auth::user()->name,
            //         'nama_lengkap' => Auth::user()->name,
            //         'selfie_masuk' => null,
            //         'tanggal' => null,
            //         'jam_masuk' => null,
            //         'lokasi' => null
            //     ]);
            //     return response()->json([
            //         'data' => $absen,
            //         'success' => true,
            //         'message' => 'Update Status Berhasil!',
            //     ]);
            // }
        }
    }
    public function updatereqabsen(Request $request){
        
        $validate = Validator::make($request->all(), [
            'tanggal_req' => 'required',
            'alasan' => 'required',
            'bukti_pendukung' => 'required',
         ]);
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            if($request->hasfile('bukti_pendukung')){
                $filename = str_replace('','',$request->file('bukti_pendukung')->getClientOriginalName());
                $request->file('bukti_pendukung')->move(public_path('files'), $filename);

                $update = DB::table('reqabsen')->where('uid', $request->uid)->update([
                    'tanggal_req' => $request->tanggal_req,
                    'alasan' => $request->alasan,
                    'bukti_pendukung' => $filename
                ]);
    
                return response()->json([
                    'data' => $update,
                    'success' => true,
                    'message' => 'Update Req Attendance Berhasil!',
                ]);
            }
            
        }

    }
    public function hapusreqabsen($uid){
        $data = ReqAbsen::findOrFail($uid);
        $data->delete();
        return response()->json([
            'success' => true,
            'message' => 'Hapus data berhasil'
        ]);
    }
}
