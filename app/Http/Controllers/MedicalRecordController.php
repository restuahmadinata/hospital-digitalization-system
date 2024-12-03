<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Obat;
use App\Models\User;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role == 'dokter') {
            $rekamMedis = RekamMedis::with(['pasien', 'dokter', 'obats'])->paginate(10);
            return view('dokter.medical-record.index', compact('rekamMedis'));
        } elseif (Auth::user()->role == 'pasien') {
            $rekamMedis = RekamMedis::with(['dokter', 'obats'])
                ->where('pasien_id', Auth::user()->id)
                ->paginate(10);
            return view('pasien.medical-record.medical-record', compact('rekamMedis'));
        } else {
            return redirect()->route('home');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->role == 'dokter') {
            $pasiens = User::where('role', 'pasien')->get();
            $dokters = User::where('role', 'dokter')->get();
            $obats = Obat::where('stok', '>', 0)
                        ->where('kedaluwarsa', '>', now())
                        ->get();
            return view('dokter.medical-record.create', compact('pasiens', 'dokters', 'obats'));
        } else {
            return redirect()->route('home');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'pasien_id' => 'required|exists:users,id',
            'dokter_id' => 'required|exists:users,id',
            'penyakit' => 'required|string',
            'obat_id' => 'required|array',
            'obat_id.*' => 'exists:obat,id',
            'jumlah_obat' => 'required|array',
            'jumlah_obat.*' => 'required|integer|min:1',
            'tindakan' => 'required|string',
            'tanggal_berobat' => 'required|date',
        ]);

        $tanggalBerobat = Carbon::createFromFormat('Y-m-d', $validatedData['tanggal_berobat']);
        
        DB::transaction(function () use ($validatedData, $tanggalBerobat) {
            $rekamMedis = RekamMedis::create([
                'pasien_id' => $validatedData['pasien_id'],
                'dokter_id' => $validatedData['dokter_id'],
                'penyakit' => $validatedData['penyakit'],
                'tindakan' => $validatedData['tindakan'],
                'tanggal_berobat' => $tanggalBerobat,
            ]);

            foreach ($validatedData['obat_id'] as $index => $obatId) {
                $jumlah = $validatedData['jumlah_obat'][$index];
                $rekamMedis->obats()->attach($obatId, ['jumlah' => $jumlah]);

                $obat = Obat::findOrFail($obatId);
                $obat->stok -= $jumlah;
                $obat->save();
            }
        });

        return redirect()->route('medicalrecord.index')->with('success', 'Rekam medis berhasil ditambahkan.');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $record = RekamMedis::with('obats')->findOrFail($id);
        $pasiens = User::where('role', 'pasien')->get();
        $dokters = User::where('role', 'dokter')->get();
        $obats = Obat::where('stok', '>', 0)
                    ->where('kedaluwarsa', '>', now())
                    ->get();
        return view('dokter.medical-record.edit', compact('record', 'pasiens', 'dokters', 'obats'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rekamMedis = RekamMedis::findOrFail($id);

        $validatedData = $request->validate([
            'pasien_id' => 'required|exists:users,id',
            'dokter_id' => 'required|exists:users,id',
            'penyakit' => 'required|string',
            'obat_id' => 'required|array',
            'obat_id.*' => 'exists:obat,id',
            'jumlah_obat' => 'required|array',
            'jumlah_obat.*' => 'required|integer|min:1',
            'tindakan' => 'required|string',
            'tanggal_berobat' => 'required|date',
        ]);

        $tanggalBerobat = Carbon::createFromFormat('Y-m-d', $validatedData['tanggal_berobat']);

        DB::transaction(function () use ($validatedData, $rekamMedis, $tanggalBerobat) {
            // Kembalikan stok obat sebelum menghapus relasi
            foreach ($rekamMedis->obats as $obat) {
                $obat->stok += $obat->pivot->jumlah;
                $obat->save();
            }

            $rekamMedis->obats()->detach();

            foreach ($validatedData['obat_id'] as $index => $obatId) {
                $jumlah = $validatedData['jumlah_obat'][$index];
                $rekamMedis->obats()->attach($obatId, ['jumlah' => $jumlah]);

                $obat = Obat::findOrFail($obatId);
                $obat->stok -= $jumlah;
                $obat->save();
            }

            $rekamMedis->update([
                'pasien_id' => $validatedData['pasien_id'],
                'dokter_id' => $validatedData['dokter_id'],
                'penyakit' => $validatedData['penyakit'],
                'tindakan' => $validatedData['tindakan'],
                'tanggal_berobat' => $tanggalBerobat,
            ]);
        });

        return redirect()->route('medicalrecord.index')->with('success', 'Rekam medis berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $rekamMedis = RekamMedis::findOrFail($id);

        // Hanya dokter yang membuat rekam medis yang bisa menghapusnya
        if (Auth::user()->id !== $rekamMedis->dokter_id) {
            return redirect()->route('medicalrecord.index')->with('error', 'Anda tidak memiliki izin untuk menghapus rekam medis ini.');
        }

        // Kembalikan stok obat sebelum menghapus rekam medis
        DB::transaction(function () use ($rekamMedis) {
            foreach ($rekamMedis->obats as $obat) {
                $obat->stok += $obat->pivot->jumlah;
                $obat->save();
            }

            $rekamMedis->delete();
        });

        return redirect()->route('medicalrecord.index')->with('success', 'Rekam medis berhasil dihapus.');
    }

    public function patientsHandled(Request $request)
    {
        $search = $request->input('search');
        $dokterId = Auth::user()->id;

        $query = RekamMedis::with('pasien')
            ->select('pasien_id', DB::raw('MAX(id) as id'))
            ->where('dokter_id', $dokterId)
            ->groupBy('pasien_id');

        if ($search) {
            $query->whereHas('pasien', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $patients = $query->paginate(10);

        return view('dokter.patient-list.patient-list', compact('patients', 'search'));
    }
}