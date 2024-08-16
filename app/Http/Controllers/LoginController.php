<?php

namespace App\Http\Controllers;

use App\Models\TahunKegiatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    function show()
    {
        return view('login.login');
    }

    function login(Request $request)
    {
        $messages = [
            'username.required' => 'Username tidak dapat kosong.',
            'username.max' => 'Kolom username maksimal berisi 15 karakter.',
            'username.alpha_dash' => 'Kolom username tidak valid.',
            'username.lowercase' => 'Kolom username hanya dapat berisi huruf kecil.',
            'password.required' => 'Kolom password tidak dapat kosong.',
            'password.max' => 'Kolom password maksimal berisi 50 karakter.',
        ];

        Validator::make($request->input(), [
            'username' => 'required|max:15|alpha_dash:ascii|lowercase',
            'password' => 'required|max:50', 
        ],$messages)->validate();

        $inputeddata = [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ];

        if(Auth::attempt($inputeddata)) {
            if (Auth::user()->role === 'Admin') {

                flash()
                ->killer(true)
                ->layout('bottomRight')
                ->timeout(3000)
                ->success('<b>Berhasil!</b><br>Proses login berhasil.');

                return redirect(route('admin.homepage'));

            }elseif (Auth::user()->role === 'Manajemen') {

                flash()
                ->killer(true)
                ->layout('bottomRight')
                ->timeout(3000)
                ->success('<b>Berhasil!</b><br>Proses login berhasil.');

                return redirect(route('manajemen.homepage'));

            }elseif (Auth::user()->role === 'Ketua') {
                
                flash()
                ->killer(true)
                ->layout('bottomRight')
                ->timeout(3000)
                ->success('<b>Berhasil!</b><br>Proses login berhasil.');

                return redirect(route('ketua.homepage'));

            }elseif (Auth::user()->role === 'Anggota') {
                
                flash()
                ->killer(true)
                ->layout('bottomRight')
                ->timeout(3000)
                ->success('<b>Berhasil!</b><br>Proses login berhasil.');

                return redirect(route('anggota.homepage'));

            }
        }else {
            flash()
            ->killer(true)
            ->layout('bottomRight')
            ->timeout(3000)
            ->error('<b>Kesalahan!</b><br>Proses login gagal.');

            return redirect(route('login'))
                ->withErrors([
                    'username' => 'Username atau Password tidak sesuai.',
                    'password' => 'Username atau Password tidak sesuai.',
                ])->withInput();
        }
    }

    function Homepage()
    {
        if(Auth::user()->role === 'Admin') {

            $data_tahun_kegiatan = TahunKegiatan::orderBy('updated_at','desc')->get();
            return view('admin.homepage')
                ->with('data_tahun_kegiatan',$data_tahun_kegiatan);

        }elseif(Auth::user()->role === 'Manajemen') {

            return view('manajemen.homepage');

        }elseif(Auth::user()->role === 'Ketua') {

            $data_tim_kegiatan = Auth::user()->anggota_tim->tim_kegiatan;
            return view('ketua.homepage')
                ->with('data_tim_kegiatan',$data_tim_kegiatan);

        }elseif(Auth::user()->role === 'Anggota') {
            
            $data_tim_kegiatan = Auth::user()->anggota_tim->tim_kegiatan;
            return view('anggota.homepage')
                ->with('data_tim_kegiatan',$data_tim_kegiatan);

        }
    }

    function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }
}
