<?php

namespace App\Http\Controllers;

use App\Imports\ImportTagihan;
use App\Models\Spp;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class SppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Spp";
        $spp = Spp::get();
        $menu = 'Pembayaran';
        return view('data_keuangan.data_spp',compact(
            'title','spp','menu'
        ));
    }

    /**
     * Display a create page of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'tahun_ajaran'=>'required',
            'nominal'=>'required',
        ];

        $customMessages = [
            'tahun_ajaran.required' => 'Tahun Ajaran Harus Diisi',
            'nominal.required' => 'Nominal Harus Diisi'
        ];

        $this->validate($request, $rules, $customMessages);

        Spp::create([
            'tahun_ajaran'=>$request->tahun_ajaran,
            'nominal_spp' => $request->nominal,
        ]);
        $notification = array(
            'message'=>"Spp Berhasil Ditambahkan",
            'alert-type'=>'success',
        );
        return redirect()->route('spp')->with($notification);
    }

    /**
     * Display the specified resource.
     *@param  \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $title = "Edit Spp";
        $spp = Spp::find($id);
        return view('data_keuangan.edit-spp',compact(
            'title','spp'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Spp $spp)
    {
        $rules = [
            'tahun_ajaran'=>'required',
            'nominal'=>'required',
        ];

        $customMessages = [
            'tahun_ajaran.required' => 'Tahun Ajaran Harus Diisi',
            'nominal.required' => 'Nominal Harus Diisi'
        ];

        $this->validate($request, $rules, $customMessages);

        $spp->update([
            'tahun_ajaran'=> $request->tahun_ajaran,
            'nominal'=> $request->nominal,
        ]);
        $notifications = array(
            'message'=>"Spp has been updated",
            'alert-type'=>'success',
        );
        return redirect()->route('spp')->with($notifications);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
    }

    public function export_excel()
	{
		return Excel::download(new ExportFormatTagihan, 'tagihan.xlsx');
	}

    public function import_excel(Request $request)
    {
        $file = $request->file('file');

        $nama_file = rand().$file->getClientOriginalName();

        $file->move('file_tagihan',$nama_file);

        Excel::import(new ImportTagihan, public_path('/file_tagihan/'.$nama_file));

        $notification = array(
            'message'=>"Data Siswa Berhasil Di Import",
            'alert-type'=>'success',
        );
        return back()->with($notification);

        return redirect('/siswa');
    }
}
