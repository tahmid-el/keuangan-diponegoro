<?php

namespace App\Http\Controllers;

use App\Models\MutasiTabungan;
use App\Models\Siswa;
use App\Models\Tabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TabunganController extends Controller
{
    /**
     * Halaman daftar tabungan
     */
    public function index()
    {
        $tabungans = DB::table('mutasi_tabungans')
            ->join('tabungans', 'mutasi_tabungans.tabungan_id', '=', 'tabungans.id')
            ->join('siswa', 'tabungans.siswa_id', '=', 'siswa.id')
            ->select(
                'mutasi_tabungans.id',
                'mutasi_tabungans.tanggal',
                'mutasi_tabungans.jenis',
                'mutasi_tabungans.nominal',
                'mutasi_tabungans.saldo_akhir',

                'siswa.nis',
                'siswa.nama_siswa',

                'tabungans.id as tabungan_id'
            )
            ->orderByDesc('mutasi_tabungans.tanggal')
            ->orderByDesc('mutasi_tabungans.id')
            ->get();


        return view('bendahara.tabungan.index', compact('tabungans'));
    }

    /**
     * Form Tambah tabungan
     */
    public function create()
    {
        $siswas = Siswa::whereDoesntHave('tabungan')
        ->orderBy('nama_siswa')
        ->get();

        return view(
            'bendahara.tabungan.create',
            compact('siswas')
        );
    }

    /**
     * Simpan tambah tabungan
     */    
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id'   => 'required|exists:siswa,id',
            'nominal'    => 'required|numeric|min:1000',
            'tanggal'    => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        if (Tabungan::where('siswa_id', $request->siswa_id)->exists()) {
            return redirect()
                ->route('bendahara.tabungan.index')
                ->with('error', 'Siswa sudah memiliki tabungan.');
        }

        DB::transaction(function () use ($request) {
            $tabungan = Tabungan::create([
                'siswa_id' => $request->siswa_id,
                'saldo'    => $request->nominal,
            ]);
       
            MutasiTabungan::create([
                'tabungan_id' => $tabungan->id,
                'user_id'     => Auth::id(),
                'jenis'       => 'setor',
                'nominal'     => $request->nominal,
                'saldo_akhir' => $request->nominal,
                'tanggal'     => $request->tanggal,
                'keterangan'  => $request->keterangan,
            ]);
        });

        return redirect()
            ->route('bendahara.tabungan.index')
            ->with('success', 'Tabungan berhasil ditambahkan.');
    }

    /**
     * Form setor tabungan
     */
    public function setor()
    {
        $siswas = Siswa::has('tabungan')
            ->with('tabungan')
            ->orderBy('nama_siswa')
            ->get();

        return view(
            'bendahara.tabungan.setor_saldo',
            compact('siswas')
        );
    }

    /**
     * Simpan setor tabungan
     */
    public function storeSetor(Request $request)
    {
        $request->validate([
            'siswa_id'    => 'required|exists:siswa,id',
            'nominal'     => 'required|numeric|min:1000',
            'tanggal'     => 'required|date',
            'keterangan'  => 'nullable|string',
        ]);

        $tabungan = Tabungan::where('siswa_id', $request->siswa_id)->first();

        if (!$tabungan) {
            return back()
                ->withErrors([
                    'siswa_id' => 'Siswa belum memiliki tabungan. Silakan gunakan menu Tambah Tabungan terlebih dahulu.'
                ])
                ->withInput();
        }

        DB::transaction(function () use ($request, $tabungan) {

            $saldoBaru = $tabungan->saldo + $request->nominal;

            $tabungan->update([
                'saldo' => $saldoBaru
            ]);

            MutasiTabungan::create([
                'tabungan_id' => $tabungan->id,
                'user_id'     => Auth::id(),
                'jenis'       => 'setor',
                'nominal'     => $request->nominal,
                'saldo_akhir' => $saldoBaru,
                'tanggal'     => $request->tanggal,
                'keterangan'  => 'Setor Tabungan',
            ]);
        });

        return redirect()
            ->route('bendahara.tabungan.index')
            ->with('success', 'Setor tabungan berhasil.');
    }

    /**
     * Form tarik tabungan
     */
    public function tarik()
    {
        $siswas = Siswa::has('tabungan')
            ->with('tabungan')
            ->orderBy('nama_siswa')
            ->get();

        return view(
            'bendahara.tabungan.tarik_saldo',
            compact('siswas')
        );
    }

    /**
     * Simpan tarik tabungan
     */
   public function storeTarik(Request $request)
    {
        $request->validate([
            'siswa_id'    => 'required|exists:siswa,id',
            'nominal'     => 'required|numeric|min:1000',
            'tanggal'     => 'required|date',
            'keterangan'  => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {

            $tabungan = Tabungan::where('siswa_id', $request->siswa_id)->first();

            if (!$tabungan) {
                abort(422, 'Tabungan siswa belum tersedia.');
            }

            if ($tabungan->saldo < $request->nominal) {
                abort(422, 'Saldo tabungan tidak mencukupi.');
            }

            $saldoBaru = $tabungan->saldo - $request->nominal;

            $tabungan->update([
                'saldo' => $saldoBaru
            ]);

            MutasiTabungan::create([
                'tabungan_id' => $tabungan->id,
                'user_id'     => Auth::id(),
                'jenis'       => 'tarik',
                'nominal'     => $request->nominal,
                'saldo_akhir' => $saldoBaru,
                'tanggal'     => $request->tanggal,
                'keterangan'  => $request->keterangan,
            ]);

        });

        return redirect()
            ->route('bendahara.tabungan.index')
            ->with('success', 'Penarikan tabungan berhasil.');
    }

    /**
     * Detail tabungan siswa
     */
    public function show($id)
    {
        $tabungan = Tabungan::with('siswa')->findOrFail($id);

        $mutasi = MutasiTabungan::where('tabungan_id', $id)
            ->with('user')
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->get();

        return view(
            'bendahara.tabungan.detail',
            compact('tabungan', 'mutasi')
        );
    }
}