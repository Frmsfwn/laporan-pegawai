<?php

namespace App\Http\Controllers;

use App\Models\TimKegiatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TimKegiatanController extends Controller
{
    function showDataTim()
    {
        if(Auth::user()->role === 'Admin') {
            return view('admin.data_tim_kegiatan');
        }elseif(Auth::user()->role === 'Ketua') {
            return view('ketua.data_tim_kegiatan');
        }elseif(Auth::user()->role === 'Anggota') {
            return view('anggota.data_tim_kegiatan');
        }
    }

    function showDetailTim()
    {
        return view('admin.detail_tim_kegiatan');
    }

    function createDataTim(Request $request)
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

        TimKegiatan::create($inputeddata);
    }

    function createAnggotaTim(Request $request)
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

        User::create($inputeddata);
    }

    function editDataTim(TimKegiatan $timKegiatan,Request $request)
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

        $timKegiatan->update([
            'tahun' => $request->input('tahun'),
            'nama' => $request->input('nama'),
        ]);
    }

    function editAnggotaTim(User $user,Request $request)
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

        $user->update([
            'tahun' => $request->input('tahun'),
            'nama' => $request->input('nama'),
        ]);
    }

    function deleteDataTim(TimKegiatan $timKegiatan)
    {
        TimKegiatan::destroy($timKegiatan->id);
    }

    function deleteAnggotaTim(User $user)
    {
        User::destroy($user->id);
    }
}
