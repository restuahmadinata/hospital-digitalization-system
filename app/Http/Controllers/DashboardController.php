<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if(Auth::check()) {
            if (Auth::user()->role == 'admin') {
                return view('dashboard.admin.dashboard');
            } elseif (Auth::user()->role == 'pasien') {
                return view('dashboard.pasien.dashboard');
            } elseif (Auth::user()->role == 'dokter') {
                return view('dashboard.dokter.dashboard');
            } else {
                return redirect('login');
            }
        } 

    }
}
