<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | Ketua | Homepage</title>

    {{-- Bootstrap --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>
<body>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header align-content-center">
              <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Homepage</h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
              <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="{{ route('ketua.homepage') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                </li>
              </form>
            </div>
          </div>
        </div>
    </nav>

    <div class="container-fluid pt-4 px-4">
        <div class="col-12">
            <div class="bg-light card text-center rounded p-3 mb-3">
                <div class="row align-items-center justify-content-between mb-4">
                    <div class="col-12 col-xxl-10">
                        <h3 class="mb-0">Data Tim Kegiatan</h3>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nama Tim</th>
                                <th scope="col">Jumlah Anggota</th>
                                <th scope="col">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="align-middle">
                                <td>{{ $data_tim_kegiatan->nama }}</td>
                                <td>{{ $data_tim_kegiatan->anggota_tim->count() }}</td>
                                <td>
                                    <a href="{{ route('ketua.show.detail_tim_kegiatan', ['tahun' => $data_tim_kegiatan->tahun_kegiatan->tahun, 'nama' => $data_tim_kegiatan->nama]) }}" class="btn btn-primary">Detail</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
</body>
</html>