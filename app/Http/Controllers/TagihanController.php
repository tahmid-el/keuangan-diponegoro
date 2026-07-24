<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\JenisTagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kelas;
use App\Models\JenisPembayaran;
use App\Models\TahunAjaran;
use App\Models\Siswa;

class TagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tagihan = Tagihan::with([
            'kelas',
            'jenisPembayaran',
            'tahunAjaran',
            'jenisTagihan',
        ])
            ->where('diarsipkan', 0)
            ->latest()
            ->paginate(10);

        return view('bendahara.tagihan.index', compact('tagihan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();

        $jenisPembayaran = DB::table('jenis_pembayarans')->orderBy('nama')->get();

        $tahunAjaran = TahunAjaran::orderBy('nama')->get();

        $jenisTagihan = JenisTagihan::orderBy('nama_tagihan')->get();

        
        return view(
            'bendahara.tagihan.tambah_tagihan',
            compact(
                'kelas', 
                'jenisPembayaran', 
                'tahunAjaran', 
                'jenisTagihan'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::table('tagihans')->insert([
            'kelas_id' => $request->kelas_id,
            'jenis_pembayaran_id' => $request->jenis_pembayaran_id,
            'tahun_ajaran_id'     => $request->tahun_ajaran_id,
            'jenis_tagihan_id' => $request->jenis_tagihan_id,
            'nominal' => $request->nominal,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('bendahara.tagihan.index')
            ->with('success', 'Tagihan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tagihan $tagihan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tagihan $tagihan)
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $jenisPembayaran = JenisPembayaran::orderBy('nama')->get();
        $tahunAjaran = TahunAjaran::orderBy('nama')->get();
        $jenisTagihan = DB::table('jenis_tagihan')->orderBy('nama_tagihan')->get();

        return view(
            'bendahara.tagihan.edit_tagihan',
            compact(
                'tagihan',
                'kelas',
                'jenisPembayaran',
                'tahunAjaran',
                'jenisTagihan'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tagihan $tagihan)
    {
        $request->validate([
        'kelas_id' => 'required',
        'jenis_pembayaran_id' => 'required',
        'tahun_ajaran_id' => 'required',
        'jenis_tagihan_id' => 'required',
        'nominal' => 'required|numeric|min:0',
        ]);

        $tagihan->update([
            'kelas_id' => $request->kelas_id,
            'jenis_pembayaran_id' => $request->jenis_pembayaran_id,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
            'jenis_tagihan_id' => $request->jenis_tagihan_id,
            'nominal' => $request->nominal,
        ]);

        return redirect()
            ->route('bendahara.tagihan.index')
            ->with('success', 'Tagihan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function arsip(Tagihan $tagihan)
    {
        $tagihan->update([
            'diarsipkan' => 1
        ]);

        return redirect()
            ->route('bendahara.tagihan.index')
            ->with('success', 'Tagihan berhasil diarsipkan.');
    }
}
