<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\Golongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class GolonganController extends Controller
{
    public function allgolongan()
    {
        $golongan = DB::table('golongan')
            ->select('*')
            ->where('id_admin', Auth::user()->id)
            ->latest()
            ->get();
        return response([
            'data' => $golongan,
            'message' => 'get data berhasil',
            'status' => true
        ]);
    }
    public function searchgolongan($key)
    {
            $result = DB::table('golongan')
                ->select('*')
                ->where('golongan.id_admin', Auth::user()->id)
                ->where('golongan', 'like', '%' . $key . '%')
                ->orWhere('pendidikan', 'like', '%' . $key . '%')
                ->where('golongan.id_admin', Auth::user()->id)
                ->latest()
                ->get();
            return $result;
    }

    public function golonganpegawai()
    {
        $golongan = DB::table('golongan')
            ->select('*')
            ->where('id_admin', Auth::user()->id_admin)
            ->get();
        return response([
            'data' => $golongan,
            'message' => 'get data berhasil',
            'status' => true
        ]);
    }

    // add book
    public function tambahgolongan(Request $request)
    {
        $golongan = Golongan::create([
            'id_admin' => Auth::user()->id,
            'golongan' => $request->golongan,
            'pendidikan' => $request->pendidikan,
            'nominal' => $request->nominal,
        ]);
        $golongan->save();
        $success = true;
        return response()->json([
            'message' =>'Jabatan successfully added',
            'success' => $success

            ]);
    }

    // edit book

    // update book
    public function updategolongan(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'golongan' => 'required',
            'pendidikan' => 'required',
            'nominal' => 'required',
         ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            DB::table('golongan')->where('id', $request->id)->update([
                'golongan' => $request->golongan,
                'pendidikan' => $request->pendidikan,
                'nominal' => $request->nominal,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Update Jabatan Berhasil!',
            ]);
        }
    }
    public function hapusgolongan(Request $request, $id)
    {
        $data = Golongan::findOrFail($id);
        $data->delete();
        return response()->json([
            'success' => true,
            'message' => 'Hapus data berhasil'
        ]);
    }
}
