<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengeluaran::with('kategori');
        $kategoris = Kategori::pengeluaran()->orderBy('nama')->get();
        
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
        
        $pengeluarans = $query->orderBy('tanggal', 'desc')->paginate(10);
        return view('bendahara.pengeluaran.index', compact('pengeluarans', 'kategoris'));
    }

    public function create()
    {
        return view('bendahara.pengeluaran.form');
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
            $data['bukti'] = $request->file('bukti')->store('bukti/pengeluaran', 'public');
        }

        Pengeluaran::create($data);
        return redirect()->route('bendahara.pengeluaran.index')->with('success', 'Data Pengeluaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        return view('bendahara.pengeluaran.form', compact('pengeluaran'));
    }

    public function update(Request $request, $id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);

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
            if ($pengeluaran->bukti) {
                Storage::disk('public')->delete($pengeluaran->bukti);
            }
            $data['bukti'] = $request->file('bukti')->store('bukti/pengeluaran', 'public');
        }

        $pengeluaran->update($data);
        return redirect()->route('bendahara.pengeluaran.index')->with('success', 'Data Pengeluaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        if ($pengeluaran->bukti) {
            Storage::disk('public')->delete($pengeluaran->bukti);
        }
        $pengeluaran->delete();
        return redirect()->route('bendahara.pengeluaran.index')->with('success', 'Data Pengeluaran berhasil dihapus.');
    }

    private function resolveKategoriId(Request $request): int
    {
        if ($request->filled('kategori_id')) {
            return (int) $request->kategori_id;
        }

        return Kategori::firstOrCreate([
            'nama' => trim($request->kategori_baru),
            'tipe' => 'pengeluaran'
        ])->id;
    }
}
