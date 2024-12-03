<?php

namespace App\Http\Controllers;

use App\Models\PenjadwalanKonsultasi;
use App\Models\User;
use App\Models\JadwalTugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenjadwalanKonsultasiController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'pasien') {
            $penjadwalan = PenjadwalanKonsultasi::where('id_pasien', Auth::id())->with('dokter')->paginate(10);
            return view('pasien.penjadwalan.index', compact('penjadwalan'));
        } elseif (Auth::user()->role == 'dokter') {
            $penjadwalan = PenjadwalanKonsultasi::where('id_dokter', Auth::id())->with('pasien')->paginate(10);
            return view('dokter.penjadwalan.index', compact('penjadwalan'));
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function create()
    {
        $dokters = User::where('role', 'dokter')->get();
        return view('pasien.penjadwalan.create', compact('dokters'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_dokter' => 'required|exists:users,id',
            'tanggal_konsultasi' => 'required|date|after:today',
        ]);

        $jadwalTugas = DB::table('jadwal_tugas')
            ->selectRaw("
                CASE hari_tugas
                    WHEN 'Senin' THEN 'Monday'
                    WHEN 'Selasa' THEN 'Tuesday'
                    WHEN 'Rabu' THEN 'Wednesday'
                    WHEN 'Kamis' THEN 'Thursday'
                    WHEN 'Jumat' THEN 'Friday'
                    WHEN 'Sabtu' THEN 'Saturday'
                    WHEN 'Minggu' THEN 'Sunday'
                    ELSE 'Unknown'
                END AS hari_tugas_english
            ")
            ->where('dokter_id', $validatedData['id_dokter'])
            ->whereRaw("
                CASE hari_tugas
                    WHEN 'Senin' THEN 'Monday'
                    WHEN 'Selasa' THEN 'Tuesday'
                    WHEN 'Rabu' THEN 'Wednesday'
                    WHEN 'Kamis' THEN 'Thursday'
                    WHEN 'Jumat' THEN 'Friday'
                    WHEN 'Sabtu' THEN 'Saturday'
                    WHEN 'Minggu' THEN 'Sunday'
                    ELSE 'Unknown'
                END = ?", [date('l', strtotime($validatedData['tanggal_konsultasi']))])
            ->exists();

        if (!$jadwalTugas) {
            return redirect()->back()->withErrors(['tanggal_konsultasi' => 'Dokter tidak tersedia pada tanggal tersebut.']);
        }

        PenjadwalanKonsultasi::create([
            'id_pasien' => Auth::id(),
            'id_dokter' => $validatedData['id_dokter'],
            'tanggal_konsultasi' => $validatedData['tanggal_konsultasi'],
        ]);

        return redirect()->route('penjadwalan.index')->with('success', 'Konsultasi berhasil dijadwalkan.');
    }

    public function approve($id)
    {
        $penjadwalan = PenjadwalanKonsultasi::findOrFail($id);
        $penjadwalan->update(['konfirmasi' => 'ya']);

        return redirect()->route('penjadwalan.index')->with('success', 'Konsultasi berhasil disetujui.');
    }

    public function destroy($id)
    {
        $penjadwalan = PenjadwalanKonsultasi::findOrFail($id);
        $penjadwalan->delete();

        return redirect()->route('penjadwalan.index')->with('success', 'Konsultasi berhasil dibatalkan.');
    }

    public function getJadwalDokter($id_dokter)
    {
        $jadwalTugas = JadwalTugas::where('dokter_id', $id_dokter)->get();
        return response()->json($jadwalTugas);
    }
}