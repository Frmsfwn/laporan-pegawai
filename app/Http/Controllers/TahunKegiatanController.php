<?php

namespace App\Http\Controllers;

use App\Models\TahunKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TahunKegiatanController extends Controller
{
    function showDataTahun()
    {
        if(Auth::user()->role === 'Admin') {

            $data_tahun_kegiatan = TahunKegiatan::all();
            return view('admin.data_tahun_kegiatan')
                ->with('data_tahun_kegiatan',$data_tahun_kegiatan);

        }elseif(Auth::user()->role === 'Ketua') {
            
            $data_tahun_kegiatan = TahunKegiatan::all();
            return view('ketua.data_tahun_kegiatan')
                ->with('data_tahun_kegiatan',$data_tahun_kegiatan);

        }elseif(Auth::user()->role === 'Anggota') {

            $data_tahun_kegiatan = TahunKegiatan::all();
            return view('anggota.data_tahun_kegiatan')
                ->with('data_tahun_kegiatan',$data_tahun_kegiatan);

        }
    }

    function createDataTahun(Request $request)
    {
        $messages = [
            'tahun_kegiatan.required' => 'Tahun tidak dapat kosong.',
            'tahun_kegiatan.unique' => 'Tahun telah ada pada database.',
            'tahun_kegiatan.max_digits' => 'Tahun tidak valid.',
            'tahun_kegiatan.alpha_dash' => 'Tahun tidak valid.',
            'nama_kegiatan.required' => 'Nama kegiatan tidak dapat kosong.',
            'nama_kegiatan.max' => 'Nama kegiatan maksimal berisi 50 karakter.',
            'nama_kegiatan.alpha_num' => 'Nama kegiatan tidak valid.', 
        ];

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->error('<b>Error!</b><br>Data gagal ditambahkan.');

        Validator::make($request->input(), [
            'tahun_kegiatan' => 'required|unique:tahun_kegiatan,tahun|max_digits:4|numeric',
            'nama_kegiatan' => 'required|max:50|alpha_num', 
        ],$messages)->validateWithBag('tambah_data');

        $inputeddata = [
            'tahun' => $request->input('tahun_kegiatan'),
            'nama' => $request->input('nama_kegiatan'),
        ];

        TahunKegiatan::create($inputeddata);

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->success('<b>Berhasil!</b><br>Data berhasil ditambahkan.');

        return redirect(route('admin.show.data_tahun_kegiatan'));
    }

    function editDataTahun(TahunKegiatan $TahunKegiatan,Request $request)
    {
        $messages = [
            'tahun_kegiatan.required' => 'Tahun tidak dapat kosong.',
            'tahun_kegiatan.max_digits' => 'Tahun tidak valid.',
            'tahun_kegiatan.numeric' => 'Tahun tidak valid.',
            'tahun_kegiatan.unique' => 'Tahun telah ada pada database.',
            'nama_kegiatan.required' => 'Nama kegiatan tidak dapat kosong.',
            'nama_kegiatan.max' => 'Nama kegiatan maksimal berisi 50 karakter.',
            'nama_kegiatan.alpha_num' => 'Nama kegiatan tidak valid.', 
        ];

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->error('<b>Kesalahan!</b><br>Data gagal diubah.');

        Validator::make($request->input(), [
            'tahun_kegiatan' => ['required','max_digits:4','numeric',Rule::unique('tahun_kegiatan','tahun')->ignore($TahunKegiatan->id)],
            'nama_kegiatan' => 'required|max:50|alpha_num', 
        ],$messages)->validateWithBag($TahunKegiatan->id);

        $TahunKegiatan->update([
            'tahun' => $request->input('tahun_kegiatan'),
            'nama' => $request->input('nama_kegiatan'),
        ]);

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->success('<b>Berhasil!</b><br>Data berhasil diubah.');

        return redirect(route('admin.show.data_tahun_kegiatan'));
    }

    function deleteDataTahun(TahunKegiatan $TahunKegiatan)
    {
        TahunKegiatan::destroy($TahunKegiatan->id);

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->success('<b>Berhasil!</b><br>Data berhasil dihapus.');

        return redirect(route('admin.show.data_tahun_kegiatan'));
    }
}
