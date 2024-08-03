<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TimController extends Controller
{
    function create(Kegiatan $kegiatan,Request $request)
    {
        $messages = [
            'tahun.required' => 'Tahun tidak dapat kosong.',
            'tahun.max_digits' => 'Tahun tidak valid.',
            'tahun.alpha_dash' => 'Tahun tidak valid.',
            'nama.required' => 'Nama kegiatan tidak dapat kosong.',
            'nama.max' => 'Nama kegiatan maksimal berisi 50 karakter.',
            'nama.alpha_numeric' => 'Nama kegiatan tidak valid.', 
        ];

        Validator::make($request->all(), [
            'tahun' => 'required|max_digits:4|numeric',
            'nama' => 'required|max:50|alpha_numeric', 
        ],$messages)->validate();

        $inputeddata = [
            'tahun' => $request->input('tahun'),
            'nama' => $request->input('nama'),
        ];

        Kegiatan::create($inputeddata);
    }

    function edit()
    {

    }
}
