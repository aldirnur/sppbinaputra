<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(){
        $title = "Laporan";
        $keuangan = Keuangan::get();
        $uang_masuk = Keuangan::where('nominal_kas' ,'!=' ,'0' )->get();
        $total_keluar = $keuangan->sum('nominal_kas');
        $total_cash = $uang_masuk->sum('nominal_kas');

        $total_masuk = $keuangan->sum('nominal_kas');
        $saldo = $total_cash;
        $title = "Laporan Keuangan";
        $menu = '';
            return view('data_report.report',compact('uang_masuk','title','total_cash','saldo', 'menu'));
    }

    public function getData(Request $request){
        $this->validate($request,[
            'from_date'=>'required',
            'to_date'=>'required',
            'resource'=>'required',
        ]);
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $keuangan = Keuangan::get();
        if ($request->resource == 'pemasukan'){
            $uang_masuk = Keuangan::where('nominal_kas' ,'!=' ,'0' )->whereBetween(DB::raw('DATE(created_at)'), array($from_date, $to_date))->get();
            $total_keluar = $keuangan->sum('nominal_kas');
            $total_cash = $uang_masuk->sum('nominal_kas');

            $total_masuk = $keuangan->sum('nominal_kas');
            $saldo = $total_cash;
            $title = "Laporan Keuangan";
            $menu = '';
            return view('data_report.report',compact('uang_masuk','title','total_cash','saldo', 'menu'));
        }
        if($request->resource == "pengeluaran"){
            $uang_keluar = Keuangan::where('uang_keluar' ,'>' ,'0' )->whereBetween(DB::raw('DATE(created_at)'), array($from_date, $to_date))->get();
            $total_keluar = $keuangan->sum('uang_keluar');
            $total_cash = $uang_keluar->sum('uang_keluar');

            $total_masuk = $keuangan->sum('uang_masuk');
            $saldo = $total_masuk - $total_keluar;
            $title = "Laporan Keuangan";
            return view('keuangan.reports',compact('uang_keluar','title','saldo','total_cash'));
        }
    }
}
