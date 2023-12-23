<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kategori;
use App\Models\riwayatbarang;
use Illuminate\Support\Facades\DB;
use App\Models\User;
class KategoriController extends Controller

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
        $data_kategori = Kategori::all();
        return view('staff.kategori.index', compact('data_kategori'));
    }

    public function indexkepalalab()
    {
        $data_kategori = Kategori::all();
        return view('kepalalab.kategori.index', compact('data_kategori'));
    }

    public function post(Request $request)
     {
            $data_kategori = new Kategori();
            $data_kategori->namakategori = $request->namakategori;
            $data_kategori->jenis = $request->jenis;
            $data_kategori->merk = $request->merk;
            $data_kategori->created_at = $request->created_at;
            $data_kategori->save();

            return redirect()->route('kategori.staff')->with(['success' => 'Data Berhasil Ditambahkan!']);
     }

     public function postkepalalab(Request $request)
     {
            $data_kategori = new Kategori();
            $data_kategori->namakategori = $request->namakategori;
            $data_kategori->jenis = $request->jenis;
            $data_kategori->merk = $request->merk;
            $data_kategori->created_at = $request->created_at;
            $data_kategori->save();

            return redirect()->route('kategori.kepalalab')->with(['success' => 'Data Berhasil Ditambahkan!']);
     }

    public function hapus(Kategori $kategori)
    {
            // Mulai transaksi database
            DB::beginTransaction();

            try {

                // Hapus kategori jika tidak ada referensi di tabel riwayatbarang
                $kategori->delete();

                // Commit transaksi
                DB::commit();

                return redirect()->route('kategori.staff')->with('success', 'Kategori berhasil dihapus.');
            } catch (\Exception $e) {
                // Rollback transaksi jika terjadi kesalahan
                DB::rollback();

                return redirect()->route('kategori.staff')->with('error', 'Gagal menghapus kategori. Silakan coba lagi.');
            }
    }

    public function hapuskepalalab(Kategori $kategori)
    {
            // Mulai transaksi database
            DB::beginTransaction();

            try {

                // Hapus kategori jika tidak ada referensi di tabel riwayatbarang
                $kategori->delete();

                // Commit transaksi
                DB::commit();

                return redirect()->route('kategori.kepalalab')->with('success', 'Kategori berhasil dihapus.');
            } catch (\Exception $e) {
                // Rollback transaksi jika terjadi kesalahan
                DB::rollback();

                return redirect()->route('kategori.kepalalab')->with('error', 'Gagal menghapus kategori. Silakan coba lagi.');
            }
    }

    public function update(Request $request, $idkategori)
    {
            // Validate the form data
            $validatedData = $request->validate([
                'namakategori' => 'required|string|max:255',
                'jenis' => 'required|string|max:255',
                'merk' => 'required|string|max:255',
                'kategori_created_at' => 'required|date_format:Y-m-d\TH:i',
            ]);

            // Update the data in the database
            $kategori = Kategori::findOrFail($idkategori);
            $kategori->update([
                'namakategori' => $validatedData['namakategori'],
                'jenis' => $validatedData['jenis'],
                'merk' => $validatedData['merk'],
                'created_at' => Carbon::parse($validatedData['kategori_created_at']),
            ]);

            return redirect()->back()->with('success', 'Data Kategori berhasil diupdate');
    }

    public function updatekepalalab(Request $request, $idkategori)
    {
            // Validate the form data
            $validatedData = $request->validate([
                'namakategori' => 'required|string|max:255',
                'jenis' => 'required|string|max:255',
                'merk' => 'required|string|max:255',
                'kategori_created_at' => 'required|date_format:Y-m-d\TH:i',
            ]);

            // Update the data in the database
            $kategori = Kategori::findOrFail($idkategori);
            $kategori->update([
                'namakategori' => $validatedData['namakategori'],
                'jenis' => $validatedData['jenis'],
                'merk' => $validatedData['merk'],
                'created_at' => Carbon::parse($validatedData['kategori_created_at']),
            ]);

            return redirect()->route('kategori.kepalalab')->with('success', 'Data Kategori berhasil diupdate');
    }

    public function profile($id)
    {
        // Retrieve the user with the given ID
        $user = User::findOrFail($id);

        // Pass the user data to the view
        return view('staff.profile.index', ['user' => $user]);
    }

}

