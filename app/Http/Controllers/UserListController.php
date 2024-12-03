<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dokter;
use App\Models\RekamMedis;
use App\Models\JadwalTugas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserListController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'admin') {
            $query = User::query();

            if ($request->has('role') && $request->role != '') {
                $query->where('role', $request->role);
            }

            if ($request->has('date') && $request->date != '') {
                $query->whereDate('created_at', $request->date);
            }

            if ($request->has('search') && $request->search != '') {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('email', 'like', '%' . $request->search . '%');
                });
            }

            $users = $query->paginate(10);
            return view('admin.user-list.index', ['users' => $users]);
        } elseif (Auth::user()->role == 'dokter') {
            $search = $request->input('search');
            $dokterId = Auth::user()->id;

            $query = RekamMedis::with('pasien')
                ->select('pasien_id')
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
            } else {
                return redirect('login');
            }
        }
    }

    public function create()
    {
        if (Auth::user()->role == 'admin') {
            return view('admin.user-list.create');
        } else {
            return redirect('login');
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            // Validasi data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'tanggal_lahir' => 'required|date|before_or_equal:today',
            'jenis_kelamin' => 'required|string',
            'role' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
            'jenis_dokter' => 'required_if:role,dokter|string',
            'spesialisasi' => $request->input('jenis_dokter') === 'spesialis' ? 'required|string' : 'nullable',
            'hari_tugas' => 'required_if:role,dokter|array',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto
        ]);

        // Upload foto jika ada
        $fotoPath = 'images/user_placeholder.png';
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = Str::slug($validatedData['name']) . '_' . $validatedData['role'] . '.' . $file->getClientOriginalExtension();
            $fotoPath = 'images/users/' . $filename;
            $file->move(public_path('images/users'), $filename);
        }

        $user = User::create([
            'name' => $validatedData['name'],
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'tanggal_lahir' => $validatedData['tanggal_lahir'],
            'jenis_kelamin' => $validatedData['jenis_kelamin'],
            'role' => $validatedData['role'],
            'password' => Hash::make($validatedData['password']),
            'foto' => $fotoPath, // Simpan path foto
        ]);

        if ($validatedData['role'] === 'dokter') {
            $dokter = new Dokter([
                'jenis_dokter' => $validatedData['jenis_dokter'],
                'spesialisasi' => $validatedData['jenis_dokter'] === 'spesialis' ? $validatedData['spesialisasi'] : null,
            ]);
            $user->dokter()->save($dokter);

            // Simpan jadwal tugas dokter
            if (!empty($validatedData['hari_tugas'])) {
                foreach ($validatedData['hari_tugas'] as $hari) {
                    JadwalTugas::create([
                        'dokter_id' => $user->id,
                        'hari_tugas' => $hari,
                    ]);
                }
            }
        }

        return redirect()->route('user.index')->with('success', 'Pengguna berhasil ditambahkan.');
        } else {
            return redirect('login');
        }
    }
    
    public function edit($id)
    {
        if (Auth::user()->role == 'admin') {
            // $user = User::with('dokter.jadwalTugas')->findOrFail($id);
            $user = User::findOrFail($id);
            $jadwal = JadwalTugas::where('dokter_id', $id)->get();
            return view('admin.user-list.edit', ['user' => $user], ['jadwal' => $jadwal]);
        } else {
            return redirect('login');
        }
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role == 'admin') {
            $user = User::with('dokter.jadwalTugas')->findOrFail($id);

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username,' . $user->id,
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'tanggal_lahir' => 'required|date|before_or_equal:today',
                'jenis_kelamin' => 'required|string',
                'role' => 'required|string',
                'password' => 'nullable|string|min:8|confirmed',
                'jenis_dokter' => 'required_if:role,dokter|string',
                'spesialisasi' => $request->input('jenis_dokter') === 'spesialis' ? 'required|string' : 'nullable',
                'hari_tugas' => 'required_if:role,dokter|array',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto
            ]);

            // Upload foto jika ada
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($user->foto && $user->foto !== 'images/user_placeholder.png') {
                    Storage::disk('public')->delete($user->foto);
                }

                // Simpan gambar baru
                $file = $request->file('foto');
                $filename = Str::slug($validatedData['name']) . '_' . $validatedData['role'] . '.' . $file->getClientOriginalExtension();
                $fotoPath = 'images/users/' . $filename;
                $file->move(public_path('images/users'), $filename);
                $validatedData['foto'] = $fotoPath;
            }

            $user->update($validatedData);

            if (!empty($validatedData['password'])) {
                $user->update(['password' => Hash::make($validatedData['password'])]);
            }

            if ($validatedData['role'] === 'dokter') {
                if ($user->dokter) {
                    $user->dokter->update([
                        'jenis_dokter' => $validatedData['jenis_dokter'],
                        'spesialisasi' => $validatedData['jenis_dokter'] === 'spesialis' ? $validatedData['spesialisasi'] : null,
                    ]);
                } else {
                    $dokter = new Dokter([
                        'jenis_dokter' => $validatedData['jenis_dokter'],
                        'spesialisasi' => $validatedData['jenis_dokter'] === 'spesialis' ? $validatedData['spesialisasi'] : null,
                    ]);
                    $user->dokter()->save($dokter);
                }

                // Update jadwal tugas dokter
                JadwalTugas::where('dokter_id', $user->id)->delete();
                if (!empty($validatedData['hari_tugas'])) {
                    foreach ($validatedData['hari_tugas'] as $hari) {
                        JadwalTugas::create([
                            'dokter_id' => $user->id,
                            'hari_tugas' => $hari,
                        ]);
                    }
                }
            } else {
                if ($user->dokter) {
                    $user->dokter->delete();
                }
                JadwalTugas::where('dokter_id', $user->id)->delete();
            }

            return redirect()->route('user.index')->with('success', 'Pengguna berhasil diupdate.');
        } else {
            return redirect('login');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Auth::user()->role == 'admin') {
            $user = User::findOrFail($id);
            // Hapus foto jika ada
            if ($user->foto && $user->foto !== 'images/user_placeholder.png') {
                Storage::disk('public')->delete($user->foto);
            }
            $user->delete();
            return redirect()->route('user.index')->with('success', 'Data pengguna berhasil dihapus');
        } else {
            return redirect('login');
        }
    }
}