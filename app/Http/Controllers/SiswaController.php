<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
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
        $kelasList    = Kelas::orderBy('tingkat')->orderBy('nama_kelas')->get();
        $tahunAktif   = TahunAjaran::aktif();

        $query = Siswa::with(['kelas', 'tahunAjaran'])
                      ->orderBy('nama_siswa');

        // Filter tahun ajaran
        if ($request->filled('tahun_ajaran_id')) {
            $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        } elseif ($tahunAktif) {
            $query->where('tahun_ajaran_id', $tahunAktif->id);
        }

        // Filter kelas
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pencarian nama / NIS
        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('nama_siswa', 'like', "%$cari%")
                  ->orWhere('nis', 'like', "%$cari%");
            });
        }

        $siswa = $query->paginate(20)->withQueryString();

        return view('bendahara.index_data_siswa', compact('siswa', 'tahunAjarans', 'kelasList', 'tahunAktif'));
    }

    // ──────────────────────────────────────────────
    // FORM TAMBAH SISWA BARU (angkatan baru)
    // ──────────────────────────────────────────────
    public function tambahBaru()
    {
        $kelasList    = Kelas::where('tingkat', 7)->orderBy('nama_kelas')->get();
        $tahunAktif   = TahunAjaran::aktif();
        return view('tambah_siswa_baru', compact('kelasList', 'tahunAktif'));
    }

    // ──────────────────────────────────────────────
    // SIMPAN SISWA BARU
    // ──────────────────────────────────────────────
    public function simpanBaru(Request $request)
    {
        $request->validate([
            'siswa'                => 'required|array|min:1',
            'siswa.*.nis'          => 'required|string|distinct',
            'siswa.*.nama_siswa'   => 'required|string|max:255',
            'siswa.*.jenis_kelamin'=> 'required|in:L,P',
            'siswa.*.orang_tua'    => 'nullable|string|max:255',
            'siswa.*.telepon'      => 'nullable|string|max:20',
            'siswa.*.alamat'       => 'nullable|string',
            'kelas_id'             => 'required|exists:kelas,id',
        ], [
            'siswa.required'    => 'Minimal isi 1 data siswa.',
            'kelas_id.required' => 'Kelas wajib dipilih.',
        ]);

        $tahunAktif = TahunAjaran::aktif();

        if (!$tahunAktif) {
            return back()->withErrors(['error' => 'Tidak ada tahun ajaran aktif. Hubungi administrator.']);
        }

        dd($request->all());

        DB::transaction(function () use ($request, $tahunAktif) {
            foreach ($request->siswa as $data) {
                // Lewati baris kosong
                if (empty($data['nis']) || empty($data['nama_siswa'])) continue;

                // Cek NIS sudah ada atau belum
                if (Siswa::where('nis', $data['nis'])->exists()) continue;

                // Simpan data siswa
                $siswa = Siswa::create([
                    'nis'            => $data['nis'],
                    'nama_siswa'     => strtoupper($data['nama_siswa']),
                    'jenis_kelamin'  => $data['jenis_kelamin'] ?? 'Laki-laki',
                    'orang_tua'      => $data['orang_tua'] ?? null,
                    'telepon'        => $data['telepon'] ?? null,
                    'alamat'         => $data['alamat'] ?? null,
                    'tahun_masuk'    => date('Y'),
                    'kelas_id'       => $request->kelas_id,
                    'tahun_ajaran_id'=> $tahunAktif->id,
                    'status'         => 'aktif',
                ]);

                // Buat akun login otomatis untuk siswa
                $user = User::create([
                    'name'     => $siswa->nama_siswa,
                    'email'    => $siswa->nis . '@diponegoro.sch.id',
                    'password' => Hash::make($siswa->nis),
                    'role'     => 'siswa',
                    'siswa_id' => $siswa->id,
                ]);

                // Buat rekening tabungan otomatis
                Tabungan::create([
                    'siswa_id' => $siswa->id,
                    'saldo'    => 0,
                ]);
            }
        });

        return redirect()->route('bendahara.siswa.index')
                         ->with('success', 'Data siswa baru berhasil ditambahkan!');
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

        return view('tambah_siswa_lama', compact('kelasList', 'tahunAktif', 'tahunAjarans', 'siswaLama', 'tahunLama'));
    }

    // ──────────────────────────────────────────────
    // SIMPAN SISWA LAMA (naik kelas)
    // ──────────────────────────────────────────────
    public function simpanLama(Request $request)
    {
        $request->validate([
            'siswa_ids'   => 'required|array|min:1',
            'siswa_ids.*' => 'exists:siswa,id',
            'kelas_id'    => 'required|exists:kelas,id',
        ], [
            'siswa_ids.required' => 'Pilih minimal 1 siswa.',
            'kelas_id.required'  => 'Kelas tujuan wajib dipilih.',
        ]);

        $tahunAktif = TahunAjaran::aktif();

        if (!$tahunAktif) {
            return back()->withErrors(['error' => 'Tidak ada tahun ajaran aktif.']);
        }

        DB::transaction(function () use ($request, $tahunAktif) {
            foreach ($request->siswa_ids as $siswaId) {
                $siswa = Siswa::find($siswaId);
                if (!$siswa) continue;

                // Update kelas dan tahun ajaran
                $siswa->update([
                    'kelas_id'        => $request->kelas_id,
                    'tahun_ajaran_id' => $tahunAktif->id,
                    'status'          => 'aktif',
                ]);
            }
        });

        return redirect()->route('bendahara.siswa.index')
                         ->with('success', 'Data siswa lama berhasil dipindahkan ke tahun ajaran baru!');
    }

    // ──────────────────────────────────────────────
    // FORM EDIT SISWA
    // ──────────────────────────────────────────────
    public function edit(Siswa $siswa)
    {
        $kelasList    = Kelas::orderBy('tingkat')->orderBy('nama_kelas')->get();
        $tahunAjarans = TahunAjaran::orderByDesc('nama')->get();
        return view('edit_data_siswa', compact('siswa', 'kelasList', 'tahunAjarans'));
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
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'status'          => 'required|in:aktif,lulus,pindah,nonaktif',
        ]);

        $siswa->update([
            'nis'             => $request->nis,
            'nama_siswa'      => strtoupper($request->nama_siswa),
            'jenis_kelamin'   => $request->jenis_kelamin,
            'orang_tua'       => $request->nama_ortu,
            'telepon'         => $request->telepon,
            'alamat'          => $request->alamat,
            'kelas_id'        => $request->kelas_id,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
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
            'status' => 'required|in:lulus,pindah,nonaktif',
        ]);

        $siswa->update(['status' => $request->status]);

        return redirect()->route('bendahara.siswa.index')
                         ->with('success', 'Status siswa berhasil diperbarui!');
    }

    // ──────────────────────────────────────────────
    // HAPUS SISWA
    // ──────────────────────────────────────────────
    public function hapus(Siswa $siswa)
    {
        // Hapus akun user siswa juga
        if ($siswa->user) {
            $siswa->user->delete();
        }

        $siswa->delete();

        return redirect()->route('bendahara.siswa.index')
                         ->with('success', 'Data siswa berhasil dihapus!');
    }
}