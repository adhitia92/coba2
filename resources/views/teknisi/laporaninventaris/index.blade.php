<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventaris Lab</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets//plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets//dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link href="https://cdn.datatables.net/v/bs4/dt-1.13.6/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/bs4/dt-1.13.6/datatables.min.js"></script>
    <script>
        \
        Carbon\ Carbon::setLocale('id');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <link rel="icon" href="{{ asset('assets/dist/img/logounib.png') }}" type="image/png">
    <script src="https://cdn.rawgit.com/serratus/quaggaJS/0.12.1/dist/quagga.min.js"></script>



</head>
<style>
    .modal-content {
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        background: linear-gradient(to right, #3cb1ff, rgb(58, 153, 247));
        /* Gradien warna latar belakang */
        color: #fff;
    }

    .modal-title {
        font-size: 24px;
        font-weight: bold;
    }

    .modal-label {
        font-size: 18px;
        font-weight: bold;
    }

    .form-control {
        border: 1px solid #3498db;
        border-radius: 8px;
        color: #333;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-control:focus {
        border-color: #2ecc71;
        box-shadow: 0 0 0 0.2rem rgba(46, 204, 113, 0.25);
    }

    .modal-footer {
        background: linear-gradient(to right, #3cb1ff, rgb(58, 153, 247));
        /* Gradien warna latar belakang footer */
        border-top: 1px solid #fff;
    }

    .btn-secondary:hover {
        background-color: #7f8c8d;
        color: #fff;
    }

    .btn-primary:hover {
        background-color: #2ecc71;
        color: #fff;
    }

    .btn-warning:hover {
        background-color: #2ecc71;
        color: #fff;
    }

    .btn-info:hover {
        background-color: #2ecc71;
        color: #fff;
    }

    .btn-danger:hover {
        background-color: #2ecc48;
        color: #fff;
    }

    .modal-content [readonly],
    .modal-content [readonly].form-control {
        background-color: #a1a1a1;
        opacity: 1;
    }

    .visually-disabled {
        cursor: not-allowed;
    }

    .sidebar .nav-item {
        margin-bottom: 5px;
    }
</style>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('home') }}" class="nav-link">Home</a>
                </li>
                {{-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('peminjam.staff') }}" class="nav-link">Daftar Peminjam</a>
                </li> --}}
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="brand-link">
                <img src="{{ asset('assets/dist/img/logounib.png ') }}" alt="AdminLTE Logo "
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Inventaris Lab</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('assets/dist/img/logouser.png') }}" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        {{-- <a href="{{ route('teknisi.profile.index', ['id' => auth()->user()->id]) }}" --}}
                        class="d-block">{{ auth()->user()->name }}</a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="{{ route('laporaninventaris.teknisi') }}" class="nav-link">
                                <i class="nav-icon fas fa-shapes"></i>
                                <p>
                                    Pemeliharaan Inventaris
                                </p>
                            </a>
                        </li>


                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" class="nav-link"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <p>
                                        Logout
                                    </p>
                                </a>
                            </form>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>LAPORAN PEMERIKSAAN BARANG INVENTARIS</h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Laporan</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: '{{ $message }}',
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            </script>
                        @endif

                        @if ($error = Session::get('error'))
                            <script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: '{{ $error }}',
                                    showConfirmButton: true,
                                    confirmButtonText: 'OK'
                                });
                            </script>
                        @endif
                        <div class="box-body">
                            <div class="container">
                                <button style="margin-bottom: 20px; width: 150px; height: 40px; border-radius: 20px;"
                                    data-toggle="modal" data-target="#myModal" class="btn btn-info"><span
                                        class="glyphicon glyphicon-plus"></span>Tambah Barang</button>
                                <table id="datatabel" class="table table-striped table-bordered" style="width:100%">
                                    <thead style="background-color: rgba(27, 145, 255, 0.726); color: rgb(0, 0, 0);">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Teknisi</th>
                                            <th>Asal Teknisi</th>
                                            <th>Nama Barang</th>
                                            <th>Kondisi awal</th>
                                            <th>Kondisi Terbaru</th>
                                            <th>Foto Barang Awal</th>
                                            <th>Foto Barang Terbaru</th>
                                            <th>Detail Pemeriksaan</th>
                                            <th>Tanggal Pemeriksaan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach ($data_teknisi as $items)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $items->namateknisi }}</td>
                                                <td>{{ $items->asalteknisi }}</td>
                                                <td>({{ $items->barang->kodebarcode }})
                                                    {{ $items->kategori->namakategori }}
                                                    {{ $items->kategori->jenis }} {{ $items->kategori->merk }}</td>
                                                <td
                                                    class="{{ strcasecmp($items->barang->kondisi, 'rusak') === 0 ? 'text-danger' : 'text-success' }}">
                                                    {{ $items->barang->kondisi }}
                                                </td>
                                                <td
                                                    class="{{ strcasecmp($items->kondisiterbaru, 'rusak') === 0 ? 'text-danger' : 'text-success' }}">
                                                    {{ $items->kondisiterbaru }}
                                                </td>
                                                <td>
                                                    @if ($items->barang->gambar)
                                                        <img src="{{ asset('storage/gambar_barang/' . basename($items->barang->gambar)) }}"
                                                            alt="Foto Barang"
                                                            style="max-width: 100px; max-height: 80px;">
                                                    @else
                                                        <img src="{{ asset('path/ke/gambar/default.jpg') }}"
                                                            alt="Foto Barang Default"
                                                            style="max-width: 100px; max-height: 80px;">
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($items->gambarterbaru)
                                                        <img src="{{ asset('storage/gambar_barang/' . basename($items->gambarterbaru)) }}"
                                                            alt="Foto Barang"
                                                            style="max-width: 100px; max-height: 80px;">
                                                    @else
                                                        <img src="{{ asset('path/ke/gambar/default.jpg') }}"
                                                            alt="Foto Barang Default"
                                                            style="max-width: 100px; max-height: 80px;">
                                                    @endif
                                                </td>
                                                <td>{{ $items->detail }}</td>
                                                <td>{{ \Carbon\Carbon::parse($items->created_at)->formatLocalized('%A, %d %B %Y %H:%M') }}
                                                </td>
                                                <td>
                                                    <div
                                                        style="display: flex; justify-content: space-around; align-items: center;">
                                                        <button class="btn btn-warning" data-toggle="modal"
                                                            data-target="#modaledit_{{ $items->idlaporaninventaris }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-danger" data-toggle="modal"
                                                            data-target="#modaldelete_{{ $items->idlaporaninventaris }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <a href="{{ route('barangcetak.staff') }}" class="btn btn-primary">
                                    <i class="fas fa-print"> CETAK DATA</i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        {{-- Footer --}}
                    </div>
                    <!-- /.card-footer-->
                </div>
                <!-- /.card -->

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <strong>Copyright &copy; 2023 INVENTARIS LAB INFORMATIKA</a>.</strong>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>

    <!-- modal-->
    @if (!empty($data_teknisi))
        @foreach ($data_teknisi as $item)
            <!-- Modal Edit -->
            <div id="modaledit_{{ $item->idlaporaninventaris }}" class="modal fade">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Data Laporan Inventaris</h4>
                            <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form method="post"
                                action="{{ route('laporaninventaris.update', ['idlaporaninventaris' => $item->idlaporaninventaris]) }}"
                                novalidate enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label class="modal-label" for="idbarang">Pilih Barang</label>
                                    <select name="idbarang" id="idbarang" class="form-control" required>
                                        <option value="">Pilih Barang</option>
                                        @foreach ($kombinasilist as $index => $barang)
                                            <option value="{{ $barang->idbarang }}"
                                                data-idkategori="{{ $barang->kategori->idkategori }}"
                                                {{ $barang->idbarang == $item->idbarang ? 'selected' : '' }}>
                                                {{ $barang->kategori->namakategori }} - {{ $barang->kategori->jenis }}
                                                {{ $barang->kategori->merk }} - {{ $barang->kondisi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" name="idkategori" id="idkategori"
                                    value="{{ $item->kategori->idkategori }}">

                                <div class="form-group">
                                    <label for="edit-asalteknisis" class="modal-label">Nama Teknisi</label>
                                    <input type="text" id="edit-namateknisi" name="namateknisi"
                                        value="{{ $item->namateknisi }}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="edit-asal" class="modal-label">Asal Teknisi</label>
                                    <input type="text" id="edit-asal" name="asalteknisi"
                                        value="{{ $item->asalteknisi }}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="edit-detail" class="modal-label">Detail</label>
                                    <textarea id="edit-detail" name="detail" class="form-control" required>{{ $item->detail }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="modal-label" for="kondisiterbaru">Kondisi Barang Setelah
                                        Pemeriksaan</label>
                                    <select name="kondisiterbaru" id="kondisiterbaru" class="form-control" required>
                                        <option value="baik"
                                            {{ $item->kondisisetelah == 'baik' ? 'selected' : '' }}>Baik</option>
                                        <option value="rusak"
                                            {{ $item->kondisisetelah == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="edit-created-at" class="modal-label">Tanggal Laporan</label>
                                    <input type="datetime-local" id="edit-created-at" name="created_at"
                                        value="{{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d\TH:i') }}"
                                        class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="modal-label" for="edit-gambar"></label>
                                    @if ($item->gambarterbaru)
                                        <img src="{{ asset('storage/gambar_barang/' . basename($item->gambarterbaru)) }}"
                                            alt="Foto Barang" style="max-width: 100px; max-height: 80px;">
                                    @else
                                        <img src="{{ asset('path/ke/gambar/default.jpg') }}"
                                            alt="Foto Barang Default" style="max-width: 100px; max-height: 80px;">
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="modal-label" for="edit-gambarterbaru">Gambar Barang Setelah
                                        Pemeriksaan</label>
                                    <input type="file" name="gambarterbaru" id="edit-gambarterbaru"
                                        class="form-control-file">
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning"
                                        data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modaldelete_{{ $item->idlaporaninventaris }}" tabindex="-1" role="dialog"
                aria-labelledby="modaldelete_{{ $item->idlaporaninventaris }}Label" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modaldelete_{{ $item->idlaporaninventaris }}Label">Konfirmasi
                                Penghapusan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Anda yakin ingin menghapus data barang ini?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                            <form
                                action="{{ route('laporaninventaris.hapus', ['id' => $item->idlaporaninventaris]) }}"
                                method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <div id="myModal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">TAMBAH DATA LAPORAN INVENTARIS</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="post" id="myForm" action="{{ route('laporaninventaris.post') }}" novalidate
                        enctype="multipart/form-data">
                        @csrf

                        {{-- <video id="barcodeVideo" style="width: 100%" playsinline autoplay muted></video> --}}
                        <div class="form-group">
                            <label class="modal-label" for="idbarang">Pilih Barang</label>
                            <select name="idbarang" id="idbarang" class="form-control" required>
                                <option value="">Pilih Barang</option>
                                @foreach ($kombinasilist as $item)
                                    <option value="{{ $item->kodebarcode }}"
                                        data-idkategori="{{ $item->kategori->idkategori }}">
                                        ({{ $item->kodebarcode }})
                                        {{ $item->kategori->namakategori }} - {{ $item->kategori->jenis }} -
                                        {{ $item->kategori->merk }} - {{ $item->kondisi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <input type="hidden" name="kodebarcode" id="kodebarcode" value="">
                        <input type="hidden" name="idkategori" id="idkategori"
                            value="{{ $item->kategori->idkategori }} ">

                        <div class="form-group">
                            <label for="edit-asal" class="modal-label">Nama Teknisi</label>
                            <input type="text" id="edit-namateknisi" name="namateknisi" class="form-control"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="edit-asal" class="modal-label">Asal Teknisi</label>
                            <input type="text" id="edit-asal" name="asalteknisi" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="edit-detail" class="modal-label">Detail</label>
                            <textarea id="edit-detail" name="detail" class="form-control" required>{{ old('detail') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="modal-label" for="kondisiterbaru">Kondisi Barang Setelah Pemeriksaan</label>
                            <select name="kondisiterbaru" id="kondisiterbaru" class="form-control" required>
                                <option value="baik">Baik</option>
                                <option value="rusak">Rusak</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="edit-created-at" class="modal-label">Tanggal Laporan</label>
                            <input type="datetime-local" id="edit-created-at" name="created_at" class="form-control"
                                required>
                        </div>

                        <div class="form-group">
                            <label class="modal-label" for="edit-gambar">Gambar Barang Setelah Pemeriksaan</label>
                            <input type="file" name="gambarterbaru" id="edit-gambar" class="form-control-file">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" id="submitForm">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            var idbarangSelect = document.getElementById('idbarang');
            var kodebarcodeInput = document.getElementById('kodebarcode'); // Ganti dengan ID yang sesuai

            idbarangSelect.addEventListener('change', function() {
                var selectedOption = idbarangSelect.options[idbarangSelect.selectedIndex];

                // Set nilai untuk input kodebarcode jika data-idbarcode tersedia
                if (selectedOption.dataset.idbarcode) {
                    kodebarcodeInput.value = selectedOption.dataset.idbarcode;
                } else {
                    kodebarcodeInput.value =
                        ''; // Jika data-idbarcode tidak tersedia, kosongkan nilai input
                }

                // Set nilai untuk input idkategori
                document.getElementById('idkategori').value = selectedOption.dataset.idkategori;
                document.getElementById('kodebarcode').value = selectedOption.dataset.kodebarcode;
            });
        });
    </script> --}}

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var barcodeInput = document.getElementById("kodebarcode");
            var select = document.getElementById('idbarang');
            var idkategoriInput = document.getElementById('idkategori');
            var video = document.getElementById('barcodeVideo');
            var submitFormButton = document.getElementById('submitForm');
            var isFormSubmitted = false; // Flag to track form submission status

            // Event listener for modal show event
            $('#myModal').on('shown.bs.modal', function() {
                // Start barcode scanning
                startBarcodeScanning();
            });

            // Event listener for modal hide event
            $('#myModal').on('hidden.bs.modal', function() {
                // Stop barcode scanning
                Quagga.stop();
            });

            function startBarcodeScanning() {
                navigator.mediaDevices.getUserMedia({
                        video: true
                    })
                    .then(function(stream) {
                        // Assign the video stream to the video element
                        video.srcObject = stream;

                        // Initialize Quagga with the video element
                        Quagga.init({
                            inputStream: {
                                name: "Live",
                                type: "LiveStream",
                                target: video,
                            },
                            decoder: {
                                readers: ["ean_reader", "code_128_reader", "code_39_reader",
                                    "upc_reader", "upc_e_reader"
                                ],
                            },
                        }, function(err) {
                            if (err) {
                                console.error(err);
                                return;
                            }
                            // Start barcode scanning
                            Quagga.start();
                            Quagga.onDetected(handleBarcodeResult);
                        });
                    })
                    .catch(function(err) {
                        console.error("Error accessing camera:", err);
                    });
            }

            function handleBarcodeResult(result) {
                var barcodeValue = result.codeResult.code.trim();
                console.log('Barcode Value:', barcodeValue);

                barcodeValue = barcodeValue.replace(/[^a-zA-Z0-9]/g, '');
                console.log('Processed Barcode Value:', barcodeValue);

                // Menentukan elemen dropdown yang akan diakses
                var select = document.getElementById('idbarang');

                // Log semua nilai opsi untuk debugging
                console.log('All Option Values:', Array.from(select.options).map(option => option.value));

                // Temukan opsi berdasarkan nilai barcode
                var option = Array.from(select.options).find(option => {
                    var dataIdKategori = option.getAttribute('data-idkategori');
                    return dataIdKategori && dataIdKategori.includes(barcodeValue);
                });

                if (option) {
                    // Memilih opsi dalam dropdown
                    select.value = option.value;

                    // Menampilkan pesan atau melakukan tindakan lainnya jika diperlukan
                    console.log('Informasi Barcode terdeteksi. Silakan kirim formulir ketika Anda siap.');
                } else {
                    console.error('Opsi tidak ditemukan untuk barcode:', barcodeValue);
                    // Menangani kasus ketika opsi tidak ditemukan
                }
            }


        });
    </script>


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


    <script>
        $(document).ready(function() {
            // Add an event listener to idbarang select element
            $('#idbarang').change(function() {
                // Get the selected option
                var selectedOption = $(this).find('option:selected');

                // Ensure that data-idkategori is correctly assigned in the Blade template
                var idkategori = selectedOption.data('idkategori');

                // Update the value of idkategori hidden input
                $('#idkategori').val(idkategori);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var currentUrl = window.location.href;
            var idpeminjamFromUrl = extractidpeminjam(currentUrl);

            if (idpeminjamFromUrl !== null) {
                $('#idpeminjam').val(idpeminjamFromUrl);
            }

            function extractidpeminjam(url) {

                var regex = /\/peminjaman\/(\d+)/;
                var match = url.match(regex);


                return match ? match[1] : null;
            }
        });
    </script>
    <script>
        let selectedBarang = [];

        document.getElementById('idpeminjaman').addEventListener('change', function() {
            displaySelectedBarang();
        });

        document.getElementById('myForm').addEventListener('submit', function(event) {
            event.preventDefault();

            let tanggalPeminjaman = document.getElementById('created_at').value;
            let peminjam = document.getElementById('peminjam').value;
            let instansi = document.getElementById('instansi').value;
            let kontak = document.getElementById('kontak').value;
            let keterangan = document.getElementById('keterangan').value;

            // Add logic to save to the database or other actions as needed
            console.log('Data to be saved:', {
                selectedBarang,
                tanggalPeminjaman,
                peminjam,
                instansi,
                kontak,
                keterangan
            });

            // Clear the form or take other actions as needed
            this.reset();
            selectedBarang = [];
        });

        function displaySelectedBarang() {
            selectedBarang = [];
            let selectElement = document.getElementById('idpeminjaman');

            // Iterate through selected options and populate selectedBarang array
            for (let option of selectElement.selectedOptions) {
                let idbarang = option.getAttribute('data-idbarang');
                let namakategori = option.getAttribute('data-namakategori');
                let jenis = option.getAttribute('data-jenis');
                let merk = option.getAttribute('data-merk');
                let kondisi = option.getAttribute('data-kondisi');

                selectedBarang.push({
                    idbarang,
                    namakategori,
                    jenis,
                    merk,
                    kondisi
                });
            }

            // Implementation of logic to display selected barang, e.g., in an HTML table
            console.log('Selected Barang:', selectedBarang);
        }
    </script>
    <!-- jQuery -->
    <script>
        $(document).ready(function() {
            $('#modaledit').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var idpeminjaman = button.data('idpeminjaman');
                var namakategori = button.data('namakategori');
                var jenis = button.data('jenis');
                var merk = button.data('merk');
                var kondisi = button.data('kondisi');
                var asal = button.data('asal');
                var created_at = button.data('created-at');

                var modal = $(this);
                modal.find('#edit-idpeminjaman').val(idpeminjaman);
                modal.find('#edit-nama-kategori').val(namakategori);
                modal.find('#edit-jenis').val(jenis);
                modal.find('#edit-merk').val(merk);
                modal.find('#edit-kondisi').val(kondisi);
                modal.find('#edit-asal').val(asal);
                modal.find('#edit-created-at').val(created_at);
            });
        });
    </script>


    <script>
        document.getElementById('myForm').addEventListener('submit', function(event) {
            var selectedBarang = document.getElementById('idbarang').value;
            var selectedpeminjam = document.getElementById('idpeminjam').value;

            if (!selectedBarang || !selectedpeminjam) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Harap pilih barang dan peminjam!',
                });

                event.preventDefault(); // Prevent form submission
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.btn-edit').on('click', function() {
                var idpeminjaman = $(this).data('idpeminjaman');
                $('#modaledit_' + idpeminjaman).modal('show');
            });
        });
    </script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.13.6/datatables.min.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.13.6/datatables.min.js"></script>
    <script src="{{ asset('/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- DataTables CSS and JS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.13.6/datatables.min.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.13.6/datatables.min.js"></script>

    <!-- Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-4h+BRmBl5S9WJotZIv6KGanRgDFGg/M93ba8zRVcqsILwvCWpR9tC6zW+oRb26qJ" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"
        integrity="sha384-rfIEsHV2RvU9z4uZDf1eIHsj4nAjQ0d30z5fS4U9LjPi3ecSQ3xqC2CMEZ7gxzVo" crossorigin="anonymous">
    </script>

    <!-- DataTables Initialization Script -->
    <script>
        $(function() {
            $("#datatabel").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.btn-edit').on('click', function() {
                var idpeminjaman = $(this).data('idpeminjaman');
                $('#modaledit_' + idpeminjaman).modal('show');
            });
        });
    </script>


    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('assets/dist/js/demo.js') }}"></script>
</body>

</html>
