<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Spp;
use App\Models\Tagihan;
use App\Models\Transaksi;
use Exception;
use Illuminate\Support\Facades\Hash;
use App\PaymentMethod;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request->all());
        $title = "pembayaran";
        $nisn = $request->nisn;
        $siswa = Siswa::where('nisn', $request->nisn)->where('nis', $request->nis)->first();
        $tagihan = 0;
        $transaksi = [];
        $payment_method = PaymentMethod::where('status', 1)->get();
        if ($siswa) {
            $tagihan = Tagihan::where('id_siswa', $siswa->id_siswa)->first();
            if ($tagihan) {
                $transaksi = Transaksi::where('tag_id', $tagihan->tag_id)->whereNull('token')->get();
            }
            // if (!$tagihan) {
            //     return back()->with('error_kode',"Anda Belum Memiliki Tagihan , Silahkan Hubungi Admin!!");
            // }
        } else {
            return back()->with('error_kode',"Kode Yang Anda Masukan Tidak Terdaftar!!");
        }
        // dd($siswa);
        return view('halaman_siswa.pembayaran',compact(
            'title','siswa','nisn', 'payment_method'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id_siswa)
    {
        $rules = [
            'file'=>'required',
        ];

        $customMessages = [
            'file.required' => 'File Harus Diisi',
        ];

        $this->validate($request, $rules, $customMessages);

        $random = '';
        $limit = 6;
        for($i = 0; $i < $limit; $i++) {
            $random .= mt_rand(0, 9);
        }

        $otp = '';
        $limit = 6;
        for($i = 0; $i < $limit; $i++) {
            $otp .= mt_rand(0, 9);
        }
        $cek_tagihan = Tagihan::where('id_siswa',  $id_siswa)->first();
        if ($cek_tagihan) {
            $image = $request->file('file');
            $path = public_path('/img/payment/');
            $imageName = $image->getClientOriginalName();
            $extensi = $image->getClientOriginalExtension();
            $image->move(($path), $imageName);
            if (!in_array($extensi, ['jpg', 'jpeg', 'png'])) {
                $notification=array(
                    'message'=>"Maaf, Format File Harus JPG,JPEG atau PNG",
                    'alert-type'=>'danger',
                );
                return back()->with($notification);
            }

            $code = date("d") . $random;
            $transaksi = New Transaksi();
            $transaksi->no_transaksi = $code;
            $transaksi->status_transaksi = 2;
            $transaksi->tgl = date('Y-m-d');
            $transaksi->nominal_transaksi = $request->nominal_transaksi;
            $transaksi->keterangan = $request->keterangan ? : 'Pembayaran Spp';
            $transaksi->bukti_transaksi = $imageName;
            $transaksi->tag_id = $cek_tagihan->tag_id;
            $transaksi->token = $otp;
            $transaksi->save();

            if ($transaksi->token != null) {
                try {
                    $basic  = new \Vonage\Client\Credentials\Basic("456e9aaa", "E1uwnwJgPjwQJHbY");
                    $client = new \Vonage\Client($basic);

                    $response = $client->sms()->send(
                        new \Vonage\SMS\Message\SMS($transaksi->tagihan->siswa->no_tlp, 'Verif', 'Kode Token Anda Adalah '. $otp. ' ' )
                    );

                    $message = $response->current();

                } catch (Exception $e) {
                    $notification=array(
                        'message'=> $e->getMessage(),
                        'alert-type'=>'danger',
                    );
                    return back()->with($notification);
                }

            }

            $notification=array(
                'message'=>"Maaf, Tagihan Anda Belum Terdaftar. Silahkan Hubungi Petugas",
                'alert-type'=>'popup',
            );
            // $notification=array(
            //     'message'=>"Pembayaran Berhasil",
            //     'alert-type'=>'success',
            // );
        } else {
            $notification=array(
                'message'=>"Maaf, Tagihan Anda Belum Terdaftar. Silahkan Hubungi Petugas",
                'alert-type'=>'danger',
            );
        }



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

    public function profile($id, Request $request)
    {
        // dd($request->all());
        $title = "profile";
        $nisn = $id;
        $siswa = Siswa::where('nisn', $id)->first();
        // dd($siswa);
        return view('profile',compact(
            'title','siswa', 'nisn'
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
    }

    public function getTagihan(Request $request)
    {
        $id = $request->id;
        $jumlah = $request->jumlah;
        $siswa = Siswa::find($id);
        $tagihan = Tagihan::where('id_siswa', $id)->where('jumlah', '!=', 0)->first();
        if ($tagihan) {
            $bulan = json_decode($tagihan->bulan);

            $bulan = array_map(function ($value, $index) {
                return $value;
            }, $bulan, array_keys($bulan));

            array_unshift($bulan,"");
            unset($bulan[0]);

        
            $result = [];
            for ($i = 1; $i <= $jumlah; $i++) {
                if (isset($bulan[$i])) {
                    $result[] = $bulan[$i];
                }
            }
            $resultFinal =  implode(',', $result);
        }
        


        $nominal_tagihan = 0;
        if ($tagihan) {
            $nominal_tagihan = (isset($tagihan->spp->nominal_spp) ? $tagihan->spp->nominal_spp : 0) * $jumlah  ;
            if ($tagihan->jumlah == 0) {
                return response()->json(['status' => 'failed', 'nom' => $tagihan->jumlah, 'message' => 'Maaf, Anda Sudah Tidak Memiliki Tagihan']);
            }
            if ($jumlah > $tagihan->jumlah ) {
                return response()->json(['status' => 'failed', 'nom' => $tagihan->jumlah, 'message' => 'Maaf, Jumlah Bulan Yang Anda Masukan Lebih,  Sisa Tagihan Anda Sebanyak ' . $tagihan->jumlah . ' Bulan']);
            }
        } else {
            return response()->json(['status' => 'failed', 'nom' => '0', 'message' => 'Maaf, Anda Tidak Memiliki Tagihan. Silahkan Hubungi Petugas!']);
        }
        $nominal = $nominal_tagihan;
        $nominal_tagihan = number_format($nominal_tagihan,2, ',', '.');
        return response()->json(['status' => 'success', 'nom' => $nominal_tagihan , 'bulan' => $resultFinal , 'nomin_ori' => $nominal]);
    }

    public function getSpp(Request $request)
    {
        $id = $request->id;
        $siswa = Siswa::find($id);

        $spp = Spp::where('tahun_ajaran', $siswa->angkatan)->first();

        if ($spp ) {
            $nominal_tagihan = $spp->nominal_spp;
        } else {
            $nominal_tagihan = 0;
            return response()->json(['status' => 'failed', 'nom' => 0, 'message' => 'Maaf, Data Spp Tidak Ada']);
        }

        // $jumlah = $request->jumlah;
        // $tagihan = Tagihan::where('id_siswa', $id)->first();
        // $bulan = json_decode($tagihan->bulan);

        // $bulan = array_map(function ($value, $index) {
        //     return $value;
        // }, $bulan, array_keys($bulan));

        // array_unshift($bulan,"");
        // unset($bulan[0]);

       
        // $result = [];
        // for ($i = 1; $i <= $jumlah; $i++) {
        //     if (isset($bulan[$i])) {
        //         $result[] = $bulan[$i];
        //     }
        // }
        // $resultFinal =  implode(',', $result);
        
        // $nominal_tagihan = 0;
        // if ($tagihan) {
        //     $nominal_tagihan = (isset($tagihan->spp->nominal_spp) ? $tagihan->spp->nominal_spp : 0) * $jumlah  ;
        //     if ($tagihan->jumlah == 0) {
        //         return response()->json(['status' => 'failed', 'nom' => $tagihan->jumlah, 'message' => 'Maaf, Anda Sudah Tidak Memiliki Tagihan']);
        //     }
        //     if ($jumlah > $tagihan->jumlah ) {
        //         return response()->json(['status' => 'failed', 'nom' => $tagihan->jumlah, 'message' => 'Maaf, Jumlah Bulan Yang Anda Masukan Lebih,  Sisa Tagihan Anda Sebanyak ' . $tagihan->jumlah . ' Bulan']);
        //     }
        // } else {
        //     return response()->json(['status' => 'failed', 'nom' => '0', 'message' => 'Maaf, Anda Tidak Memiliki Tagihan. Silahkan Hubungi Petugas!']);
        // }

        // $nominal_tagihan = number_format($nominal_tagihan,2, ',', '.');
        return response()->json(['status' => 'success', 'nom' => $nominal_tagihan , 'id' => $spp->id_spp]);
    }
    
    public function cekToken(Request $request)
    {
        $rules = [
            'token'=>'required',
        ];

        $customMessages = [
            'token.required' => 'Silahkan Masukan Token',
        ];

        $this->validate($request, $rules, $customMessages);
        $cek_transaksi = Transaksi::where('token',   $request->token)->first();
        $hash = hash('sha512', $request->token);
        // dd($hash);
        if ($cek_transaksi) {
            // $notification=array(
            //     'message'=>"Maaf, Tagihan Anda Belum Terdaftar. Silahkan Hubungi Petugas",
            //     'alert-type'=>'popup',
            // );
            $cek_transaksi->token = $hash;
            $cek_transaksi->save();
            $notification=array(
                'message'=>"Pembayaran Berhasil, Hubungi Petugas Untuk Melakukan Verifikasi",
                'alert-type'=>'success',
            );
        } else {
            $notification=array(
                'message'=>"Maaf,Token Yang Anda Masukan Salah. Silahkan Lakukan Pembayaran Kembali",
                'alert-type'=>'popup',
            );

            // $cek_transaksi->delete();
        }

        return back()->with($notification);
    }

    public function history($id)
    {
        $title = "Transaksi";
        $siswa = Siswa::find($id);
        $nisn = $siswa->nisn;
        $tagihan = Tagihan::where('id_siswa', $id)->first();
        $transaksi = [];
        if ($tagihan) {
            $transaksi = Transaksi::where('tag_id', $tagihan->tag_id)->orderBy('created_at', 'desc')->get();
        }

        $menu = 'Pembayaran';
        return view('halaman_siswa.history',compact(
            'title','transaksi','menu', 'siswa', 'nisn'
        ));
    }
}
