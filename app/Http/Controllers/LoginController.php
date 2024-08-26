<?php

namespace App\Http\Controllers;

use App\Models\LaporanKegiatan;
use App\Models\TahunKegiatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

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
            'username.max' => 'Username maksimal berisi 15 karakter.',
            'password.required' => 'Password tidak dapat kosong.',
            'password.max' => 'Password maksimal berisi 50 karakter.',
        ];

        Validator::make($request->input(), [
            'username' => 'required|max:15',
            'password' => 'required|max:50', 
        ],$messages)->validateWithBag('login');

        if (User::where('username','=',$request->input('username'))->exists()) {

            $inputeddata = [
                'username' => $request->input('username'),
                'password' => $request->input('password'),
            ];
    
            if (Auth::attempt($inputeddata)) {
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
                        'password' => 'Password tidak sesuai.',
                    ],'login')
                    ->onlyInput('username');
            }
        }else {
            flash()
            ->killer(true)
            ->layout('bottomRight')
            ->timeout(3000)
            ->error('<b>Kesalahan!</b><br>Proses login gagal.');

            return redirect(route('login'))
                ->withErrors([
                    'username' => "Akun dengan username; $request->username tidak ditemukan.",
                ],'login')
                ->onlyInput('username');
        }
    }

    function editPassword()
    {
        return view('main.ubah_password');
    }

    function updatePassword(User $User, Request $request)
    {
        $messages = [
            'password_lama.required' => 'Kolom password tidak dapat kosong.',
            'password_lama.max' => 'Kolom password maksimal berisi 50 karakter.',
            'password_lama.current_password' => 'Password tidak sesuai',
            'password_baru.min' => 'Password minimal berisi 8 karakter terdiri dari; huruf besar dan huruf kecil, angka, dan simbol.',
            'password_baru.max' => 'Password maksimal berisi 25 terdiri dari; huruf besar dan huruf kecil, angka, dan simbol.',
            'password_baru.letters' => 'Password minimal berisi 8 karakter terdiri dari; huruf besar dan huruf kecil, angka, dan simbol.',
            'password_baru.mixedCase' => 'Password minimal berisi 8 karakter terdiri dari; huruf besar dan huruf kecil, angka, dan simbol.',
            'password_baru.numbers' => 'Password minimal berisi 8 karakter terdiri dari; huruf besar dan huruf kecil, angka, dan simbol.',
            'password_baru.symbols' => 'Password minimal berisi 8 karakter terdiri dari; huruf besar dan huruf kecil, angka, dan simbol.',
            'password_baru.required' => 'Password tidak dapat kosong.',
            'konfirmasi_password.required' => 'Kolom password tidak dapat kosong.',
            'konfirmasi_password.max' => 'Kolom password maksimal berisi 50 karakter.',
            'konfirmasi_password.same' => 'Password tidak sesuai',
        ];

        Validator::make($request->input(), [
            'password_lama' => 'required|max:50|current_password:web',
            'password_baru' => [
                Password::min(8)
                    ->max(25)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->required()
            ],
            'konfirmasi_password' => 'required|max:50|same:password_baru',
        ],$messages)->validateWithBag('ubah_password');

        $User->update([ 'password' => bcrypt($request->input('konfirmasi_password')) ]);

        Auth::logout();
        return redirect(route('login'));
    }

    function Homepage(Request $request)
    {
        if(Auth::user()->role === 'Admin') {

            $data_tahun_kegiatan = 
            TahunKegiatan::orderBy('updated_at','desc')
                ->orderBy('created_at','desc')    
                ->get();

            $keyword = $request->input('keyword');
            if ($keyword) {
                $data_tahun_kegiatan = 
                TahunKegiatan::whereAny([
                    'tahun',
                    'nama',
                ],'LIKE',"%$keyword%")
                    ->orderBy('updated_at', 'DESC')
                    ->orderBy('created_at', 'DESC')
                    ->get();
            }    

            return view('admin.homepage')
                ->with('data_tahun_kegiatan',$data_tahun_kegiatan)
                ->with('keyword',$keyword);

        }elseif(Auth::user()->role === 'Manajemen') {

            $data_laporan_kegiatan_terbaru = 
            LaporanKegiatan::where('status_laporan',null)
                ->orderBy('updated_at','desc')
                ->orderBy('created_at','desc')
                ->get();
            $data_laporan_kegiatan_diterima = 
            LaporanKegiatan::where('status_laporan','Diterima')
                ->orderBy('updated_at','desc')
                ->orderBy('created_at','desc')
                ->get();
            $data_laporan_kegiatan_ditolak = 
            LaporanKegiatan::where('status_laporan','Ditolak')
                ->orderBy('updated_at','desc')
                ->orderBy('created_at','desc')
                ->get();

            return view('manajemen.homepage')
                ->with('data_laporan_kegiatan_terbaru',$data_laporan_kegiatan_terbaru)
                ->with('data_laporan_kegiatan_diterima',$data_laporan_kegiatan_diterima)
                ->with('data_laporan_kegiatan_ditolak',$data_laporan_kegiatan_ditolak);

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
