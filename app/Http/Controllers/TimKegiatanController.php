<?php

namespace App\Http\Controllers;

use App\Models\TahunKegiatan;
use App\Models\TimKegiatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TimKegiatanController extends Controller
{
    function showDataTim()
    {
        if(Auth::user()->role === 'Admin') {

            $data_tahun_kegiatan = TahunKegiatan::where('tahun',request('tahun'))->first();
            $data_tim_kegiatan = $data_tahun_kegiatan->tim_kegiatan;
            return view('admin.data_tim_kegiatan')
                ->with('data_tim_kegiatan',$data_tim_kegiatan);

        }elseif(Auth::user()->role === 'Ketua') {
            
            $data_tahun_kegiatan = TahunKegiatan::where('tahun',request('tahun'))->first();
            $data_tim_kegiatan = $data_tahun_kegiatan->tim_kegiatan;
            return view('ketua.data_tim_kegiatan')
                ->with('data_tim_kegiatan',$data_tim_kegiatan);

        }elseif(Auth::user()->role === 'Anggota') {
            
            $data_tahun_kegiatan = TahunKegiatan::where('tahun',request('tahun'))->first();
            $data_tim_kegiatan = $data_tahun_kegiatan->tim_kegiatan;
            return view('anggota.data_tim_kegiatan')
                ->with('data_tim_kegiatan',$data_tim_kegiatan);

        }
    }

    function showDetailTim()
    {
        return view('admin.detail_tim_kegiatan');
    }

    function createDataTim(Request $request)
    {
        $messages = [
            'nama_tim.required' => 'Nama tim tidak dapat kosong.',
            'nama_tim.max' => 'Nama tim maksimal 25 karakter.',
            'nama_tim.unique' => 'Nama tim telah ditambahkan pada database.',
        ];

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->error('<b>Error!</b><br>Data gagal ditambahkan.');

        Validator::make($request->input(), [
            'nama_tim' => 'required|max:25|unique:tim_kegiatan,nama', 
        ],$messages)->validateWithBag('tambah_data');

        $inputeddata = [
            'nama' => $request->input('nama_tim'),
            'id_tahun_kegiatan' => TahunKegiatan::where('tahun',request('tahun'))->first()->id,
        ];

        TimKegiatan::create($inputeddata);

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->success('<b>Berhasil!</b><br>Data berhasil ditambahkan.');

        return redirect(route('admin.show.data_tim_kegiatan', ['tahun' => request('tahun')]));
    }

    function editDataTim(TimKegiatan $TimKegiatan,Request $request)
    {
        $messages = [
            'nama_tim.required' => 'Nama tim tidak dapat kosong.',
            'nama_tim.max' => 'Nama tim maksimal 25 karakter.',
            'nama_tim.unique' => 'Nama tim telah ditambahkan pada database.',
        ];

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->error('<b>Error!</b><br>Data gagal diubah.');

        Validator::make($request->input(), [
            'nama_tim' => ['required','max:25',Rule::unique('tim_kegiatan','nama')->ignore($TimKegiatan->id)], 
        ],$messages)->validateWithBag($TimKegiatan->id);

        $TimKegiatan->update([
            'nama' => $request->input('nama_tim'),
        ]);

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->success('<b>Berhasil!</b><br>Data berhasil diubah.');

        return redirect(route('admin.show.data_tim_kegiatan', ['tahun' => $TimKegiatan->tahun_kegiatan->tahun]));
    }

    function deleteDataTim(TimKegiatan $TimKegiatan)
    {
        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->error('<b>Error!</b><br>Data gagal dihapus.');

        TimKegiatan::destroy($TimKegiatan->id);

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->success('<b>Berhasil!</b><br>Data berhasil dihapus.');

        return redirect(route('admin.show.data_tim_kegiatan', ['tahun' => $TimKegiatan->tahun_kegiatan->tahun]));
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

    function deleteAnggotaTim(User $user)
    {
        User::destroy($user->id);
    }
}
