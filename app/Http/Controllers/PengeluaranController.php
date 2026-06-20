<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengeluaran::query();
        
        if ($request->filled('startdate') && $request->filled('enddate')) {
            $query->whereBetween('tanggal', [$request->startdate, $request->enddate]);
        }

        if ($request->filled('jenis_pengeluaran')) {
            $query->where('jenis_pengeluaran', $request->jenis_pengeluaran);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('keterangan', 'like', '%' . $request->search . '%')
                  ->orWhere('jenis_pengeluaran', 'like', '%' . $request->search . '%');
            });
        }
        
        $pengeluarans = $query->orderBy('tanggal', 'desc')->paginate(10);
        return view('bendahara.pengeluaran.index', compact('pengeluarans'));
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
            'jenis_pengeluaran' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('bukti');
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
            'jenis_pengeluaran' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('bukti');

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
}
