<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\JenisTagihan;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\Tabungan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    // ──────────────────────────────────────────────
    // DAFTAR SISWA
    // ──────────────────────────────────────────────
    public function index(Request $request)
    {
        $tahunAjarans = TahunAjaran::orderByDesc('nama')->get();
        $kelasList    = Kelas::orderBy('tingkat')
                            ->orderBy('nama_kelas')
                            ->get();

        $tahunAktif = TahunAjaran::aktif();

        $query = Siswa::with([
            'kelas',
            'tahunAjaran',
            'jenisTagihan'
        ])->orderBy('nama_siswa');

        // Filter hanya jika user memilih
        if ($request->filled('tahun_ajaran_id')) {
            $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        }

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('cari')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_siswa', 'like', "%{$request->cari}%")
                ->orWhere('nis', 'like', "%{$request->cari}%");
            });
        }

        $siswa = $query->paginate(20)->withQueryString();

        return view(
            'bendahara.data_siswa.index',
            compact(
                'siswa',
                'tahunAjarans',
                'kelasList',
                'tahunAktif'
            )
        );
    }

    // ──────────────────────────────────────────────
    // FORM TAMBAH SISWA BARU (angkatan baru)
    // ──────────────────────────────────────────────
    public function tambahBaru()
    {
        $kelas = Kelas::where('tingkat', 7)
                ->orderBy('nama_kelas')
                ->get();

        $tahunAktif = TahunAjaran::aktif();

        $jenisTagihan = JenisTagihan::orderBy('nama_tagihan')
                            ->get();

        return view(
            'bendahara.data_siswa.tambah_siswa_baru',
            compact(
                'kelas',
                'tahunAktif',
                'jenisTagihan'
            )
        );
    }

    // ──────────────────────────────────────────────
    // SIMPAN SISWA BARU
    // ──────────────────────────────────────────────
    public function simpanBaru(Request $request)
    {
        
        $request->validate([
            'siswa'                  => 'required|array|min:1',
            'siswa.*.nis'            => 'nullable|string|max:50',
            'siswa.*.nama_siswa'     => 'nullable|string|max:255',
            'siswa.*.jenis_kelamin'  => 'nullable|in:Laki-laki,Perempuan',
            'siswa.*.orang_tua'      => 'nullable|string|max:255',
            'siswa.*.telepon'        => 'nullable|string|max:20',
            'siswa.*.alamat'         => 'nullable|string',
            'siswa.*.jenis_tagihan_id' => 'nullable|exists:jenis_tagihan,id',
            'kelas_id'               => 'nullable|exists:kelas,id',
        ], [
            'siswa.required'      => 'Minimal isi 1 data siswa.',
            'kelas_id.required'   => 'Kelas wajib dipilih.',
        ]);

        $tahunAktif = TahunAjaran::aktif();

        if (!$tahunAktif) {
            return back()->withErrors([
                'error' => 'Tidak ada tahun ajaran aktif. Hubungi administrator.'
            ])->withInput();
        }

        $jumlahDataValid = 0;

        DB::transaction(function () use ($request, $tahunAktif, &$jumlahDataValid) {

            foreach ($request->siswa as $data) {

            // Lewati baris yang benar-benar kosong
            if (
                empty($data['nis']) &&
                empty($data['nama_siswa'])
            ) {
                continue;
            }

            // Jika NIS atau Nama belum diisi
            if (
                empty($data['nis']) ||
                empty($data['nama_siswa'])
            ) {
                continue;
            }

            // Kelas wajib dipilih untuk data yang akan disimpan
            if (empty($data['kelas_id'])) {
                continue;
            }

            // Cek NIS duplikat
            if (Siswa::where('nis', $data['nis'])->exists()) {
                continue;
            }

            $jumlahDataValid++;

            $siswa = Siswa::create([
                'nis'               => $data['nis'],
                'nama_siswa'        => strtoupper($data['nama_siswa']),
                'jenis_kelamin'     => $data['jenis_kelamin'] ?? 'Laki-laki',
                'orang_tua'         => $data['orang_tua'] ?? null,
                'telepon'           => $data['telepon'] ?? null,
                'alamat'            => $data['alamat'] ?? null,
                'tahun_masuk'       => date('Y'),
                'kelas_id'          => $data['kelas_id'],
                'tahun_ajaran_id'   => $tahunAktif->id,
                'jenis_tagihan_id'  => $data['jenis_tagihan_id'] ?? null,
                'status'            => 'aktif',
            ]);

            User::create([
                'name'      => $siswa->nama_siswa,
                'email'     => $siswa->nis . '@diponegoro.sch.id',
                'password'  => Hash::make($siswa->nis),
                'role'      => 'siswa',
                'siswa_id'  => $siswa->id,
            ]);

            Tabungan::create([
                'siswa_id' => $siswa->id,
                'saldo'    => 0,
            ]);
        }
        });

        if ($jumlahDataValid === 0) {
            return back()
                ->withErrors([
                    'error' => 'Minimal isi 1 data siswa yang valid.'
                ])
                ->withInput();
        }

        return redirect()
            ->route('bendahara.siswa.index')
            ->with(
                'success',
                'Data siswa angkatan baru berhasil disimpan'
            );
    }

    // ──────────────────────────────────────────────
    // FORM TAMBAH SISWA LAMA (naik kelas)
    // ──────────────────────────────────────────────
    public function tambahLama()
    {
        $kelasList     = Kelas::orderBy('tingkat')->orderBy('nama_kelas')->get();
        $tahunAjarans  = TahunAjaran::orderByDesc('nama')->get();
        $tahunAktif    = TahunAjaran::aktif();

        // Ambil siswa dari tahun ajaran sebelumnya yang belum ada di tahun aktif
        $tahunLama = TahunAjaran::where('is_aktif', false)
                                ->orderByDesc('tanggal_selesai')
                                ->first();

        $siswaLama = $tahunLama
            ? Siswa::with('kelas')
                   ->where('tahun_ajaran_id', $tahunLama->id)
                   ->where('status', 'aktif')
                   ->orderBy('nama_siswa')
                   ->get()
            : collect();

        $jenisTagihan = JenisTagihan::orderBy('nama_tagihan')->get();

        return view('bendahara.data_siswa.tambah_siswa_lama', compact('kelasList', 'tahunAktif', 'tahunAjarans', 'siswaLama', 'tahunLama', 'jenisTagihan'));
    }

    // ──────────────────────────────────────────────
    // SIMPAN SISWA LAMA (naik kelas)
    // ──────────────────────────────────────────────
   public function simpanLama(Request $request)
    {
        $request->validate([
            'siswa' => 'required|array',
        ]);

        $tahunAktif = TahunAjaran::aktif();

        if (!$tahunAktif) {
            return back()
                ->withInput()
                ->withErrors([
                    'error' => 'Tidak ada tahun ajaran aktif.'
                ]);
        }

        DB::transaction(function () use ($request, $tahunAktif) {

            foreach ($request->siswa as $item) {

                // Lewati baris yang kosong
                if (
                    empty($item['nis']) &&
                    empty($item['nama_siswa'])
                ) {
                    continue;
                }

                // Cek NIS tidak boleh sama
                if (Siswa::where('nis', $item['nis'])->exists()) {
                    continue;
                }

                Siswa::create([
                    'nis'              => $item['nis'],
                    'nama_siswa'       => $item['nama_siswa'],
                    'kelas_id'         => $item['kelas_id'],
                    'jenis_kelamin'    => $item['jenis_kelamin'],
                    'orang_tua'        => $item['orang_tua'],
                    'telepon'          => $item['telepon'],
                    'alamat'           => $item['alamat'],
                    'status'           => $item['status'] ?? 'aktif',
                    'tahun_ajaran_id'  => $tahunAktif->id,
                    'tahun_masuk' => now()->year, 
                    'jenis_tagihan_id'  => $item['jenis_tagihan_id'] ?? null,
                ]);

            }

        });

        return redirect()
            ->route('bendahara.siswa.index')
            ->with('success', 'Data siswa angkatan lama berhasil ditambahkan.');
    }

    // ──────────────────────────────────────────────
    // NAIKKAN KELAS SISWA 
    // ──────────────────────────────────────────────
    public function naikKelas(Request $request)
    {
        $request->validate([
            'kelas_tujuan' => 'required|exists:kelas,id',
            'siswa_ids'    => 'required|array|min:1',
            'siswa_ids.*'  => 'exists:siswa,id',
        ], [
            'siswa_ids.required' => 'Pilih minimal satu siswa.',
        ]);

        DB::transaction(function () use ($request) {

            Siswa::whereIn('id', $request->siswa_ids)
                ->update([
                    'kelas_id' => $request->kelas_tujuan,
                ]);

        });

        return redirect()
            ->route('bendahara.siswa.index')
            ->with('success', 'Kenaikan kelas berhasil diproses.');
    }
    // ──────────────────────────────────────────────
    // FORM EDIT SISWA
    // ──────────────────────────────────────────────
    public function edit(Siswa $siswa)
    {
        $kelasList    = Kelas::orderBy('tingkat')->orderBy('nama_kelas')->get();
        $jenisTagihan = JenisTagihan::orderBy('nama_tagihan')->get();
        $tahunAjarans = TahunAjaran::orderByDesc('nama')->get();
        return view('bendahara.data_siswa.edit', compact('siswa', 'kelasList', 'jenisTagihan', 'tahunAjarans'));
    }

    // ──────────────────────────────────────────────
    // UPDATE SISWA
    // ──────────────────────────────────────────────
    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nis'             => 'required|string|unique:siswa,nis,' . $siswa->id,
            'nama_siswa'      => 'required|string|max:255',
            'jenis_kelamin'   => 'required|in:Laki-laki,Perempuan',
            'orang_tua'       => 'nullable|string|max:255',
            'telepon'         => 'nullable|string|max:20',
            'alamat'          => 'nullable|string',
            'kelas_id'        => 'required|exists:kelas,id',
            'jenis_tagihan_id' => 'nullable|exists:jenis_tagihan,id',
            'status'          => 'required|in:aktif,lulus,pindah,nonaktif',
        ]);

        $siswa->update([
            'nis'             => $request->nis,
            'nama_siswa'      => strtoupper($request->nama_siswa),
            'jenis_kelamin'   => $request->jenis_kelamin,
            'orang_tua'       => $request->orang_tua,
            'telepon'         => $request->telepon,
            'alamat'          => $request->alamat,
            'kelas_id'        => $request->kelas_id,
            'jenis_tagihan_id'  => $request->jenis_tagihan_id,
            'status'          => $request->status,
        ]);

        // Update nama di akun user juga
        if ($siswa->user) {
            $siswa->user->update(['name' => strtoupper($request->nama_siswa)]);
        }

        return redirect()->route('bendahara.siswa.index')
                         ->with('success', 'Data siswa berhasil diperbarui!');
    }

    // ──────────────────────────────────────────────
    // ARSIPKAN SISWA (ubah status)
    // ──────────────────────────────────────────────
    public function arsip(Request $request, Siswa $siswa)
    {
        $request->validate([
            'status' => 'required|in:lulus,pindah,non-aktif',
        ]);

        $siswa->update([
            'status' => $request->status
        ]);

        return redirect()
                ->route('bendahara.data_siswa.index')
                ->with(
                    'success',
                    'Status siswa berhasil diperbarui!'
                );
    }
}