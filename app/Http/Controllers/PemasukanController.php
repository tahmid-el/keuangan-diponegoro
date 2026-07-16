<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PemasukanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pemasukan::with('kategori');
        $kategoris = Kategori::pemasukan()->orderBy('nama')->get();
        
        if ($request->filled('startdate') && $request->filled('enddate')) {
            $query->whereBetween('tanggal', [$request->startdate, $request->enddate]);
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('keterangan', 'like', '%' . $request->search . '%')
                  ->orWhereHas('kategori', function($kategori) use ($request) {
                      $kategori->where('nama', 'like', '%' . $request->search . '%');
                  });
            });
        }
        
        $pemasukans = $query->orderBy('tanggal', 'desc')->paginate(10);
        return view('bendahara.pemasukan.index', compact('pemasukans', 'kategoris'));
    }

    public function create()
    {
        return view('bendahara.pemasukan.form');
    }

    public function store(Request $request)
    {
        if ($request->has('nominal')) {
            $request->merge(['nominal' => str_replace('.', '', $request->nominal)]);
        }

        $request->validate([
            'tanggal' => 'required|date',
            'nominal' => 'required|numeric|min:0',
            'keterangan' => 'required|string|max:255',
            'kategori_id' => 'nullable',
            'kategori_baru' => 'required_without:kategori_id|nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('bukti', 'kategori_baru');
        $data['kategori_id'] = $this->resolveKategoriId($request);
        $data['user_id'] = Auth::id();

        if ($request->hasFile('bukti')) {
            $data['bukti'] = $request->file('bukti')->store('bukti/pemasukan', 'public');
        }

        Pemasukan::create($data);
        return redirect()->route('bendahara.pemasukan.index')->with('success', 'Data Pemasukan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pemasukan = Pemasukan::findOrFail($id);
        return view('bendahara.pemasukan.form', compact('pemasukan'));
    }

    public function update(Request $request, $id)
    {
        $pemasukan = Pemasukan::findOrFail($id);

        if ($request->has('nominal')) {
            $request->merge(['nominal' => str_replace('.', '', $request->nominal)]);
        }

        $request->validate([
            'tanggal' => 'required|date',
            'nominal' => 'required|numeric|min:0',
            'keterangan' => 'required|string|max:255',
            'kategori_id' => 'nullable',
            'kategori_baru' => 'required_without:kategori_id|nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('bukti', 'kategori_baru');
        $data['kategori_id'] = $this->resolveKategoriId($request);

        if ($request->hasFile('bukti')) {
            if ($pemasukan->bukti) {
                Storage::disk('public')->delete($pemasukan->bukti);
            }
            $data['bukti'] = $request->file('bukti')->store('bukti/pemasukan', 'public');
        }

        $pemasukan->update($data);
        return redirect()->route('bendahara.pemasukan.index')->with('success', 'Data Pemasukan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pemasukan = Pemasukan::findOrFail($id);
        if ($pemasukan->bukti) {
            Storage::disk('public')->delete($pemasukan->bukti);
        }
        $pemasukan->delete();
        return redirect()->route('bendahara.pemasukan.index')->with('success', 'Data Pemasukan berhasil dihapus.');
    }

    private function resolveKategoriId(Request $request): int
    {
        if ($request->filled('kategori_id')) {
            return (int) $request->kategori_id;
        }

        return Kategori::firstOrCreate([
            'nama' => trim($request->kategori_baru),
            'tipe' => 'pemasukan'
        ])->id;
    }
}
