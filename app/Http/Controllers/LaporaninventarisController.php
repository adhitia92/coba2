<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\laporaninventaris;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class LaporaninventarisController extends Controller
{

    public function role()
    {
        if (Auth::id()) {
            $role = Auth::user()->role;

            if ($role == 'staff') {
                return view('dashboard');
            } elseif ($role == 'kepalalab') {
                return view('kepalalab.dashboard.index');
            } elseif ($role == 'teknisi') {
                return view('teknisi.dashboard.index');
            } else {
                return redirect()->back();
            }
        }
    }
    public function index()
    {
        // Lanjutkan dengan mengambil data kategori dan barang
        $kategorilist = Kategori::all();
        $baranglist = Barang::all();

        // Combine kategorilist and baranglist into one collection
        $kombinasilist = Barang::with('kategori')->orderBy('idbarang', 'ASC')->get();
        // Ambil data peminjaman berdasarkan idpeminjam
        $data_teknisi = Laporaninventaris::with(['barang', 'kategori', 'user'])
            ->orderBy('laporaninventaris.idlaporaninventaris', 'ASC')
            ->get();

        return view('teknisi.laporaninventaris.index', compact('data_teknisi', 'kombinasilist' ,'kategorilist'));
    }


    public function post(Request $request)
    {
        // dd($request->all());

        // Debugging line, you may remove this once everything is working fine

        $kodeBarcode = $request->filled('kodebarcode') ? $request->kodebarcode_modal : $request->idbarang;

        // Ambil data barang
        $barang = Barang::where('kodeBarcode', $kodeBarcode)->first();

        // Pastikan barang ditemukan sebelum melanjutkan
        if ($barang) {
            // Buat instance model Laporaninventaris
            $laporan = new Laporaninventaris([
                'idbarang' => $barang->idbarang,
                'idkategori' => $request->input('idkategori'),
                'asalteknisi' => $request->input('asalteknisi'),
                'namateknisi' => $request->input('namateknisi'),
                'detail' => $request->input('detail'),
                'kondisiterbaru' => $request->input('kondisiterbaru'),
                'created_at' => $request->input('created_at'),
            ]);

            // Simpan model ke dalam database
            $laporan->save();

            // Handle upload file
            if ($request->hasFile('gambarterbaru')) {
                $gambarFile = $request->file('gambarterbaru');

                $gambarFileName = date('YmdHis') . '_' . Str::random(5) . '.' . $gambarFile->getClientOriginalExtension();

                // Store the file in the 'public/gambar_barang' directory
                $gambarPath = $gambarFile->storeAs('public/gambar_barang', $gambarFileName);

                // Update model dengan field gambarterbaru dan simpan kembali
                $laporan->gambarterbaru = $gambarFileName; // Store only the filename, not the full path
                $laporan->save();
            }
            // dd($laporan->toArray());

            // Redirect kembali atau ke rute tertentu
            return redirect()->back()->with('success', 'Laporan Inventaris berhasil disimpan');
        } else {
            // Barang tidak ditemukan, handle sesuai kebutuhan
            return redirect()->back()->with('error', 'Barang tidak ditemukan');
        }
    }

    public function update(Request $request, $idlaporaninventaris)
{

    $request->validate([
        'idbarang' => 'required|exists:barang,idbarang',
        'idkategori' => 'required|exists:kategori,idkategori',
        'asalteknisi' => 'required',
        'namateknisi' => 'required',
        'detail' => 'required',
        'kondisiterbaru' => 'required|in:baik,rusak',
        'created_at' => 'required|date_format:Y-m-d\TH:i',
        'gambarterbaru' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    try {
        // Use the Eloquent model to update the record
        $laporaninventaris = Laporaninventaris::findOrFail($idlaporaninventaris);

        // Assign values to attributes
        $laporaninventaris->idbarang = $request->input('idbarang');
        $laporaninventaris->idkategori = $request->input('idkategori');
        $laporaninventaris->asalteknisi = $request->input('asalteknisi'); // Corrected typo
        $laporaninventaris->namateknisi = $request->input('namateknisi'); // Corrected typo
        $laporaninventaris->detail = $request->input('detail');
        $laporaninventaris->kondisiterbaru = $request->input('kondisiterbaru'); // Corrected typo
        $laporaninventaris->created_at = Carbon::parse($request->input('created_at'));

        // Handle image upload
        if ($request->hasFile('gambarterbaru')) {
            $gambarFile = $request->file('gambarterbaru');

            $gambarFileName = date('YmdHis') . '_' . Str::random(5) . '.' . $gambarFile->getClientOriginalExtension();

            $gambarPath = $gambarFile->storeAs('public/gambar_barang', $gambarFileName);
            $gambarUrl = Storage::url($gambarPath);

            $laporaninventaris->gambarterbaru = $gambarUrl;
        }

        $laporaninventaris->save();

        return redirect()->back()->with('success', 'Data Laporan inventaris berhasil diperbarui');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error updating Laporan inventaris: ' . $e->getMessage());
    }
}

public function hapus($idlaporaninventaris)
{
    try {
        // Use the Eloquent model to find the record
        $laporaninventaris = Laporaninventaris::findOrFail($idlaporaninventaris);

        // Handle deleting associated image (if any)
        if ($laporaninventaris->gambarterbaru) {
            Storage::delete('public/gambar_barang/' . basename($laporaninventaris->gambarterbaru));
        }

        // Use the DB facade to delete the record
        DB::table('laporaninventaris')->where('idlaporaninventaris', $idlaporaninventaris)->delete();

        return redirect()->back()->with('success', 'Data Laporan inventaris berhasil dihapus');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error deleting Laporan inventaris: ' . $e->getMessage());
    }
}

public function getOptions($kodebarcode)
{
    // Logika untuk mengambil opsi berdasarkan nilai $kodebarcode
    $options = Barang::where('kodebarcode', $kodebarcode)->pluck('nama_barang', 'idbarang');

    // Mengembalikan opsi sebagai JSON
    return response()->json($options);
}


}
