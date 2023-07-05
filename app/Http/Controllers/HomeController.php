<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Siswa;
use App\Models\Transaksi;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::count();

        $widget = [
            'users' => $users,
            //...
        ];

        $transaksi = Transaksi::whereNull('token')->get();
        $kas = Keuangan::get();
        $saldo = $kas->sum('nominal_kas');
        $siswa = Siswa::get();

        return view('home', compact('widget', 'transaksi', 'saldo', 'siswa'));
    }
}
