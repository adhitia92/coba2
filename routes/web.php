<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Kategoricontroller;
use App\Http\Controllers\barangcontroller;
use App\Http\Controllers\peminjamancontroller;
use App\Http\Controllers\peminjamcontroller;
use App\Http\Controllers\RiwayatpeminjamController;
use App\Http\Controllers\datapeminjamancontroller;
use App\Http\Controllers\lokasicontroller;
use App\Http\Controllers\lokasibarangcontroller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporaninventarisController;



Route::view('/', 'welcome');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'staff'])
    ->group(function () {
        Route::get('/kategori/role', [KategoriController::class, 'role'])->name('kategori.role');
        Route::post('/kategori', [KategoriController::class, 'post'])->name('kategori.post');
        Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.staff');
        Route::delete('/kategori/{kategori}/hapus', [KategoriController::class, 'hapus'])->name('kategori.hapus');
        Route::put('/kategori/update/{idkategori}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::get('/staff/profile/{id}', [Kategoricontroller::class, 'profile'])->name('staff.profile.index');
        // barang
        Route::get('/barang/role', [barangController::class, 'role'])->name('barang.role');
        Route::get('/barang', [barangController::class, 'index'])->name('barang.staff');
        Route::get('/staff/barang/cetak', [barangController::class, 'indexcetak'])->name('barangcetak.staff');
        Route::get('/barang/{idbarang}/detail', [barangController::class, 'indexdetail'])->name('barangdetail.staff');
        Route::get('/barangtersedia', [barangController::class, 'tersedia'])->name('tersedia.staff');
        Route::post('/barang', [barangController::class, 'post'])->name('barang.post');
        Route::delete('/barang/{barang}/hapus', [BarangController::class, 'hapus'])->name('barang.hapus');
        Route::put('/barang/update/{idbarang}', [barangController::class, 'update'])->name('barang.update');
        Route::match(['get', 'post'], '/staff/cetakbarcode', [barangController::class, 'cetakbarcode'])->name('cetakbarcode.staff');

        // peminjaman
        Route::get('/peminjaman/role', [PeminjamanController::class, 'role'])->name('peminjaman.role');
        Route::get('/peminjaman/{idpeminjam}', [PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::get('/staff/peminjaman/cetakpdf/{idpeminjaman}/{idpeminjam}', [PeminjamanController::class, 'cetakpdf'])->name('peminjaman.cetakpdf');
        Route::delete('/peminjaman/{peminjaman}/hapus', [peminjamanController::class, 'hapus'])->name('peminjaman.hapus');
        Route::post('/peminjaman', [PeminjamanController::class, 'post'])->name('peminjaman.post');
        Route::post('/peminjaman/selesai/{idpeminjam}', [PeminjamanController::class, 'selesaipeminjaman'])->name('peminjaman.selesai');
        // peminjam
        Route::get('/peminjam/role', [peminjamController::class, 'role'])->name('peminjam.role');
        Route::get('/peminjam', [peminjamController::class, 'index'])->name('peminjam.staff');
        Route::get('/peminjam/cetak', [peminjamController::class, 'indexcetak'])->name('peminjamcetakpdf.staff');
        Route::get('/staff/peminjam/cetakpdf/{idpeminjam}', [peminjamController::class, 'cetakpdf'])->name('peminjam.cetakpdf');
        Route::post('/peminjam', [peminjamController::class, 'post'])->name('peminjam.post');
        Route::delete('/peminjam/{peminjam}/hapus', [peminjamController::class, 'hapus'])->name('peminjam.hapus');
        Route::put('/peminjam/update/{idpeminjam}', [peminjamController::class, 'update'])->name('peminjam.update');
        // Riwayatbarang
        Route::get('/Riwayatbarang/role', [peminjamController::class, 'role'])->name('riwayatbarang.role');
        Route::get('/Riwayatpeminjam', [RiwayatpeminjamController::class, 'index'])->name('riwayatpeminjam.index');
        Route::delete('/riwayatpeminjam/{riwayatpeminjam}', [RiwayatpeminjamController::class, 'hapus'])->name('riwayatpeminjam.hapus');
        Route::put('/edit/kondisi/{idbarang}', [Riwayatpeminjamcontroller::class, 'editkondisi'])->name('edit.kondisi');
        Route::get('staff/riwayat/riwayatpeminjam/{idpeminjam}', [RiwayatpeminjamController::class, 'detail'])->name('staff.riwayat.riwayatbarang');
        // lokasi
        Route::get('/lokasi/role', [lokasiController::class, 'role'])->name('lokasi.role');
        Route::get('/lokasi', [lokasiController::class, 'index'])->name('lokasi.staff');
        Route::post('/lokasi', [LokasiController::class, 'post'])->name('lokasi.post');
        Route::put('/lokasi/update/{idlokasi}', [lokasiController::class, 'update'])->name('lokasi.update');
        Route::delete('/lokasi/{lokasi}/hapus', [LokasiController::class, 'hapus'])->name('lokasi.hapus');
        Route::get('/lokasibarang/role', [lokasibarangController::class, 'role'])->name('lokasibarang.role');
        Route::get('/barangcetakruangan/{idlokasi}/{idlokasibarang}', [lokasibarangController::class, 'cetakbarangruangan'])->name('barangcetakruangan.staff');
        // lokasibarang
        Route::get('/lokasibarang/{idlokasi}', [lokasibarangController::class, 'index'])->name('lokasibarang.staff');
        Route::post('/lokasibarang', [LokasibarangController::class, 'post'])->name('lokasibarang.post');
        Route::delete('/lokasibarang/hapus/{idlokasibarang}', [LokasiBarangController::class, 'hapus'])->name('lokasibarang.hapus');
    });


Route::middleware(['auth', 'kepalalab'])
    ->group(function () {
        Route::get('/datapeminjaman', [datapeminjamanController::class, 'dataToBeApproved'])->name('datapeminjaman.kepalalab');
        Route::get('/peminjaman/approve/{idpeminjam}', [datapeminjamanController::class, 'approve'])->name('peminjaman.approve');
        Route::get('/datapeminjaman/reject/{idpeminjam}', [dataPeminjamanController::class, 'reject'])->name('peminjaman.reject');
        Route::get('/kepalalab/datapeminjaman/detail/{idpeminjam}/{idpeminjaman}', [DatapeminjamanController::class, 'detailPeminjaman'])->name('kepalalab.datapeminjaman.detail');
        Route::get('/kepalalab/profile/{id}', [dataPeminjamancontroller::class, 'profile'])->name('kepalalab.profile.index');

        Route::get('/barangkepalalab', [barangController::class, 'indexkepalalab'])->name('barang.kepalalab');
        Route::get('/kepalalab/barang/cetak', [barangController::class, 'indexcetakkepalalab'])->name('barangcetak.kepalalab');
        Route::get('/kepalalab/barang/{idbarang}/detail', [barangController::class, 'indexdetailkepalab'])->name('barangdetail.kepalalab');
        Route::get('/Riwayatpeminjamkepalalab', [RiwayatpeminjamController::class, 'indexkepalalab'])->name('riwayatpeminjam.kepalalab');
        Route::get('kepalalab/riwayat/riwayatpeminjam/{idpeminjam}', [RiwayatpeminjamController::class, 'detailkepalalab'])->name('kepalalab.riwayat.riwayatbarang');
        Route::match(['get', 'post'], '/kepalalab/cetakbarcode', [barangController::class, 'cetakbarcodekepalalab'])->name('cetakbarcode.kepalalab');
        //barang
        Route::post('/kepalalab/barang', [barangController::class, 'postkepalalab'])->name('barangkepalalab.post');
        Route::delete('/kepalalab/barang/{barang}/hapus', [BarangController::class, 'hapuskepalalab'])->name('barangkepalalab.hapus');
        Route::put('/kepalalab/barang/update/{idbarang}', [barangController::class, 'updatekepalalab'])->name('barangkepalalab.update');
        //kategori
        Route::get('/kepalalab/kategori', [KategoriController::class, 'indexkepalalab'])->name('kategori.kepalalab');
        Route::delete('/kepalalab/kategori/{kategori}/hapus', [KategoriController::class, 'hapuskepalalab'])->name('kategorikepalalab.hapus');
        Route::put('/kepalalab/kategori/update/{idkategori}', [KategoriController::class, 'updatekepalalab'])->name('kategorikepalalab.update');
        Route::post('/kepalalab/kategori', [KategoriController::class, 'postkepalalab'])->name('kategorikepalalab.post');
        Route::get('/kepalalab/barangcetakruangan/{idlokasi}/{idlokasibarang}', [lokasibarangController::class, 'cetakbarangruangankepalalab'])->name('barangcetakruangan.kepalalab');
        //transaksi
        Route::get('/kepalalab/peminjaman/cetakpdf/{idpeminjaman}/{idpeminjam}', [PeminjamanController::class, 'cetakpdfkepalalab'])->name('peminjamankepalalab.cetakpdf');
        // peminjam
        Route::get('/kepalalab/peminjam', [peminjamController::class, 'indexkepalalab'])->name('peminjam.kepalalab');
        Route::get('/kepalalab/peminjam/cetak', [peminjamController::class, 'indexcetakkepalalab'])->name('peminjamcetak.kepalalab');
        Route::get('/peminjam/cetakpdf/{idpeminjam}', [peminjamController::class, 'cetakpdf'])->name('peminjam.cetakpdf');
        Route::post('/kepalalab/peminjam', [peminjamController::class, 'postkepalalab'])->name('peminjamkepalalab.post');
        Route::delete('/kepalalab/peminjam/{peminjam}/hapus', [peminjamController::class, 'hapuskepalalab'])->name('peminjamkepalalab.hapus');
        Route::put('/kepalalab/peminjam/update/{idpeminjam}', [peminjamController::class, 'updatekepalalab'])->name('peminjamkepalalab.update');
        Route::post('/kepalalab/peminjaman/selesai/{idpeminjam}', [PeminjamanController::class, 'selesaipeminjamankepalalab'])->name('peminjamankepalalab.selesai');
        //peminjaman
        Route::get('/kepalalab/peminjaman/{idpeminjam}', [PeminjamanController::class, 'indexkepalalab'])->name('peminjamankepalalab.index');
        Route::get('/peminjaman/cetakpdf/{idpeminjaman}/{idpeminjam}', [PeminjamanController::class, 'cetakpdf'])->name('peminjamankepalalab.cetakpdf');
        Route::delete('/kepalalab/peminjaman/{peminjaman}/hapus', [peminjamanController::class, 'hapuskepalalab'])->name('peminjamankepalalab.hapus');
        Route::post('/kepalalab/peminjaman', [PeminjamanController::class, 'postkepalalab'])->name('peminjamankepalalab.post');
        Route::get('/kepalalab/barangtersedia', [barangController::class, 'tersediakepalalab'])->name('tersedia.kepalalab');
        Route::delete('/kepalalab/riwayatpeminjam/{riwayatpeminjam}', [RiwayatpeminjamController::class, 'hapuskepalalab'])->name('riwayatpeminjamkepalalab.hapus');
        Route::put('/kepalalab/edit/kondisi/{idbarang}', [Riwayatpeminjamcontroller::class, 'editkondisikepalalab'])->name('edit.kondisikepalalab');
        //lokasi
        Route::get('/kepalalab/lokasi', [lokasiController::class, 'indexkepalalab'])->name('lokasi.kepalalab');
        Route::post('/kepalalab/lokasi', [LokasiController::class, 'postkepalalab'])->name('lokasikepalalab.post');
        Route::put('/kepalalab/lokasi/update/{idlokasi}', [lokasiController::class, 'updatekepalalab'])->name('lokasikepalalab.update');
        Route::delete('/kepalalab/lokasi/{lokasi}/hapus', [LokasiController::class, 'hapuskepalalab'])->name('lokasikepalalab.hapus');
         // lokasibarang
         Route::get('/kepalalab/lokasibarang/{idlokasi}', [lokasibarangController::class, 'indexkepalalab'])->name('lokasibarang.kepalalab');
         Route::post('/kepalalab/lokasibarang', [LokasibarangController::class, 'postkepalalab'])->name('lokasibarangkepalalab.post');
         Route::delete('/kepalalab/lokasibarang/hapus/{idlokasibarang}', [LokasiBarangController::class, 'hapuskepalalab'])->name('lokasibarangkepalalab.hapus');
         //manajemenuser
         Route::get('/manajemenuser', [UserController::class, 'index'])->name('user.index');
         Route::post('/manajemenuser/post', [UserController::class, 'post'])->name('user.post');
         Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
         Route::delete('/manajemenuser/{user}', [UserController::class, 'hapus'])->name('user.hapus');
         Route::post('/manajemenuser/reset-password/{user}', [UserController::class, 'resetPassword'])->name('user.resetPassword');

    });


Route::middleware(['auth', 'teknisi'])
->group(function () {
    Route::get('/laporaninventaris', [LaporaninventarisController::class, 'index'])->name('laporaninventaris.teknisi');
    Route::post('/laporaninventaris/post', [LaporanInventarisController::class, 'post'])->name('laporaninventaris.post');
    Route::put('/laporaninventaris/{idlaporaninventaris}', [LaporaninventarisController::class, 'update'])->name('laporaninventaris.update');
    Route::delete('/laporaninventaris/{id}', [LaporaninventarisController::class, 'hapus'])->name('laporaninventaris.hapus');
    Route::get('/get-options/{barcode}', [LaporaninventarisController::class, 'getOptions']);





});


// Route::middleware(['auth', 'kepalalab'])
//     ->group(function () {
//         Route::get('/barang/role', [barangController::class, 'role'])->name('barang.role');
//         Route::get('/barangkepalalab', [barangController::class, 'indexkepalalab'])->name('barang.kepalalab');
//         Route::get('/barangtersediakepalalab', [barangController::class, 'tersediakepalalab'])->name('tersedia.keplalab');
//         Route::post('/barangkeplalab', [barangController::class, 'post'])->name('barang.post');
//         Route::delete('/barangkepalalab/{barang}/hapus', [BarangController::class, 'hapus'])->name('barang.hapus');
//         Route::put('/barangkepalalab/update/{idbarang}', [barangController::class, 'update'])->name('barang.update');
//     });

require __DIR__ . '/auth.php';
