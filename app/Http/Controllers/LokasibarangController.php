<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\lokasi;
use Illuminate\Support\Facades\Log;
use App\Models\lokasibarang;
use App\Models\barang;
use Illuminate\Support\Facades\DB;
use App\Models\kategori;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class LokasibarangController extends Controller
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
    public function index(Request $request, $idlokasi)
    {
        // Cek apakah $idlokasi ada atau tidak
        if (!$idlokasi) {
            abort(404); // Tampilkan halaman error 404 jika $idlokasi tidak ada
        }

        // Lanjutkan dengan mengambil data kategori dan barang
        $kategorilist = Kategori::all();
        $baranglist = Barang::all();

        // Combine kategorilist and baranglist into one collection
        $kombinasilist = Barang::with('kategori')->orderBy('idbarang', 'ASC')->get();

        // Ambil data lokasibarang berdasarkan idlokasi
        $data_lokasibarang = DB::table('lokasibarang')
            ->join('kategori', 'kategori.idkategori', '=', 'lokasibarang.idkategori')
            ->join('barang', 'barang.idbarang', '=', 'lokasibarang.idbarang')
            ->join('lokasi', 'lokasi.idlokasi', '=', 'lokasibarang.idlokasi')
            ->select(
                'lokasibarang.idlokasibarang',
                'lokasibarang.idlokasi',
                'barang.idbarang',
                'barang.kodebarcode',
                'kategori.namakategori as namakategori',
                'kategori.jenis as jenis',
                'kategori.merk as merk',
                'barang.kondisi',
                'barang.asal',
                'kategori.jenis',
                'lokasi.namalokasi'
            )
            ->where('lokasibarang.idlokasi', $idlokasi) // Filter data berdasarkan idlokasi
            ->get();

        // Ambil data lokasi berdasarkan idlokasi
        $lokasi = lokasi::findOrFail($idlokasi);

        // Ambil data lokasi untuk dropdown
        $lokasilist = lokasi::all();

        return view('staff.lokasibarang.index', compact('data_lokasibarang', 'kombinasilist', 'lokasi', 'lokasilist'));
    }

    public function indexkepalalab(Request $request, $idlokasi)
    {
        // Cek apakah $idlokasi ada atau tidak
        if (!$idlokasi) {
            abort(404); // Tampilkan halaman error 404 jika $idlokasi tidak ada
        }

        // Lanjutkan dengan mengambil data kategori dan barang
        $kategorilist = Kategori::all();
        $baranglist = Barang::all();

        // Combine kategorilist and baranglist into one collection
        $kombinasilist = Barang::with('kategori')->orderBy('idbarang', 'ASC')->get();

        // Ambil data lokasibarang berdasarkan idlokasi
        $data_lokasibarang = DB::table('lokasibarang')
            ->join('kategori', 'kategori.idkategori', '=', 'lokasibarang.idkategori')
            ->join('barang', 'barang.idbarang', '=', 'lokasibarang.idbarang')
            ->join('lokasi', 'lokasi.idlokasi', '=', 'lokasibarang.idlokasi')
            ->select(
                'lokasibarang.idlokasibarang',
                'lokasibarang.idlokasi',
                'barang.idbarang',
                'barang.kodebarcode',
                'kategori.namakategori as namakategori',
                'kategori.jenis as jenis',
                'kategori.merk as merk',
                'barang.kondisi',
                'barang.asal',
                'kategori.jenis',
                'lokasi.namalokasi'
            )
            ->where('lokasibarang.idlokasi', $idlokasi) // Filter data berdasarkan idlokasi
            ->get();

        // Ambil data lokasi berdasarkan idlokasi
        $lokasi = lokasi::findOrFail($idlokasi);

        // Ambil data lokasi untuk dropdown
        $lokasilist = lokasi::all();

        return view('kepalalab.lokasibarang.index', compact('data_lokasibarang', 'kombinasilist', 'lokasi', 'lokasilist'));
    }

    public function post(Request $request)
    {

        $request->validate([
            'idkategori' => 'required',
            'idbarang' => 'required',
            'idlokasi' => 'required',
        ]);

        try {
            // Retrieve data from the request
            $idkategori = $request->input('idkategori');
            $idbarang = $request->input('idbarang');
            $idlokasi = $request->input('idlokasi');

            // Find the corresponding models
            $kategori = Kategori::findOrFail($idkategori);
            $barang = Barang::findOrFail($idbarang);

            // Check if the idbarang already exists in the specified idlokasi
            if ($this->isIdBarangExistsInLocation($idbarang)) {
                return redirect()->route('lokasibarang.staff', ['idlokasi' => $idlokasi])->with(['error' => 'Barang Sudah Dimasukan Dalam Data Ruangan']);
            }

            // Create a new Lokasibarang instance
            $datalokasibarang = new Lokasibarang();
            $datalokasibarang->idkategori = $kategori->idkategori;
            $datalokasibarang->idbarang = $barang->idbarang;
            $datalokasibarang->idlokasi = $idlokasi; // Ensure this matches your database structure

            // Save the data
            $datalokasibarang->save();

            // Redirect to the desired route with success message
            return redirect()->route('lokasibarang.staff', ['idlokasi' => $idlokasi])->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error saving data to Lokasibarang: ' . $e->getMessage());

            // Redirect to the desired route with an error message
            return redirect()->route('lokasibarang.staff', ['idlokasi' => $idlokasi])->with(['error' => 'Gagal menyimpan data.']);
        }
    }

    public function postkepalalab(Request $request)
    {
        $request->validate([
            'idkategori' => 'required',
            'idbarang' => 'required',
            'idlokasi' => 'required',
        ]);

        try {
            // Retrieve data from the request
            $idkategori = $request->input('idkategori');
            $idbarang = $request->input('idbarang');
            $idlokasi = $request->input('idlokasi');

            // Find the corresponding models
            $kategori = Kategori::findOrFail($idkategori);
            $barang = Barang::findOrFail($idbarang);

            // Check if the idbarang already exists in the specified idlokasi
            if ($this->isIdBarangExistsInLocation($idbarang)) {
                return redirect()->route('lokasibarang.kepalalab', ['idlokasi' => $idlokasi])->with(['error' => 'Barang Sudah Dimasukan Dalam Data Ruangan']);
            }

            // Create a new Lokasibarang instance
            $datalokasibarang = new Lokasibarang();
            $datalokasibarang->idkategori = $kategori->idkategori;
            $datalokasibarang->idbarang = $barang->idbarang;
            $datalokasibarang->idlokasi = $idlokasi; // Ensure this matches your database structure

            // Save the data
            $datalokasibarang->save();

            // Redirect to the desired route with success message
            return redirect()->route('lokasibarang.kepalalab', ['idlokasi' => $idlokasi])->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error saving data to Lokasibarang: ' . $e->getMessage());

            // Redirect to the desired route with an error message
            return redirect()->route('lokasibarang.kepalalab', ['idlokasi' => $idlokasi])->with(['error' => 'Gagal menyimpan data.']);
        }
    }

    // Function to check if idbarang already exists in the specified idlokasi
    private function isIdBarangExistsInLocation($idbarang)
    {
        return Lokasibarang::where('idbarang', $idbarang)->exists();
    }


    public function hapus($idlokasibarang)
    {
        try {
            // Temukan data lokasi barang berdasarkan ID
            $lokasiBarang = LokasiBarang::findOrFail($idlokasibarang);
            $idlokasi = $lokasiBarang->idlokasi;
            // Lakukan proses penghapusan
            $lokasiBarang->delete();

            return redirect()->route('lokasibarang.staff', ['idlokasi' => $idlokasi])->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('lokasibarang.staff', ['idlokasi' => $idlokasi])->with(['error' => 'Gagal menghapus data.']);
        }
    }

    public function hapuskepalalab($idlokasibarang)
    {
        try {
            // Temukan data lokasi barang berdasarkan ID
            $lokasiBarang = LokasiBarang::findOrFail($idlokasibarang);
            $idlokasi = $lokasiBarang->idlokasi;
            // Lakukan proses penghapusan
            $lokasiBarang->delete();

            return redirect()->route('lokasibarang.kepalalab', ['idlokasi' => $idlokasi])->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('lokasibarang.kepalalab', ['idlokasi' => $idlokasi])->with(['error' => 'Gagal menghapus data.']);
        }
    }

    public function cetakbarangruangan($idlokasi, $idlokasibarang)
    {
        try {
            // Retrieve Lokasi
            $lokasi = Lokasi::findOrFail($idlokasi);

            // Retrieve Lokasibarang with Barang and Kategori relationships
            $lokasibarang = Lokasibarang::with('barang.kategori')->findOrFail($idlokasibarang);

            // Retrieve data_barang_kategori based on idlokasi
            $data_barang_kategori = Barang::whereHas('lokasibarang', function ($query) use ($lokasi) {
                $query->where('idlokasi', $lokasi->idlokasi);
            })->get();

            // Define and populate $kategorilist (assuming you have a Kategori model)
            $kategorilist = Kategori::all();

            // Define and populate $baranglist (assuming you have a Barang model)
            $baranglist = Barang::all();

            // Combine $kategorilist and $baranglist into $kombinasilist
            $kombinasilist = $kategorilist->merge($baranglist);

            // Continue with the rest of your code...

            // Example: Accessing data
            $lokasiName = $lokasi->namalokasi;
            $barangName = $lokasibarang->barang->namakategori;

            // Return the view with data
            return view('staff.lokasibarang.cetak', compact('data_barang_kategori', 'kategorilist', 'kombinasilist', 'baranglist', 'lokasi', 'lokasibarang'));

        } catch (ModelNotFoundException $e) {
            // Handle the case when Lokasi or Lokasibarang is not found
            return response('Lokasi or Lokasibarang not found or invalid.', 404);
        }
    }

    public function cetakbarangruangankepalalab($idlokasi, $idlokasibarang)
    {
        try {
            // Retrieve Lokasi
            $lokasi = Lokasi::findOrFail($idlokasi);

            // Retrieve Lokasibarang with Barang and Kategori relationships
            $lokasibarang = Lokasibarang::with('barang.kategori')->findOrFail($idlokasibarang);

            // Retrieve data_barang_kategori based on idlokasi
            $data_barang_kategori = Barang::whereHas('lokasibarang', function ($query) use ($lokasi) {
                $query->where('idlokasi', $lokasi->idlokasi);
            })->get();

            // Define and populate $kategorilist (assuming you have a Kategori model)
            $kategorilist = Kategori::all();

            // Define and populate $baranglist (assuming you have a Barang model)
            $baranglist = Barang::all();

            // Combine $kategorilist and $baranglist into $kombinasilist
            $kombinasilist = $kategorilist->merge($baranglist);

            // Continue with the rest of your code...

            // Example: Accessing data
            $lokasiName = $lokasi->namalokasi;
            $barangName = $lokasibarang->barang->namakategori;

            // Return the view with data
            return view('staff.lokasibarang.cetak', compact('data_barang_kategori', 'kategorilist', 'kombinasilist', 'baranglist', 'lokasi', 'lokasibarang'));

        } catch (ModelNotFoundException $e) {
            // Handle the case when Lokasi or Lokasibarang is not found
            return response('Lokasi or Lokasibarang not found or invalid.', 404);
        }
    }





}
