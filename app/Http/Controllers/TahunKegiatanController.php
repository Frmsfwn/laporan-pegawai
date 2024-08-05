<?php

namespace App\Http\Controllers;

use App\Models\TahunKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TahunKegiatanController extends Controller
{
    function showDataTahun()
    {
        if(Auth::user()->role === 'Admin') {
            return view('admin.data_tahun_kegiatan');
        }elseif(Auth::user()->role === 'Ketua') {
            return view('ketua.data_tahun_kegiatan');
        }elseif(Auth::user()->role === 'Anggota') {
            return view('anggota.data_tahun_kegiatan');
        }
    }

    function createDataTahun(Request $request)
    {
        $messages = [
            'tahun.required' => 'Tahun tidak dapat kosong.',
            'tahun.max_digits' => 'Tahun tidak valid.',
            'tahun.alpha_dash' => 'Tahun tidak valid.',
            'nama.required' => 'Nama kegiatan tidak dapat kosong.',
            'nama.max' => 'Nama kegiatan maksimal berisi 50 karakter.',
            'nama.alpha_numeric' => 'Nama kegiatan tidak valid.', 
        ];

        Validator::make($request->input(), [
            'tahun' => 'required|max_digits:4|numeric',
            'nama' => 'required|max:50|alpha_numeric', 
        ],$messages)->validate();

        $inputeddata = [
            'tahun' => $request->input('tahun'),
            'nama' => $request->input('nama'),
        ];

        TahunKegiatan::create($inputeddata);
    }

    function editDataTahun(TahunKegiatan $tahunKegiatan,Request $request)
    {
        $messages = [
            'tahun.required' => 'Tahun tidak dapat kosong.',
            'tahun.max_digits' => 'Tahun tidak valid.',
            'tahun.alpha_dash' => 'Tahun tidak valid.',
            'nama.required' => 'Nama kegiatan tidak dapat kosong.',
            'nama.max' => 'Nama kegiatan maksimal berisi 50 karakter.',
            'nama.alpha_numeric' => 'Nama kegiatan tidak valid.', 
        ];

        Validator::make($request->input(), [
            'tahun' => 'required|max_digits:4|numeric',
            'nama' => 'required|max:50|alpha_numeric', 
        ],$messages)->validate();

        $tahunKegiatan->update([
            'tahun' => $request->input('tahun'),
            'nama' => $request->input('nama'),
        ]);
    }

    function deleteDataTahun(TahunKegiatan $tahunKegiatan)
    {
        TahunKegiatan::destroy($tahunKegiatan->id);
    }
}
