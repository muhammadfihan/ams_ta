<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DataPegawai;
use App\Models\Gaji;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class DataPegawaiController extends Controller
{
    public function isibiodata(Request $request){
        $pegawai = [
            'name' => 'required|string',
            'nama_lengkap' => 'required|string',
            'email' => 'required|string',
            'jabatan' => 'required|integer',
            'id_admin' => 'required|integer',
            'id' => 'required|integer',
            'pendidikan' => 'required|string',
            'golongan' => 'required|string',
            'no_hp' => 'required|bigInteger',
            'no_ktp' => 'required|bigInteger',
            'gender' => 'required|string',
            'alamat' => 'required|string',
        ];

        $huruf = "1234567890";
        $nopegawai = strtoupper(substr(str_shuffle($huruf), 0, 9));
        $pegawai = DataPegawai::updateOrCreate([
            'no_pegawai' => Auth::user()->no_pegawai,
            'name' => Auth::user()->name,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => Auth::user()->email,
            'id' => Auth::user()->id,
            'jabatan' => Auth::user()->jabatan,
            'id_admin' => Auth::user()->id_admin,
            'no_hp' => $request->no_hp,
            'no_ktp' => $request->no_ktp,
            'gender' => $request->gender,
            'golongan' => $request->Auth::user()->golongan,
            'pendidikan' => $request->pendidikan,
            'alamat' => $request->alamat
        ]);
        $datagaji = Gaji::create([
            'no_pegawai' => Auth::user()->no_pegawai,
            'name' => Auth::user()->name,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => Auth::user()->email,
            'id' => Auth::user()->id,
            'jabatan' => Auth::user()->jabatan,
            'id_admin' => Auth::user()->id_admin,
            'golongan' => Auth::user()->golongan,
        ]);
        $response = ['pegawai' => $pegawai];
        return response([
            'datagaji' => $datagaji,
            'data' => $response,
            'message' => 'Berhasil mengisi biodata',
            'status' => true,
            'isi' => 'berhasil',
            'success' => true,
        ]);
 


    }
    public function datapegawai()
    {
       $datapegawai = DB::table('pegawais')
           ->select('*')
           ->where('id_admin', Auth::user()->id)
           ->latest()
           ->paginate(10);
       return response([
           'data' => $datapegawai,
           'message' => 'get data berhasil',
           'status' => true
       ]);

    }
    public function searchdata($key)
    {
            $result = DB::table('pegawais')
                ->select('*')
                ->where('pegawais.id_admin', Auth::user()->id)
                ->where('email', 'like', '%' . $key . '%')
                ->orWhere('no_pegawai', 'like', '%' . $key . '%')
                ->orWhere('name', 'like', '%' . $key . '%')
                ->orWhere('nama_lengkap', 'like', '%' . $key . '%')
                ->orWhere('pendidikan', 'like', '%' . $key . '%')
                ->orWhere('alamat', 'like', '%' . $key . '%')
                ->orWhere('status', 'like', '%' . $key . '%')
                ->orWhere('gender', 'like', '%' . $key . '%')
                ->where('pegawais.id_admin', Auth::user()->id)
                ->latest()
                ->paginate(10);

            return $result;

    }
    public function datpeg()
    {
       $datapegawai = DB::table('pegawais')
           ->select('*')
           ->where('email', Auth::user()->email)
           ->latest()
           ->get();
       return response([
           'data' => $datapegawai,
           'message' => 'get data berhasil',
           'status' => true
       ]);

    }

    public function detailpegawai($id)
    {
       $datapegawai = DB::table('pegawais')
       ->where('id' ,$id)
       ->get();
       return response([
           'data' => $datapegawai,
           'message' => 'get data berhasil',
           'status' => true,
       ]);

    }
    public function editpegawai($id)
    {
        $edit = DB::table('pegawais')
            ->where('id' ,$id)
            ->get();
       return response([
           'data' => $edit,
           'message' => 'get data berhasil',
           'status' => true,
        
       ]);
    }

    public function updatepegawai(Request $request)
    {
        
            $validate = Validator::make($request->all(), [
                'id_jabatan' => 'required',
                'status' => 'required'
             ]);
    
            if ($validate->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Update Data Gagal!',
                ]);
            } else {
                DB::table('pegawais')->where('id', $request->id)->update([
                    'id_jabatan' => $request->id_jabatan,
                    'id_golongan' => $request->id_golongan,
                    'status' => $request->status,
                ]);
                DB::table('akunpegawai')->where('id', $request->id)->update([
                    'id_jabatan' => $request->id_jabatan,
                    'id_golongan' => $request->id_golongan,
                    'status' => $request->status,
                ]);
                DB::table('datagaji')->where('id', $request->id)->update([
                    'id_jabatan' => $request->id_jabatan,
                    'id_golongan' => $request->id_golongan,
                    'status' => $request->status,
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Update Data Berhasil!',
                ]);
            }
        
    }
    public function updatedata(Request $request)
    {

            $validate = Validator::make($request->all(), [
                'nama_lengkap' => 'required',
                'pendidikan' => 'required',
                'no_hp' => 'required',
                'no_ktp' => 'required',
                'gender' => 'required',
                'alamat' => 'required',
             ]);
    
            if ($validate->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Update Data Gagal!',
                ]);
            } else {
                $data = DB::table('pegawais')->where('id', Auth::user()->id)->update([
                    'nama_lengkap' => $request->nama_lengkap,
                    'pendidikan' => $request->pendidikan,
                    'no_hp' => $request->no_hp,
                    'no_ktp' => $request->no_ktp,
                    'gender' => $request->gender,
                    'alamat' => $request->alamat,
                ]);
                $nopegawai  = DB::table('pegawais')->where('id', Auth::user()->id)
                ->pluck('no_pegawai')
                ->first();
                $data = DB::table('pegawais')->where('id', Auth::user()->id)->update([
                    'nama_lengkap' => $request->nama_lengkap,
                    'pendidikan' => $request->pendidikan,
                    'no_hp' => $request->no_hp,
                    'no_ktp' => $request->no_ktp,
                    'gender' => $request->gender,
                    'alamat' => $request->alamat,
                ]);
                $jam_kerja  = DB::table('pegawais')->where('id', Auth::user()->id)
                ->pluck('jam_kerja')
                ->first();
                $gaji = DB::table('datagaji')->where('id', Auth::user()->id)->first();
                if($gaji){
                    DB::table('pegawais')->where('id', Auth::user()->id)->update([
                        'nama_lengkap' => $request->nama_lengkap,
                        'pendidikan' => $request->pendidikan,
                        'no_hp' => $request->no_hp,
                        'no_ktp' => $request->no_ktp,
                        'gender' => $request->gender,
                        'alamat' => $request->alamat,
                    ]);
                    DB::table('datagaji')->where('id', Auth::user()->id)->update([
                        'nama_lengkap' => $request->nama_lengkap,
                    ]);
                }
                else{
                $gaji = Gaji::create([
                    'no_pegawai' => $nopegawai,
                    'name' => Auth::user()->name,
                    'nama_lengkap' => $request->nama_lengkap,
                    'email' => Auth::user()->email,
                    'id' => Auth::user()->id,
                    'jam_kerja' => $jam_kerja,
                    'id_jabatan' => Auth::user()->id_jabatan,
                    'id_admin' => Auth::user()->id_admin,
                    'id_golongan' => Auth::user()->id_golongan,
                ]);
                }
                return response()->json([
                    'data' => $data,
                    'datagaji' => $gaji,
                    'success' => true,
                    'message' => 'Berhasil Update Data',
                ]);
            }
        
    }

    public function getprofile(Request $request){
        $profile = DataPegawai::where('id' ,Auth::user()->id)->get();
            return response([
                'data' => $profile,
                'message' => 'get data berhasil',
                'status' => true,
            ]);
       
    }
    public function hapuspegawai(Request $request, $id)
    {
        $data = DataPegawai::findOrFail($id);
        $data->delete();
        return response()->json([
            'success' => true,
            'message' => 'Hapus data berhasil'
        ]);
    }
}
