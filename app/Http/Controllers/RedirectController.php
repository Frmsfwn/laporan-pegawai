<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
    function dashboard()
    {
        return view('admin.dashboard');
    }

    function homepage()
    {
        if(Auth::user()->role === 'Ketua') {
            return view('ketua.homepage');
        }elseif(Auth::user()->role === 'Anggota') {
            return view('anggota.homepage');
        }
    }
}
