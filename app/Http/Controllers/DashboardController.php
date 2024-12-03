<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use App\Models\JadwalTugas;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'admin') {
                // Set locale ke bahasa Indonesia
                Carbon::setLocale('id');

                // Hari ini dalam format nama hari
                $today = Carbon::now()->isoFormat('dddd'); 

                // Dokter yang bertugas hari ini
                $dokterHariIni = JadwalTugas::where('hari_tugas', ucfirst($today))
                    ->with('dokter') // Relasi ke tabel 'users' untuk data dokter
                    ->get();

                // Total pengguna berdasarkan role
                $totalPengguna = User::selectRaw('role, COUNT(*) as total')
                    ->groupBy('role')
                    ->get();

                return view('admin.dashboard.dashboard', [
                    'dokterHariIni' => $dokterHariIni,
                    'totalPengguna' => $totalPengguna,
                ]);


            } elseif (Auth::user()->role == 'pasien') {
                $pasienId = Auth::user()->id;

                // Tindakan medis dan obat yang diberikan dokter
                $medicalRecords = RekamMedis::with(['dokter', 'obats'])
                    ->where('pasien_id', $pasienId)
                    ->orderBy('tanggal_berobat', 'desc')
                    ->take(5)
                    ->get();

                // Notifikasi otomatis untuk konsultasi lanjutan atau pengambilan obat
                $notifications = RekamMedis::with('dokter')
                    ->where('pasien_id', $pasienId)
                    ->where('tanggal_berobat', '>=', Carbon::today())
                    ->get();

                return view('pasien.dashboard.dashboard', [
                    'medicalRecords' => $medicalRecords,
                    'notifications' => $notifications,
                ]);
            } elseif (Auth::user()->role == 'dokter') {
                $dokterId = Auth::user()->id;

                // 5 pasien terbaru yang telah diperiksa
                $latestPatients = RekamMedis::with('pasien')
                    ->where('dokter_id', $dokterId)
                    ->orderBy('tanggal_berobat', 'desc')
                    ->take(5)
                    ->get();

                // Rekam medis yang sedang diproses (belum lewat tanggal hari ini)
                $ongoingRecords = RekamMedis::with('pasien')
                    ->where('dokter_id', $dokterId)
                    ->where('tanggal_berobat', '>=', Carbon::today())
                    ->get();

                return view('dokter.dashboard.dashboard', [
                    'latestPatients' => $latestPatients,
                    'ongoingRecords' => $ongoingRecords,
                ]);
            } else {
                return redirect('login');
            }
        }
    }
}