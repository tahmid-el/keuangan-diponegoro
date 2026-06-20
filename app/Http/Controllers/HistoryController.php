<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\History;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = History::with('user');

        if ($request->filled('startdate') && $request->filled('enddate')) {
            $query->whereBetween('created_at', [$request->startdate . ' 00:00:00', $request->enddate . ' 23:59:59']);
        }

        if ($request->filled('aktivitas')) {
            $query->where('aktivitas', $request->aktivitas);
        }

        if ($request->filled('transaksi')) {
            $query->where('transaksi', $request->transaksi);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('keterangan', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($uq) use ($request) {
                      $uq->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $histories = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('bendahara.histori.index', compact('histories'));
    }
}
