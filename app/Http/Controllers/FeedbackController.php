<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $feedbacks = Feedback::with('dokter', 'pasien')->paginate(10);
        } elseif (Auth::user()->role == 'dokter') {
            $feedbacks = Feedback::with('dokter', 'pasien')->where('dokter_id', Auth::id())->paginate(10);
        } else {
            $feedbacks = Feedback::with('dokter', 'pasien')->where('pasien_id', Auth::id())->paginate(10);
        }

        return view('feedback.index', compact('feedbacks'));
    }

    public function create()
    {
        $dokterIdsYangSudahDiulas = Feedback::where('pasien_id', Auth::id())->pluck('dokter_id');
        $dokters = User::where('role', 'dokter')->whereNotIn('id', $dokterIdsYangSudahDiulas)->get();
        return view('feedback.create', compact('dokters'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'dokter_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'nullable|string',
        ]);

        Feedback::create([
            'dokter_id' => $validatedData['dokter_id'],
            'pasien_id' => Auth::id(),
            'rating' => $validatedData['rating'],
            'ulasan' => $validatedData['ulasan'],
        ]);

        return redirect()->route('feedback.index')->with('success', 'Feedback berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $feedback = Feedback::findOrFail($id);

        if ($feedback->pasien_id != Auth::id()) {
            return redirect()->route('feedback.index')->with('error', 'Anda tidak memiliki izin untuk mengedit feedback ini.');
        }

        return view('feedback.edit', compact('feedback'));
    }

    public function update(Request $request, $id)
    {
        $feedback = Feedback::findOrFail($id);

        if ($feedback->pasien_id != Auth::id()) {
            return redirect()->route('feedback.index')->with('error', 'Anda tidak memiliki izin untuk mengedit feedback ini.');
        }

        $validatedData = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'nullable|string',
        ]);

        $feedback->update([
            'rating' => $validatedData['rating'],
            'ulasan' => $validatedData['ulasan'],
        ]);

        return redirect()->route('feedback.index')->with('success', 'Feedback berhasil diupdate.');
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);

        if ($feedback->pasien_id != Auth::id()) {
            return redirect()->route('feedback.index')->with('error', 'Anda tidak memiliki izin untuk menghapus feedback ini.');
        }

        $feedback->delete();

        return redirect()->route('feedback.index')->with('success', 'Feedback berhasil dihapus.');
    }
}