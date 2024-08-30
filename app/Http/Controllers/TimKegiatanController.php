<?php

namespace App\Http\Controllers;

use App\Models\AnggotaTim;
use App\Models\LaporanKegiatan;
use App\Models\Notifikasi;
use App\Models\TahunKegiatan;
use App\Models\TimKegiatan;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class TimKegiatanController extends Controller
{
    function showDataTim(Request $request)
    {
        if(Auth::user()->role === 'Admin') {

            $data_tahun_kegiatan = TahunKegiatan::where('tahun',request('tahun'))->first();
            $data_tim_kegiatan = TimKegiatan::where('id_tahun_kegiatan',$data_tahun_kegiatan->id)->get();

            $keyword = $request->input('keyword');
            if ($keyword) {
                $data_tim_kegiatan = collect($data_tim_kegiatan)->filter(function ($item) use ($keyword) {
                    return false !== stristr($item->nama, $keyword);
                });
                $data_tim_kegiatan
                    ->sortByDesc('updated_at');

                return view('admin.data_tim')
                    ->with('data_tahun_kegiatan',$data_tahun_kegiatan)
                    ->with('data_tim_kegiatan',$data_tim_kegiatan)
                    ->with('keyword',$keyword);    
            }    

            return view('admin.data_tim')
                ->with('data_tahun_kegiatan',$data_tahun_kegiatan)
                ->with('data_tim_kegiatan',$data_tim_kegiatan)
                ->with('keyword',$keyword);

        }elseif(Auth::user()->role === 'Manajemen') {

            $data_tahun_kegiatan = TahunKegiatan::where('tahun',request('tahun'))->first();
            $data_tim_kegiatan = TimKegiatan::where('id_tahun_kegiatan',$data_tahun_kegiatan->id)->get();

            $keyword = $request->input('keyword');
            if ($keyword) {
                $data_tim_kegiatan = collect($data_tim_kegiatan)->filter(function ($item) use ($keyword) {
                    return false !== stristr($item->nama, $keyword);
                });
                $data_tim_kegiatan
                    ->sortByDesc('updated_at');

                return view('manajemen.data_tim')
                    ->with('data_tahun_kegiatan',$data_tahun_kegiatan)
                    ->with('data_tim_kegiatan',$data_tim_kegiatan)
                    ->with('keyword',$keyword);    
            }    

            return view('manajemen.data_tim')
                ->with('data_tahun_kegiatan',$data_tahun_kegiatan)
                ->with('data_tim_kegiatan',$data_tim_kegiatan)
                ->with('keyword',$keyword);

        }
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

        return redirect(route('admin.show.data_tim', ['tahun' => request('tahun')]));
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

        return redirect(route('admin.show.data_tim', ['tahun' => $TimKegiatan->tahun_kegiatan->tahun]));
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

        return redirect(route('admin.show.data_tim', ['tahun' => $TimKegiatan->tahun_kegiatan->tahun]));
    }

    function showDataAnggota(Request $request)
    {
        if(Auth::user()->role === 'Admin') {

            $data_tahun_kegiatan = TahunKegiatan::where('tahun',request('tahun'))->first();
            $data_tim_kegiatan = TimKegiatan::where('id_tahun_kegiatan',$data_tahun_kegiatan->id)->where('nama',request('nama'))->first();
            $data_anggota_tim = 
                User::whereHas('anggota_tim', function (Builder $query) use ($data_tim_kegiatan) {
                    $query->whereRelation('tim_kegiatan', 'id', '=', $data_tim_kegiatan->id);
                })
                ->orderBy('updated_at','desc')
                ->orderBy('created_at','desc')
                ->get();
            $data_ketua_tim = 
                AnggotaTim::where('id_tim_kegiatan',$data_tim_kegiatan->id)
                    ->whereHas('user', function (Builder $query) {
                        $query->where('role', '=', 'Ketua');
                    })->get();

            $keyword = $request->input('keyword');
            if ($keyword) {
                $data_anggota_tim =
                    AnggotaTim::where('id_tim_kegiatan',$data_tim_kegiatan->id)
                        ->whereHas('user', function (Builder $query) use ($keyword) {
                            $query->whereAny([
                                    'nip',
                                    'nama',
                                    'username',
                                    'role',
                                ],'like', "%$keyword%");
                        })
                        ->orderBy('updated_at','desc')
                        ->orderBy('created_at','desc')
                        ->get();
            }    

            return view('admin.data_anggota', ['tahun' => request('tahun'), 'nama' => request('nama')])
                ->with('keyword',$keyword)
                ->with('data_tim_kegiatan',$data_tim_kegiatan)
                ->with('data_anggota_tim',$data_anggota_tim)
                ->with('data_ketua_tim',$data_ketua_tim);
        
        }elseif(Auth::user()->role === 'Ketua') {
            
            $data_tahun_kegiatan = TahunKegiatan::where('tahun',request('tahun'))->first();
            $data_tim_kegiatan = $data_tahun_kegiatan->tim_kegiatan->where('nama',request('nama'))->first();
            return view('ketua.detail_tim_kegiatan', ['tahun' => request('tahun'), 'nama' => request('nama')])
                ->with('data_tim_kegiatan',$data_tim_kegiatan);

        }elseif(Auth::user()->role === 'Anggota') {
            
            $data_tahun_kegiatan = TahunKegiatan::where('tahun',request('tahun'))->first();
            $data_tim_kegiatan = $data_tahun_kegiatan->tim_kegiatan->where('nama',request('nama'))->first();
            return view('anggota.detail_tim_kegiatan', ['tahun' => request('tahun'), 'nama' => request('nama')])
                ->with('data_tim_kegiatan',$data_tim_kegiatan);

        }    
    }

    function createDataAnggota(Request $request)
    {
        $messages = [
            'nip_anggota.required' => 'NIP tidak dapat kosong.',
            'nip_anggota.max_digits' => 'NIP maksimal 25 angka.',
            'nip_anggota.numeric' => 'NIP tidak valid.',
            'nip_anggota.unique' => 'NIP telah ditambahkan pada database.',
            'nama_anggota.required' => 'Nama tidak dapat kosong.',
            'nama_anggota.max' => 'Nama maksimal 25 karakter.',
            'username_anggota.required' => 'Username tidak dapat kosong.',
            'username_anggota.max:25' => 'Username maksimal 25 karakter.',
            'username_anggota.unique' => 'Username telah ditambahkan pada database.',
            'password_anggota.min' => 'Password minimal berisi 8 karakter terdiri dari; huruf besar dan huruf kecil, angka, dan simbol.',
            'password_anggota.max' => 'Password maksimal berisi 25 terdiri dari; huruf besar dan huruf kecil, angka, dan simbol.',
            'password_anggota.letters' => 'Password minimal berisi 8 karakter terdiri dari; huruf besar dan huruf kecil, angka, dan simbol.',
            'password_anggota.mixedCase' => 'Password minimal berisi 8 karakter terdiri dari; huruf besar dan huruf kecil, angka, dan simbol.',
            'password_anggota.numbers' => 'Password minimal berisi 8 karakter terdiri dari; huruf besar dan huruf kecil, angka, dan simbol.',
            'password_anggota.symbols' => 'Password minimal berisi 8 karakter terdiri dari; huruf besar dan huruf kecil, angka, dan simbol.',
            'password_anggota.required' => 'Password tidak dapat kosong.',
            'role_anggota.required' => 'Role tidak dapat kosong.',
        ];

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->error('<b>Error!</b><br>Data gagal ditambahkan.');

        Validator::make($request->input(), [
            'nip_anggota' => 'required|max_digits:25|numeric|unique:users,nip',
            'nama_anggota' => 'required|max:25',
            'username_anggota' => 'required|max:25|unique:users,username',
            'password_anggota' => [
                Password::min(8)
                    ->max(25)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->required()
            ],
            'role_anggota' => 'required|in:Anggota,Ketua',
        ],$messages)->validateWithBag('tambah_data');

        $inputeddata = [
            'nip' => $request->input('nip_anggota'),
            'nama' => $request->input('nama_anggota'),
            'username' => $request->input('username_anggota'),
            'password' => bcrypt($request->input('password_anggota')),
            'role' => $request->input('role_anggota'),
        ];

        $data_tim_kegiatan = TimKegiatan::where('nama',request('nama'))->first();
        $user = User::create($inputeddata);
        $anggota_tim = new AnggotaTim;
        $anggota_tim->id_tim_kegiatan = $data_tim_kegiatan->id;
        $anggota_tim->id_anggota = $user->id;
        $anggota_tim->save();
        
        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->success('<b>Berhasil!</b><br>Data berhasil ditambahkan.');

        return redirect(route('admin.show.data_anggota', ['tahun' => request('tahun'), 'nama' => request('nama')]));
    }

    function editDataAnggota(User $AnggotaTim,Request $request)
    {
        $messages = [
            'nip_anggota.required' => 'NIP tidak dapat kosong.',
            'nip_anggota.max_digits' => 'NIP maksimal 25 angka.',
            'nip_anggota.numeric' => 'NIP tidak valid.',
            'nip_anggota.unique' => 'NIP telah ditambahkan pada database.',
            'nama_anggota.required' => 'Nama tidak dapat kosong.',
            'nama_anggota.max' => 'Nama maksimal 25 karakter.',
            'username_anggota.required' => 'Username tidak dapat kosong.',
            'username_anggota.max:25' => 'Username maksimal 25 karakter.',
            'username_anggota.unique' => 'Username telah ditambahkan pada databsse.',
            'password_anggota.min' => 'Password minimal berisi 8 karakter terdiri dari; huruf besar dan huruf kecil, angka, dan simbol.',
            'password_anggota.max' => 'Password maksimal berisi 25 terdiri dari; huruf besar dan huruf kecil, angka, dan simbol.',
            'password_anggota.letters' => 'Password minimal berisi 8 karakter terdiri dari; huruf besar dan huruf kecil, angka, dan simbol.',
            'password_anggota.mixedCase' => 'Password minimal berisi 8 karakter terdiri dari; huruf besar dan huruf kecil, angka, dan simbol.',
            'password_anggota.numbers' => 'Password minimal berisi 8 karakter terdiri dari; huruf besar dan huruf kecil, angka, dan simbol.',
            'password_anggota.symbols' => 'Password minimal berisi 8 karakter terdiri dari; huruf besar dan huruf kecil, angka, dan simbol.',
            'password_anggota.required' => 'Password tidak dapat kosong.',
            'role_anggota.required' => 'Role tidak dapat kosong.',
        ];

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->error('<b>Kesalahan!</b><br>Data gagal diubah.');

        Validator::make($request->input(), [
            'nip_anggota' => ['required','max_digits:25','numeric',Rule::unique('users','nip')->ignore($AnggotaTim->id)],
            'nama_anggota' => 'required|max:25',
            'username_anggota' => ['required','max:25',Rule::unique('users','username')->ignore($AnggotaTim->id)],
            'password_anggota' => [
                Password::min(8)
                    ->max(25)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->required()
            ],
            'role_anggota' => 'required|in:Anggota,Ketua',
        ],$messages)->validateWithBag($AnggotaTim->id);

        $AnggotaTim->update([
            'nip' => $request->input('nip_anggota'),
            'nama' => $request->input('nama_anggota'),
            'username' => $request->input('username_anggota'),
            'password' => bcrypt($request->input('password_anggota')),
            'role' => $request->input('role_anggota'),
        ]);

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->success('<b>Berhasil!</b><br>Data berhasil diubah.');

        $data_tahun_kegiatan = $AnggotaTim->anggota_tim->tim_kegiatan->tahun_kegiatan->tahun;
        $data_tim_kegiatan = $AnggotaTim->anggota_tim->tim_kegiatan->nama;

        return redirect(route('admin.show.data_anggota', ['tahun' => $data_tahun_kegiatan, 'nama' => $data_tim_kegiatan]));
    }

    function deleteDataAnggota(User $AnggotaTim)
    {
        $data_tahun_kegiatan = $AnggotaTim->anggota_tim->tim_kegiatan->tahun_kegiatan->tahun;
        $data_tim_kegiatan = $AnggotaTim->anggota_tim->tim_kegiatan->nama;

        User::destroy($AnggotaTim->id);

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->success('<b>Berhasil!</b><br>Data berhasil dihapus.');

        return redirect(route('admin.show.data_anggota', ['tahun' => $data_tahun_kegiatan, 'nama' => $data_tim_kegiatan]));
    }

    function showDataLaporan(Request $request)
    {
        if(Auth::user()->role === 'Admin') {

            $keyword = $request->input('keyword');
            $data_tahun_kegiatan = TahunKegiatan::where('tahun',request('tahun'))->first();
            $data_tim_kegiatan = TimKegiatan::where('id_tahun_kegiatan',$data_tahun_kegiatan->id)->where('nama',request('nama'))->first();
            $data_laporan_kegiatan = LaporanKegiatan::where('id_tim_kegiatan',$data_tim_kegiatan->id)->get();

            return view('admin.data_laporan')
                ->with('keyword',$keyword)
                ->with('data_tim_kegiatan',$data_tim_kegiatan)
                ->with('data_laporan_kegiatan',$data_laporan_kegiatan);

        }elseif(Auth::user()->role === 'Manajemen') {

            $keyword = $request->input('keyword');
            $data_tahun_kegiatan = TahunKegiatan::where('tahun',request('tahun'))->first();
            $data_tim_kegiatan = TimKegiatan::where('id_tahun_kegiatan',$data_tahun_kegiatan->id)->where('nama',request('nama'))->first();
            $data_laporan_kegiatan = LaporanKegiatan::where('id_tim_kegiatan',$data_tim_kegiatan->id)->get();
    
            return view('manajemen.data_laporan')
                ->with('keyword',$keyword)
                ->with('data_tim_kegiatan',$data_tim_kegiatan)
                ->with('data_laporan_kegiatan',$data_laporan_kegiatan);
    
        }
    }

    function createLaporanKegiatan(Request $request)
    {
        $messages = [
            'judul_laporan.required' => 'Judul laporan tidak dapat kosong.',
            'judul_laporan.max' => 'Judul laporan maksimal 50 karakter.',
            'judul_laporan.unique' => 'Judul laporan telah ditambahkan pada database.',
            'informasi_kegiatan.required' => 'Informasi kegiatan tidak dapat kosong.',
            'informasi_kegiatan.max' => 'Informasi kegiatan maksimal 100 karakter.',
            'lampiran_kegiatan.required' => 'Lampiran kegiatan tidak dapat kosong.',
            'lampiran_kegiatan.max' => 'Ukuran maksimal file adalah 100MB.',
            'lampiran_kegiatan.mimes' => 'File tidak valid.',
            'lampiran_kegiatan.extensions' => 'File tidak valid.',
        ];

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->error('<b>Error!</b><br>Data laporan kegiatan gagal ditambahkan.');

        Validator::make($request->all(), [
            'judul_laporan' => 'required|max:50|unique:laporan_kegiatan,judul_laporan',
            'informasi_kegiatan' => 'required|max:100',
            'lampiran_kegiatan' => 'required|file|max:102400|mimes:doc,docx,ppt,pptx,xls,xlsx,odt,odf,ods,odp,xml,pdf,one,rtf,txt,csv,html,htm,rar,zip,7zip,jpg,jpeg,png,heif,heic|extensions:doc,docx,ppt,pptx,xls,xlsx,odt,odf,ods,odp,xml,pdf,one,rtf,txt,csv,html,htm,rar,zip,7zip,jpg,jpeg,png,heif,heic',
        ],$messages)->validateWithBag('tambah_data');

        $file = $request->file('lampiran_kegiatan');
        $fileName = time().'.'.$file->extension();
        $file->move(public_path('lampiran'), $fileName);
        $filePath = 'lampiran/' . $fileName;

        $data = [
            'id_tim_kegiatan' => TimKegiatan::where('nama',request('nama'))->first()->id,
            'id_tahun_kegiatan' => TahunKegiatan::where('tahun',request('tahun'))->first()->id,
            'judul_laporan' => $request->input('judul_laporan'),
            'nama_tim_kegiatan' => request('nama'),
            'informasi_kegiatan' => $request->input('informasi_kegiatan'),
            'lampiran' => $filePath,
        ];

        LaporanKegiatan::create($data);

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->success('<b>Berhasil!</b><br>Data laporan kegiatan berhasil ditambahkan.');

        return redirect(route('ketua.show.detail_tim_kegiatan', ['tahun' => request('tahun'), 'nama' => request('nama')]));
    }

    function editLaporanKegiatan(LaporanKegiatan $LaporanKegiatan, Request $request)
    {
        $messages = [
            'judul_laporan.required' => 'Judul laporan tidak dapat kosong.',
            'judul_laporan.max' => 'Judul laporan maksimal 50 karakter.',
            'judul_laporan.unique' => 'Judul laporan telah ditambahkan pada database.',
            'informasi_kegiatan.required' => 'Informasi kegiatan tidak dapat kosong.',
            'informasi_kegiatan.max' => 'Informasi kegiatan maksimal 100 karakter.',
            'lampiran_kegiatan.max' => 'Ukuran maksimal file adalah 100MB.',
            'lampiran_kegiatan.mimes' => 'File tidak valid.',
            'lampiran_kegiatan.extensions' => 'File tidak valid.',
        ];

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->error('<b>Error!</b><br>Data laporan kegiatan gagal diubah.');

        Validator::make($request->all(), [
            'judul_laporan' => ['required','max:50',Rule::unique('laporan_kegiatan','judul_laporan')->ignore($LaporanKegiatan->id)],
            'informasi_kegiatan' => 'required|max:100',
            'lampiran_kegiatan' => 'file|max:102400|mimes:doc,docx,ppt,pptx,xls,xlsx,odt,odf,ods,odp,xml,pdf,one,rtf,txt,csv,html,htm,rar,zip,7zip,jpg,jpeg,png,heif,heic|extensions:doc,docx,ppt,pptx,xls,xlsx,odt,odf,ods,odp,xml,pdf,one,rtf,txt,csv,html,htm,rar,zip,7zip,jpg,jpeg,png,heif,heic',
        ],$messages)->validateWithBag($LaporanKegiatan->id);

        if ($request->hasFile('lampiran_kegiatan')) {
            if (File::exists($LaporanKegiatan->lampiran))
            {
                File::delete($LaporanKegiatan->lampiran);
            }            
            $newFile = $request->file('lampiran_kegiatan');
            $fileName = time().'.'.$newFile->extension();
            $newFile->move(public_path('lampiran'), $fileName);
            $filePath = 'lampiran/' . $fileName;

            $LaporanKegiatan->update([
                'lampiran' => $filePath
            ]);
        }

        $LaporanKegiatan->update([
            'judul_laporan' => $request->input('judul_laporan'),
            'nama_tim_kegiatan' => $LaporanKegiatan->tim_kegiatan->nama,
            'informasi_kegiatan' => $request->input('informasi_kegiatan'),
        ]);

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->success('<b>Berhasil!</b><br>Data laporan kegiatan berhasil diubah.');

        if(Auth::user()->role === 'Ketua') {
            return redirect(route('ketua.show.detail_tim_kegiatan', ['tahun' => $LaporanKegiatan->tahun_kegiatan->tahun, 'nama' => $LaporanKegiatan->tim_kegiatan->nama]));
        }elseif(Auth::user()->role === 'Anggota') {
            return redirect(route('anggota.show.detail_tim_kegiatan', ['tahun' => $LaporanKegiatan->tahun_kegiatan->tahun, 'nama' => $LaporanKegiatan->tim_kegiatan->nama]));
        }
    }

    function deleteLaporanKegiatan(LaporanKegiatan $LaporanKegiatan)
    {
        $data_tahun_kegiatan = $LaporanKegiatan->tahun_kegiatan->tahun;
        $data_tim_kegiatan = $LaporanKegiatan->tim_kegiatan->nama;

        LaporanKegiatan::destroy($LaporanKegiatan->id);

        if (File::exists(public_path($LaporanKegiatan->lampiran))) {
            File::delete(public_path($LaporanKegiatan->lampiran));
        }

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->success('<b>Berhasil!</b><br>Data laporan kegiatan berhasil dihapus.');

        return redirect(route('ketua.show.detail_tim_kegiatan', ['tahun' => $data_tahun_kegiatan, 'nama' => $data_tim_kegiatan]));
    }

    function downloadLaporan(LaporanKegiatan $LaporanKegiatan)
    {
        $path = $LaporanKegiatan->lampiran;

        $_PATH_INFO = pathinfo($LaporanKegiatan->lampiran); 
        $_EXTENSTION = $_PATH_INFO['extension'];

        return response()->download($path, "$LaporanKegiatan->judul_laporan.$_EXTENSTION");
    }

    function acceptLaporan(LaporanKegiatan $LaporanKegiatan)
    {
        $LaporanKegiatan->update([
            'status_laporan' => 'Diterima',
        ]);

        return redirect(route('manajemen.show.data_laporan', ['tahun' => $LaporanKegiatan->tahun_kegiatan->tahun, 'nama' => $LaporanKegiatan->tim_kegiatan->nama]));
    }

    function declineLaporan(Request $request,LaporanKegiatan $LaporanKegiatan)
    {
        $data_ketua_tim = 
        User::where('role','Ketua')
            ->whereHas('anggota_tim', function (Builder $query) use ($LaporanKegiatan) {
                $query->whereHas('tim_kegiatan', function (Builder $query) use ($LaporanKegiatan) {
                    $query->where('id', '=', $LaporanKegiatan->tim_kegiatan->id);
                });
            })->first();

        $LaporanKegiatan->update([
            'status_laporan' => 'Ditolak',
        ]);
        
        $Notifikasi = new Notifikasi;
        $Notifikasi->id_user = $data_ketua_tim->id;
        $Notifikasi->id_laporan_kegiatan = $LaporanKegiatan->id;
        $Notifikasi->pesan = "Laporan dengan judul: $LaporanKegiatan->judul_laporan ditolak, Alasan: $request->alasan";
        $Notifikasi->save();

        return redirect(route('manajemen.show.data_laporan', ['tahun' => $LaporanKegiatan->tahun_kegiatan->tahun, 'nama' => $LaporanKegiatan->tim_kegiatan->nama]));
    }
}
