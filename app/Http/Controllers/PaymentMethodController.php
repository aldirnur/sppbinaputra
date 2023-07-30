<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaymentMethod;

class PaymentMethodController extends Controller
{
    public function index(Request $request)
    {
        $title = "pembayaran";
        $payment = PaymentMethod::all();
        return view('data_keuangan.payment_method',compact(
            'title','payment',
        ));
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
            'nama'=>'required',
            'no_account'=>'required',
        ];

        $customMessages = [
            'nama'=>'required',
            'no_account.required' => 'File Harus Diisi',
        ];

        $this->validate($request, $rules, $customMessages);

        
        $payment = New PaymentMethod();
        $payment->nama = $request->nama;
        $payment->no_account = $request->no_account;
        $payment->deskripsi = $request->tata_cara;
        $payment->save();
        $notification=array(
            'message'=>"Pembayaran Berhasil",
            'alert-type'=>'success',
        );



        return back()->with($notification);
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:6|max:12|required_with:current_password',
            // 'password_confirmation' => 'nullable|min:8|max:12|required_with:new_password|same:new_password'
        ]);

        $id = $request->id;
        $siswa = Siswa::find($id);
        $siswa->pin = $request->input('new_password');
        $siswa->save();

        return redirect()->to('/profile/'.$siswa->nisn)->withSuccess('Pin Berhasil Di Perbarui.');
        // return redirect()->route('profile')->withSuccess('Profile updated successfully.');
    }

    public function getTagihan(Request $request)
    {
        $id = $request->id;
        $payment = PaymentMethod::find($id);
       
        return response()->json(['status' => 'success', 'text' => $payment->deskripsi]);
    }
}
