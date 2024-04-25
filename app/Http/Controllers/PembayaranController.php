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
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = "pembayaran";
        $nisn = $request->nisn;

        // $siswa = Siswa::where('nis', $request->nis)->where('pin', $request->password)->first();
        // $tagihan = 0;
        // $transaksi = [];
        // $metodePembayaran = DB::table('metode_pembayaran')->get();
        // $transaksi = Transaksi::with('metodePembayaran')->where('id_siswa', $siswa->id_siswa)->where('status_transaksi', 0)->whereDate('expired_pembayaran', '>=', now())->first();
        // $expiredTransaksi = Transaksi::where('id_siswa', $siswa->id_siswa)->where('status_transaksi', 0)->whereDate('expired_pembayaran', '<', now())->first();
        // if ($expiredTransaksi) {
        //     $expiredTransaksi->delete();
        // }
        $siswa = Siswa::where('nis', $request->nis)->where('pin', $request->password)->first();
        if ($siswa) {
            $tagihan = 0;
            $transaksi = [];
            $metodePembayaran = DB::table('metode_pembayaran')->get();
            $transaksi = Transaksi::with('metodePembayaran')->where('id_siswa', $siswa->id_siswa)->where('status_transaksi', 0)->whereDate('expired_pembayaran', '>=', now())->first();
            $expiredTransaksi = Transaksi::where('id_siswa', $siswa->id_siswa)->where('status_transaksi', 0)->whereDate('expired_pembayaran', '<', now())->first();
            if ($expiredTransaksi) {
                $expiredTransaksi->delete();
            } else {
                $cek_transaksi = Transaksi::where('id_siswa', $siswa->id_siswa)->where('status_transaksi', 2)->first();
               
                if ($cek_transaksi){
                    $notification=array(
                        'message'=>"Token Kadaluarsa",
                        'alert-type'=>'popup'
                    );

                   
                }   
                //  return back()->with($notification);
            }
        } else {
            return back()->with('error', 'Login Gagal, Silahkan Cek Kembali NISN dan PASSWORD Anda');
        }
       
        return view('halaman_siswa.pembayaran',compact(
            'title','siswa','nisn', 'metodePembayaran', 'transaksi'
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
        $cek_tagihan = Tagihan::where('id_siswa',  $id_siswa)->where('jumlah', '!=', 0)->first();
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

            $code = date("Ymd") . $random;
            $transaksi = Transaksi::where('id_siswa', $id_siswa)->where('status_transaksi', 0)->whereDate('expired_pembayaran', '>=', now())->first();
            if ($transaksi) {
                $transaksi->no_transaksi = $code;
                $transaksi->status_transaksi = 2;
                $transaksi->tgl = date('Y-m-d');
                $transaksi->bukti_transaksi = $imageName;
                $transaksi->expired_token = now()->addMinute(5);
                $transaksi->token = $otp;
                $transaksi->save();
            }
            

            if ($transaksi->token != null) {
                try {
                    $basic  = new \Vonage\Client\Credentials\Basic("b04f9090", "MDpUY1X6ecKV0GA2");
                    $client = new \Vonage\Client($basic);

                    $response = $client->sms()->send(
                        new \Vonage\SMS\Message\SMS($transaksi->tagihan->siswa->no_tlp, 'Verif', 'Kode OTP Anda Adalah '. $otp. ' berlaku unutk 5 menit' )
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
                'message'=>"Silahkan Masukan Kode OTP Yang Telah Dikirim Ke Nomor Anda",
                'alert-type'=>'popup'
            );
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

        return redirect()->to('/profile/'.$siswa->nisn)->withSuccess('Password Berhasil Di Perbarui.');
        // return redirect()->route('profile')->withSuccess('Profile updated successfully.');
    }

    public function profile($id, Request $request)
    {
        
        $title = "profile";
        $nisn = $id;
        $siswa = Siswa::where('nisn', $id)->first();
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


        $cek_transaksi = Transaksi::where('token', $request->token)->first();

        $otp1 = $request->input('otp1');
        $otp2 = $request->input('otp2');
        $otp3 = $request->input('otp3');
        $otp4 = $request->input('otp4');
        $otp5 = $request->input('otp5');
        $otp6 = $request->input('otp6');
        $otp = $otp1.$otp2.$otp3.$otp4.$otp5.$otp6;
       
        $cek_transaksi = Transaksi::where('token', $otp)->first();

        $hash = hash('sha512', $request->token);
        // dd($hash);
        $otp = '';
        $limit = 6;
        for($i = 0; $i < $limit; $i++) {
            $otp .= mt_rand(0, 9);
        }
        if ($cek_transaksi) {
            if ($cek_transaksi->expired_token > date('Y-m-d H:i:s')) {
                $cek_transaksi->token = $hash;
                $cek_transaksi->save();
                $notification=array(
                    'message'=>"Pembayaran Berhasil, Hubungi Petugas Untuk Melakukan Verifikasi",
                    'alert-type'=>'success',
                );
            } else {
                $notification=array(
                    'message'=>"Maaf, Token Yang Anda Masukan Sudah Kadaluarsa. Silahkan Lakukan Refresh Halaman",
                    'alert-type'=>'popup',
                );
                $cek_transaksi->token = $otp;
                $cek_transaksi->expired_token = now()->addMinute(5);
                $cek_transaksi->save();
            }
        } else {
            $siswa = Siswa::where('nisn', $request->nisn)->first();
            if ($siswa) {
                $cek_transaksi = Transaksi::where('id_siswa', $siswa->id)->first(); 
                if ($cek_transaksi) {
                    $cek_transaksi->token = $otp;
                    $cek_transaksi->expired_token = now()->addMinute(5);
                    $cek_transaksi->save();
                }
                $notification=array(
                    'message'=>"Maaf,Token Yang Anda Masukan Sudah Kadaluarsa",
                    'alert-type'=>'popup',
                );
            }
                $notification=array(
                    'message'=>"Maaf,Token Yang Anda Masukan Salah. Silahkan Cek Kembali OTP Anda",
                    'alert-type'=>'popup',
                );
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
            $transaksi = Transaksi::with('siswa')->where('tag_id', $tagihan->tag_id)->orderBy('created_at', 'desc')->get();
        }

        $menu = 'Pembayaran';
        return view('halaman_siswa.history',compact(
            'title','transaksi','menu', 'siswa', 'nisn'
        ));
    }

    public function getCode(Request $request) {
        $id = $request->id;
        $metodePembayaran = DB::table('metode_pembayaran')->where('id', $id)->first();

        if ($metodePembayaran) {
            return response()->json(['status' => 'success', 'code' => $metodePembayaran->code]);
        }
    }

    public function simpanPembayaran(Request $request) {

        try {

            $id_siswa = $request->id_siswa;
            $nominal_transaksi = $request->nominal_transaksi;
            $id_payment_method = $request->payment_method;
            $cek_tagihan = Tagihan::where('id_siswa',  $id_siswa)->where('jumlah', '!=', 0)->first();
            if ($cek_tagihan) { 
                $cek_transaksi = Transaksi::where('id_siswa',  $id_siswa)->where('status_transaksi', 0)->first();
                // $code = date("Ymd") . $random;
                if (!$cek_transaksi) {
                    $transaksi = New Transaksi();
                    $transaksi->id_siswa = $id_siswa;
                    $transaksi->no_transaksi = 0;
                    $transaksi->metode_pembayaran_id = $id_payment_method;
                    $transaksi->status_transaksi = 0;
                    $transaksi->tgl = date('Y-m-d');
                    $transaksi->nominal_transaksi = $nominal_transaksi;
                    $transaksi->keterangan = $request->keterangan ? : 'Pembayaran Spp';
                    $transaksi->bukti_transaksi = 'test';
                    $transaksi->tag_id = $cek_tagihan->tag_id;
                    $transaksi->expired_pembayaran = now()->addHours(24);
                    $transaksi->token = '-';
                    $transaksi->save();
                } else {
                    return response()->json(['status' => 'success','tipe' => 'update']);
                }

                return response()->json(['status' =>'success', 'tipe' => 'insert']);
            } else {
                return response()->json(['status' =>'failed', 'message' => 'Maaf , Proses Konfirmasi Pembayaran Gagal, Silahkan Hubungi Admin']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'failed','message' => $e->getMessage()]);
        }

    }

    public function dataPembayaran($id)
    {
        $title = "Transaksi";
        $siswa = Siswa::find($id);
        $nisn = $siswa->nisn;
        $tagihan = Tagihan::where('id_siswa', $id)->first();
        $transaksi = [];
        if ($tagihan) {
            $transaksi = Transaksi::with('siswa')->where('id_siswa', $id)->where('status_transaksi', 1)->orderBy('created_at', 'desc')->get();
        }

        $menu = 'Pembayaran';
        return view('halaman_siswa.riwayat_pembayaran',compact(
            'title','transaksi','menu', 'siswa', 'nisn'
        ));
    }
}
