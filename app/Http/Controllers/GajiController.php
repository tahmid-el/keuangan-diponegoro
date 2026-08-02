<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use Illuminate\Http\Request;

class GajiController extends Controller
{
    public function index(Request $request)
    {
        $query = Gaji::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%'.$request->search.'%');
        }

        $gajis = $query->orderBy('nama')->paginate(10);

        return view('bendahara.gaji.index', compact('gajis'));
    }

    public function create()
    {
        return view('bendahara.gaji.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'bisyaroh' => str_replace(['.', ','], '', $request->input('bisyaroh', 0)),
            'tunjangan_kamad_wk' => str_replace(['.', ','], '', $request->input('tunjangan_kamad_wk', 0)),
            'tunjangan_piket' => str_replace(['.', ','], '', $request->input('tunjangan_piket', 0)),
        ]);

        $request->validate([
            'nama' => 'required|string|max:255|unique:gajis',
            'jumlah_jam' => 'required|integer|min:0',
            'bisyaroh' => 'required|numeric|min:0',
            'tunjangan_kamad_wk' => 'required|numeric|min:0',
            'tunjangan_piket' => 'required|numeric|min:0',
        ]);

        Gaji::create($request->all());

        return redirect()->route('bendahara.gaji.index')
            ->with('success', 'Data Gaji berhasil ditambahkan.');
    }

    public function edit(Gaji $gaji)
    {
        return view('bendahara.gaji.edit', compact('gaji'));
    }

    public function update(Request $request, Gaji $gaji)
    {
        $request->merge([
            'bisyaroh' => str_replace(['.', ','], '', $request->input('bisyaroh', 0)),
            'tunjangan_kamad_wk' => str_replace(['.', ','], '', $request->input('tunjangan_kamad_wk', 0)),
            'tunjangan_piket' => str_replace(['.', ','], '', $request->input('tunjangan_piket', 0)),
        ]);

        $request->validate([
            'nama' => 'required|string|max:255|unique:gajis,nama,'.$gaji->id,
            'jumlah_jam' => 'required|integer|min:0',
            'bisyaroh' => 'required|numeric|min:0',
            'tunjangan_kamad_wk' => 'required|numeric|min:0',
            'tunjangan_piket' => 'required|numeric|min:0',
        ]);

        $gaji->update($request->all());

        return redirect()->route('bendahara.gaji.index')
            ->with('success', 'Data Gaji berhasil diperbarui.');
    }

    public function destroy(Gaji $gaji)
    {
        $gaji->delete();

        return redirect()->route('bendahara.gaji.index')
            ->with('success', 'Data Gaji berhasil dihapus.');
    }
}
