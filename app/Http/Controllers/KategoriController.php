<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function search(Request $request)
    {
        $searchTerm = $request->input('q', '');
        $tipe = $request->input('tipe', '');

        $kategoris = Kategori::query()
            ->when($tipe, fn($query) => $query->where('tipe', $tipe))
            ->when($searchTerm, fn($query) => $query->where('nama', 'like', "%{$searchTerm}%"))
            ->orderBy('nama')
            ->limit(10)
            ->get(['id', 'nama']);

        return response()->json($kategoris);
    }
}
