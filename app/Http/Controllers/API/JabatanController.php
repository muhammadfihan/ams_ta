<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class JabatanController extends Controller
{
    public function alljabatan()
    {
        $jabatan = DB::table('jabatan')
            ->select('*')
            ->where('id_admin', Auth::user()->id)
            ->get();
        return response([
            'data' => $jabatan,
            'message' => 'get data berhasil',
            'status' => true
        ]);
    }
    public function jabatanpaginate()
    {
        $jabatan = DB::table('jabatan')
            ->select('*')
            ->where('id_admin', Auth::user()->id)
            ->latest()
            ->paginate(10);
        return response([
            'data' => $jabatan,
            'message' => 'get data berhasil',
            'status' => true
        ]);
    }
    public function searchjabatan($key)
    {
            $result = DB::table('jabatan')
                ->select('*')
                ->where('jabatan.id_admin', Auth::user()->id)
                ->where('jabatan', 'like', '%' . $key . '%')
                ->where('jabatan.id_admin', Auth::user()->id)
                ->latest()
                ->paginate(10);

            return $result;

    }
    public function jabatanpegawai()
    {
        $jabatan = DB::table('jabatan')
            ->select('*')
            ->where('id_admin', Auth::user()->id_admin)
            ->get();
        return response([
            'data' => $jabatan,
            'message' => 'get data berhasil',
            'status' => true
        ]);
    }

    // add book
    public function tambahjabatan(Request $request)
    {
        $jabatan = Jabatan::create([
            'id_admin' => Auth::user()->id,
            'jabatan' => $request->jabatan,
            'gaji' => $request->gaji,
        ]);
        $jabatan->save();
        $success = true;
        return response()->json([
            'message' =>'Jabatan successfully added',
            'success' => $success

            ]);
    }

    // edit book
    public function editjabatan($id)
    {
        $jabatan = Jabatan::find($id);
        return response()->json($jabatan);
    }

    // update book
    public function updatejabatan(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'jabatan' => 'required',
            'gaji' => 'required',
         ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            DB::table('jabatan')->where('id', $request->id)->update([
                'jabatan' => $request->jabatan,
                'gaji' => $request->gaji,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Update Jabatan Berhasil!',
            ]);
        }
    }
    public function hapusjabatan(Request $request, $id)
    {
        $data = Jabatan::findOrFail($id);
        $data->delete();
        return response()->json([
            'success' => true,
            'message' => 'Hapus data berhasil'
        ]);
    }
}
