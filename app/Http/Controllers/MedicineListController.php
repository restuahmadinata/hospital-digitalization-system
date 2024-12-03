<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicineListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if(Auth::check()) {
            if (Auth::user()->role == 'admin') {
                $filter = $request->input('filter');
                $search = $request->input('search');

                $query = Obat::query();
        
                if ($filter == 'tersedia') {
                    $query->where('stok', '>', 0);
                } elseif ($filter == 'tidak_tersedia') {
                    $query->where('stok', '=', 0);
                } elseif ($filter == 'kadaluarsa') {
                    $query->where('kedaluwarsa', '<', now());
                }

                if ($search) {
                    $query->where('nama_obat', 'like', '%' . $search . '%');
                }
        
                $obats = $query->paginate(10);
        
                return view('admin.medicine-list.index', ['obats' => $obats, 'filter' => $filter, 'search' => $search]);
            } else {
                return redirect('login');
            }
        } 
    }

    public function create()
    {
        return view('admin.medicine-list.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_obat' => 'required|string|max:255|unique:obat,nama_obat',
            'deskripsi' => 'required|string',
            'tipe_obat' => 'required|in:keras,biasa',
            'stok' => 'required|integer|min:0',
            'gambar_obat' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kedaluwarsa' => 'required|date',
        ]);

        if ($request->hasFile('gambar_obat')) {
            $file = $request->file('gambar_obat');
            $fileName = 'gambar_obat_' . Str::slug($request->nama_obat) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/medicines'), $fileName);
            $validatedData['gambar_obat'] = 'images/medicines/' . $fileName;
        } else {
            // Use default placeholder image
            $validatedData['gambar_obat'] = 'images/medicines/gambar_obat_placeholder.jpg';
        }

        Obat::create($validatedData);

        return redirect()->route('medicine.index')->with('success', 'Obat berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $obat = Obat::findOrFail($id);
        return view('admin.medicine-list.edit', ['obat' => $obat]);
    }

    public function update(Request $request, $id)
    {
        $obat = Obat::findOrFail($id);

        $validatedData = $request->validate([
            'nama_obat' => 'required|string|max:255|unique:obat,nama_obat,' . $id,
            'deskripsi' => 'required|string',
            'tipe_obat' => 'required|in:keras,biasa',
            'stok' => 'required|integer|min:0',
            'gambar_obat' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kedaluwarsa' => 'required|date',
        ]);

        if ($request->hasFile('gambar_obat')) {
            $file = $request->file('gambar_obat');
            $fileName = 'gambar_obat_' . Str::slug($request->nama_obat) . '.' . $file->getClientOriginalExtension();
            
            // Delete old image if exists
            if ($obat->gambar_obat && file_exists(public_path($obat->gambar_obat)) && $obat->gambar_obat !== 'images/medicines/gambar_obat_placeholder.jpg') {
                unlink(public_path($obat->gambar_obat));
            }
            
            // Save to public/images directory
            $file->move(public_path('images/medicines/'), $fileName);
            
            // Save the path in database
            $validatedData['gambar_obat'] = 'images/medicines/' . $fileName;
        }

        $obat->update($validatedData);

        return redirect()->route('medicine.index')->with('success', 'Obat berhasil diupdate.');
    }

    public function destroy($id)
    {
        $obat = Obat::findOrFail($id);
        
        // Delete image file if exists and is not the placeholder
        if ($obat->gambar_obat && file_exists(public_path($obat->gambar_obat)) && $obat->gambar_obat !== 'images/gambar_obat_placeholder.jpg') {
            unlink(public_path($obat->gambar_obat));
        }
        
        $obat->delete();
        return redirect()->route('medicine.index')->with('success', 'Obat berhasil dihapus.');
    }
}