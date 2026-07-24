<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\TahunAjaran;
use App\Models\JenisPembayaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    /**
     * Tampilkan daftar pembayaran
     */
    public function index()
    {
        $pembayarans = DB::table('pembayarans')
            ->join('siswa', 'pembayarans.siswa_id', '=', 'siswa.id')
            ->join('tagihans', 'pembayarans.tagihan_id', '=', 'tagihans.id')
            ->join('jenis_pembayarans', 'pembayarans.jenis_pembayaran_id', '=', 'jenis_pembayarans.id')
            ->select(
                'pembayarans.*',
                'siswa.nama_siswa',
                'siswa.nis',
                'jenis_pembayarans.nama as nama_pembayaran',
                'tagihans.nominal',
            )
            ->orderBy('pembayarans.created_at', 'desc')
            ->get();

        return view('bendahara.pembayaran.index', compact('pembayarans'));
    }

    /**
     * Form tambah pembayaran
     */
    public function create()
    {
        $siswa = DB::table('siswa')
            ->orderBy('nama_siswa')
            ->get();

        $tahunAjaran = DB::table('tahun_ajarans')
            ->orderByDesc('id')
            ->get();

        $jenisPembayaran = DB::table('jenis_pembayarans')
            ->orderBy('nama')
            ->get();

        return view(
            'bendahara.pembayaran.create',
            compact(
                'siswa',
                'tahunAjaran',
                'jenisPembayaran'
            )
        );
    }

    public function cariSiswa(Request $request)
    {
        $request->validate([
            'nis' => 'required'
        ]);

        $siswa = DB::table('siswa')
            ->where('nis', $request->nis)
            ->first();

        if (!$siswa) {
            return back()->with('error', 'Siswa tidak ditemukan.');
        }

        $tagihan = DB::table('tagihans')
            ->join('jenis_pembayarans', 'tagihans.jenis_pembayaran_id', '=', 'jenis_pembayarans.id')
            ->join('jenis_tagihan', 'tagihans.jenis_tagihan_id', '=', 'jenis_tagihan.id')
            ->where('tagihans.kelas_id', $siswa->kelas_id)
            ->select(
                'tagihans.id', 'tagihans.nominal','tagihans.periode',
                'jenis_pembayarans.nama as jenis_pembayaran',
                'jenis_tagihan.nama_tagihan'
            )
            ->get();

        return view(
            'bendahara.pembayaran.create',
            compact('siswa', 'tagihan')
        );
    }

    /**
     * Simpan pembayaran
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_pembayaran_id' => 'required|exists:jenis_pembayarans,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'no_kwitansi' => 'required|unique:pembayarans,no_kwitansi',
            'tanggal_bayar' => 'required|date',
            'nominal' => 'required|numeric|min:1',
        ]);

        $siswa = DB::table('siswa')
            ->where('id', $request->siswa_id)
            ->first();

        if (!$siswa) {

            return back()
                ->withInput()
                ->withErrors([
                    'siswa_id' => 'Siswa tidak ditemukan.'
                ]);

        }

        $tagihan = Tagihan::where('kelas_id', $siswa->kelas_id)
            ->where('jenis_pembayaran_id', $request->jenis_pembayaran_id)
            ->where('tahun_ajaran_id', $request->tahun_ajaran_id)
            ->where('jenis_tagihan_id', $siswa->jenis_tagihan_id)
            ->first();

        if (!$tagihan) {
            return back()
                ->withInput()
                ->withErrors([
                    'tagihan' => 'Tagihan siswa tidak ditemukan.'
                ]);
        }

        // Total pembayaran sebelumnya
        $totalTerbayar = DB::table('pembayarans')
            ->where('siswa_id', $request->siswa_id)
            ->where('tagihan_id', $tagihan->id)
            ->sum('nominal');

        // Sisa tagihan
        $sisa = $tagihan->nominal - $totalTerbayar;

        // Sudah lunas
        if ($sisa <= 0) {
            return back()
                ->withInput()
                ->withErrors([
                    'nominal' => 'Tagihan ini sudah lunas.'
                ]);
        }

        // Nominal melebihi sisa tagihan
        if ($request->nominal > $sisa) {
            return back()
                ->withInput()
                ->withErrors([
                    'nominal' => 'Nominal melebihi sisa tagihan. Sisa tagihan hanya Rp '.number_format($sisa,0,',','.')
                ]);
        }

        $totalSetelahBayar = $totalTerbayar + $request->nominal;

        $status = $request->nominal >= $tagihan->nominal
            ? 'lunas'
            : 'cicilan';

        $tahunAjaran = DB::table('tahun_ajarans')
            ->where('id', $request->tahun_ajaran_id)
            ->first();

        DB::table('pembayarans')->insert([

            'siswa_id' => $request->siswa_id,

            'tagihan_id' => $tagihan->id,

            'jenis_pembayaran_id' => $request->jenis_pembayaran_id,

            'user_id' => Auth::id(),

            'no_kwitansi' => $request->no_kwitansi,

            'tanggal_bayar' => $request->tanggal_bayar,

            'nominal' => $request->nominal,

            'periode' => $tahunAjaran->nama,

            'status' => $status,

            'keterangan' => $request->keterangan,

            'created_at' => now(),

            'updated_at' => now(),

        ]);

        return redirect()
            ->route('bendahara.pembayaran.index')
            ->with('success', 'Pembayaran berhasil ditambahkan.');
    }

    /**
     * Form edit pembayaran
     */
    public function edit($id)
    {
        $pembayaran = DB::table('pembayarans')
            ->join('siswa', 'pembayarans.siswa_id', '=', 'siswa.id')
            ->join('tagihans', 'pembayarans.tagihan_id', '=', 'tagihans.id')
            ->join('tahun_ajarans', 'tagihans.tahun_ajaran_id', '=', 'tahun_ajarans.id')
            ->join('jenis_pembayarans', 'pembayarans.jenis_pembayaran_id', '=', 'jenis_pembayarans.id')
            ->select(
                'pembayarans.*',
                'siswa.nis',
                'siswa.nama_siswa',
                'tahun_ajarans.id as tahun_ajaran_id',
                'tahun_ajarans.nama as nama_tahun',
                'jenis_pembayarans.id as jenis_pembayaran_id',
                'jenis_pembayarans.nama as nama_jenis',
                'tagihans.nominal as nominal_tagihan',
            )
            ->where('pembayarans.id', $id)
            ->first();

        if (!$pembayaran) {
            abort(404, 'Data pembayaran tidak ditemukan.');
        }

        return view('bendahara.pembayaran.edit', compact('pembayaran'));
    }

    /**
     * Update pembayaran
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'no_kwitansi'   => 'required|max:30',
            'tanggal_bayar' => 'required|date',
            'nominal'       => 'required|numeric|min:1',
            'periode'       => 'required',
        ]);

        // Data pembayaran yang diedit
        $pembayaran = DB::table('pembayarans')
            ->where('id', $id)
            ->first();

        // Data tagihan
        $tagihan = DB::table('tagihans')
            ->where('id', $pembayaran->tagihan_id)
            ->first();

        // Total pembayaran selain yang sedang diedit
        $total = DB::table('pembayarans')
            ->where('tagihan_id', $pembayaran->tagihan_id)
            ->where('siswa_id', $pembayaran->siswa_id)
            ->where('id', '<>', $id)
            ->sum('nominal');

        $total += $request->nominal;


        $status = $total >= $tagihan->nominal
            ? 'lunas'
            : 'cicilan';

        DB::table('pembayarans')
            ->where('id', $id)
            ->update([
                'no_kwitansi'   => $request->no_kwitansi,
                'tanggal_bayar' => $request->tanggal_bayar,
                'nominal'       => $request->nominal,
                'periode'       => $request->periode,
                'keterangan'    => $request->keterangan,
                'status'        => $status,
                'updated_at'    => now(),
            ]);

        return redirect()
            ->route('bendahara.pembayaran.index')
            ->with('success', 'Pembayaran berhasil diupdate.');
    }

    /**
     * Hapus pembayaran
     */
    public function destroy($id)
    {
        DB::table('pembayarans')->where('id', $id)->delete();

        return redirect()->route('bendahara.pembayaran.index')
            ->with('success', 'Pembayaran berhasil dihapus');
    }
}