<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tunjangan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Bonus;
use App\Models\Gaji;
use App\Models\Potongan;

class GajiController extends Controller
{
    public function tambahtunjangan(Request $request){
        $tunjangan = Tunjangan::create([
            'id_admin' => Auth::user()->id,
            'jenis_tunjangan' => $request->jenis_tunjangan,
            'nominal' => $request->nominal,
        ]);
        $tunjangan->save();
        $success = true;
        return response()->json([
            'message' =>'Jabatan successfully added',
            'success' => $success

            ]);
    }
    public function allgaji(){
        $tunjangan = DB::table('datagaji')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->latest()
        ->get();
    return response([
        'data' => $tunjangan,
        'message' => 'get data berhasil',
        'status' => true
    ]);
    }
   
    public function updatetunjangan(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'jenis_tunjangan' => 'required',
            'nominal' => 'required',
         ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            DB::table('tunjangan')->where('id', $request->id)->update([
                'jenis_tunjangan' => $request->jenis_tunjangan,
                'nominal' => $request->nominal,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Update Jabatan Berhasil!',
            ]);
        }
    }
    public function hapustunjangan(Request $request, $id)
    {
        $data = Tunjangan::findOrFail($id);
        $data->delete();
        return response()->json([
            'success' => true,
            'message' => 'Hapus data berhasil'
        ]);
    }

    public function alltunjangan(){
        $tunjangan = DB::table('tunjangan')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->latest()
        ->get();
    return response([
        'data' => $tunjangan,
        'message' => 'get data berhasil',
        'status' => true
    ]);
    }
    public function searchtunjangan($key)
    {
            $result = DB::table('tunjangan')
                ->select('*')
                ->where('tunjangan.id_admin', Auth::user()->id)
                ->where('jenis_tunjangan', 'like', '%' . $key . '%')
                ->where('tunjangan.id_admin', Auth::user()->id)
                ->latest()
                ->get();
            return $result;

    }

    //bonus
    public function tambahbonus(Request $request){
        $tunjangan = Bonus::create([
            'id_admin' => Auth::user()->id,
            'jenis_bonus' => $request->jenis_bonus,
            'nominal' => $request->nominal,
        ]);
        $tunjangan->save();
        $success = true;
        return response()->json([
            'message' =>'Tunjangan successfully added',
            'success' => $success

            ]);
    }

    public function updatebonus(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'jenis_bonus' => 'required',
            'nominal' => 'required',
         ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            DB::table('bonus')->where('id', $request->id)->update([
                'jenis_bonus' => $request->jenis_bonus,
                'nominal' => $request->nominal,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Update Bonus Berhasil!',
            ]);
        }
    }
    public function hapusbonus(Request $request, $id)
    {
        $data = Bonus::findOrFail($id);
        $data->delete();
        return response()->json([
            'success' => true,
            'message' => 'Hapus data berhasil'
        ]);
    }

    public function allbonus(){
        $bonus = DB::table('bonus')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->latest()
        ->get();
    return response([
        'data' => $bonus,
        'message' => 'get data berhasil',
        'status' => true
    ]);
    }
    public function searchbonus($key)
    {
            $result = DB::table('bonus')
                ->select('*')
                ->where('bonus.id_admin', Auth::user()->id)
                ->where('jenis_bonus', 'like', '%' . $key . '%')
                ->where('bonus.id_admin', Auth::user()->id)
                ->latest()
                ->get();
            return $result;

    }
    
    public function tambahpotongan(Request $request){
        $potongan = Potongan::create([
            'id_admin' => Auth::user()->id,
            'jenis_potongan' => $request->jenis_potongan,
            'nominal' => $request->nominal,
        ]);
        $potongan->save();
        $success = true;
        return response()->json([
            'message' =>'Potongan successfully added',
            'success' => $success

            ]);
    }

    public function updatepotongan(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'jenis_potongan' => 'required',
            'nominal' => 'required',
         ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            DB::table('potongan')->where('id', $request->id)->update([
                'jenis_potongan' => $request->jenis_potongan,
                'nominal' => $request->nominal,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Update Potongan Berhasil!',
            ]);
        }
    }
    public function hapuspotongan(Request $request, $id)
    {
        $data = Potongan::findOrFail($id);
        $data->delete();
        return response()->json([
            'success' => true,
            'message' => 'Hapus data berhasil'
        ]);
    }

    public function allpotongan(){
        $bonus = DB::table('potongan')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->latest()
        ->get();
    return response([
        'data' => $bonus,
        'message' => 'get data berhasil',
        'status' => true
    ]);
    }
    public function searchpotongan($key)
    {
            $result = DB::table('potongan')
                ->select('*')
                ->where('potongan.id_admin', Auth::user()->id)
                ->where('jenis_potongan', 'like', '%' . $key . '%')
                ->where('potongan.id_admin', Auth::user()->id)
                ->latest()
                ->get();
            return $result;

    }
}
