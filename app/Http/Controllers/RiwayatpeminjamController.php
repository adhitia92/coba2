<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Peminjam;
use Illuminate\Support\Facades\View;
use App\Models\Penerima;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Riwayatbarang;
use App\Models\Riwayatpeminjam;
use App\Models\BarangMasuk;

class RiwayatpeminjamController extends Controller
{
    public function role()
    {
        if (Auth::id()) {
            $role = Auth::user()->role;

            if ($role == 'staff') {
                return view('dashboard');
            } elseif ($role == 'kepalalab') {
                return view('kepalalab.dashboard.index');
            } else {
                return redirect()->back();
            }
        }
    }
    public function index()
    {
        $data_riwayatpeminjam = Riwayatpeminjam::with('barang')
            ->groupBy('idpeminjam')
            ->selectRaw('MAX(idriwayatpeminjam) as idriwayatpeminjam, idpeminjam')
            ->get();

        return view('staff.riwayat.index', compact('data_riwayatpeminjam'));
    }

    public function indexkepalalab()
    {
        $data_riwayatpeminjam = Riwayatpeminjam::with('barang')
            ->groupBy('idpeminjam')
            ->selectRaw('MAX(idriwayatpeminjam) as idriwayatpeminjam, idpeminjam')
            ->get();

        return view('kepalalab.riwayat.index', compact('data_riwayatpeminjam'));
    }
    public function hapus(RiwayatPeminjam $riwayatpeminjam)
    {

        $riwayatpeminjam->delete();

        // Redirect or return a response as needed
        return redirect()->route('riwayatpeminjam.index')->with('success', 'Kondisi barang berhasil dihapus.');
    }

    public function hapuskepalalab(RiwayatPeminjam $riwayatpeminjam)
    {

        $riwayatpeminjam->delete();

        // Redirect or return a response as needed
        return redirect()->route('riwayatpeminjam.kepalalab')->with('success', 'Kondisi barang berhasil dihapus.');
    }

    public function detail($idpeminjam)
    {
        // Cari semua riwayat peminjaman berdasarkan idpeminjam
        $riwayatpeminjam = Riwayatpeminjam::where('idpeminjam', $idpeminjam)->get();

        // Periksa apakah data ditemukan
        if ($riwayatpeminjam->isEmpty()) {
            abort(404); // Atau tindakan lain jika data tidak ditemukan
        }

        return view('staff.riwayat.riwayatbarang', ['riwayatpeminjam' => $riwayatpeminjam]);
    }

    public function detailkepalalab($idpeminjam)
    {
        // Cari semua riwayat peminjaman berdasarkan idpeminjam
        $riwayatpeminjam = Riwayatpeminjam::where('idpeminjam', $idpeminjam)->get();

        // Periksa apakah data ditemukan
        if ($riwayatpeminjam->isEmpty()) {
            abort(404); // Atau tindakan lain jika data tidak ditemukan
        }

        return view('kepalalab.riwayat.detail', ['riwayatpeminjam' => $riwayatpeminjam]);
    }
    public function editKondisi($idbarang, Request $request)
    {
        // Lakukan validasi atau operasi lainnya sesuai kebutuhan

        // Contoh validasi sederhana
        $request->validate([
            'kondisi' => 'required|string|max:255',
        ]);

        // Update kondisi pada idbarang di tabel Barang
        DB::table('barang')->where('idbarang', $idbarang)->update(['kondisi' => $request->kondisi]);

        // Ambil idpeminjam dari tabel RiwayatPeminjaman yang memiliki hubungan dengan Barang
        $peminjamId = DB::table('riwayatpeminjam')
            ->where('idbarang', $idbarang)
            ->value('idpeminjam');

        if ($peminjamId) {
            // Update statuspeminjam berdasarkan kondisi di tabel Peminjam
            $statusPeminjam = ($request->kondisi == 'rusak') ? 'ditangguhkan' : 'diselesaikan';

            // Update statuspeminjam di tabel Peminjam
            DB::table('peminjam')->where('idpeminjam', $peminjamId)->update(['statuspeminjam' => $statusPeminjam]);

            return redirect()->back()->with('success', 'Kondisi barang berhasil diubah.');
        } else {
            return redirect()->back()->with('error', 'Tidak dapat menemukan peminjam_id untuk idbarang yang diberikan.');
        }
    }

    public function editKondisikepalalab($idbarang, Request $request)
    {
        // Lakukan validasi atau operasi lainnya sesuai kebutuhan

        // Contoh validasi sederhana
        $request->validate([
            'kondisi' => 'required|string|max:255',
        ]);

        // Update kondisi pada idbarang di tabel Barang
        DB::table('barang')->where('idbarang', $idbarang)->update(['kondisi' => $request->kondisi]);

        // Ambil idpeminjam dari tabel RiwayatPeminjaman yang memiliki hubungan dengan Barang
        $peminjamId = DB::table('riwayatpeminjam')
            ->where('idbarang', $idbarang)
            ->value('idpeminjam');

        if ($peminjamId) {
            // Update statuspeminjam berdasarkan kondisi di tabel Peminjam
            $statusPeminjam = ($request->kondisi == 'rusak') ? 'ditangguhkan' : 'diselesaikan';

            // Update statuspeminjam di tabel Peminjam
            DB::table('peminjam')->where('idpeminjam', $peminjamId)->update(['statuspeminjam' => $statusPeminjam]);

            return redirect()->back()->with('success', 'Kondisi barang berhasil diubah.');
        } else {
            return redirect()->back()->with('error', 'Tidak dapat menemukan peminjam_id untuk idbarang yang diberikan.');
        }
    }

}
