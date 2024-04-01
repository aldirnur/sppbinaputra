<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Keuangan;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\Transaksi;
use Dotenv\Result\Success;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Transaksi";
        $transaksi = Transaksi::orderBy('created_at', 'desc')->get();
        $menu = 'Pembayaran';

        return view('data_keuangan.transaksi',compact(
            'title','transaksi','menu'
        ));
    }



    public function create(){
        $title= "Add Transaksi";
        $siswa = Siswa::get();
        $kelas = Kelas::get();
        $jurusan = Jurusan::get();
        $menu = 'Pembayaran';
        return view('data_keuangan.tambah_transaksi',compact(
            'title','siswa','menu', 'kelas', 'jurusan'
        ));
    }


    /**
     * Display a listing of expired resources.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Display a listing of out of stock resources.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $rules = [
            'keterangan'=>'required',
            'date' => 'required|date_format:Y-m-d',
            'nominal'=>'required',
            'file'=>'required|image',
        ];

        $customMessages = [
            'keterangan.required' => 'Keterangan Harus Diisi',
            'date.required' => 'Tanggal Harus Diisi',
            'nominal.required' => 'Nominal Harus Diisi',
            'file.required' => 'File Harus Diisi',
            'file.image' => 'File Harus Berupa Gambar',
        ];

        $this->validate($request, $rules, $customMessages);
        $random = '';
        $limit = 4;
        for($i = 0; $i < $limit; $i++) {
            $random .= mt_rand(0, 9);
        }
        $code = date("ymd") . $random;
        $type = $request->type;
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


        $cek_tagihan = Tagihan::where('id_siswa',  $request->siswa)->first();
        if ($cek_tagihan) {
            $code = date("Ymd") . $random;
            $transaksi = New Transaksi();
            $transaksi->no_transaksi = $code;
            $transaksi->status_transaksi = 2;
            $transaksi->tgl = date('Y-m-d');
            $transaksi->nominal_transaksi = $request->nominal;
            $transaksi->keterangan = $request->keterangan ? : 'Transaksi Pembayaran SPP oleh Bendahara';
            $transaksi->bukti_transaksi = $imageName;
            $transaksi->tag_id = $cek_tagihan->tag_id;
            $transaksi->token = '-';
            $transaksi->save();

            // dd($transaksi->tagihan->siswa->no_tlp);

            // if ($transaksi->token != null) {
            //     try {
            //         $basic  = new \Vonage\Client\Credentials\Basic(getenv("NEXMO_KEY"), getenv("NEXMO_SECRET"));
            //         $client = new \Vonage\Client($basic);

            //         $response = $client->sms()->send(
            //             new \Vonage\SMS\Message\SMS($transaksi->tagihan->siswa->no_tlp, 'Verif', 'Kode Token Anda Adalah '. $transaksi->token. ' ' )
            //         );

            //         $message = $response->current();

            //     } catch (Exception $e) {
            //         $notification=array(
            //             'message'=>$e->getMessage(),
            //             'alert-type'=>'danger',
            //         );
            //         return back()->with($notification);
            //     }

            // }

            // $notification=array(
            //     'message'=>"Maaf, Tagihan Anda Belum Terdaftar. Silahkan Hubungi Petugas",
            //     'alert-type'=>'popup',
            // );
            $notification=array(
                'message'=>"Pembayaran Berhasil",
                'alert-type'=>'success',
            );
        } else {
            $notification=array(
                'message'=>"Maaf, Tagihan Anda Belum Terdaftar. Silahkan Hubungi Petugas",
                'alert-type'=>'danger',
            );
        }


        $notification=array(
            'message'=>"Transaksi Berhasil Ditambahkan",
            'alert-type'=>'success',
        );
        return redirect()->route('transaksi')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $title = "Edit Transaksi";
        $status = [1 => "Verifikasi Diterima" , 2 => 'Verifikasi', 3 => "Verifikasi Ditolak"];
        $transaksi = Transaksi::find($id);
        $menu = 'Pembayaran';
        return view('data_keuangan.edit_transaksi',compact(
            'title','transaksi','status', 'menu'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $rules = [
            'keterangan'=>'required',
            'date' => 'required|date_format:Y-m-d',
            'nominal'=>'required',
        ];

        $customMessages = [
            'keterangan.required' => 'Keterangan Harus Diisi',
            'date.required' => 'Tanggal Harus Diisi',
            'nominal.required' => 'Nominal Harus Diisi'
        ];
        $this->validate($request, $rules, $customMessages);
        $transaksi = Transaksi::find($id);
        if ($transaksi) {
            $transaksi->status_transaksi = $request->status;
            $transaksi->tgl = $request->date;
            $transaksi->nominal_transaksi = $request->nominal;
            $transaksi->keterangan = $request->keterangan;
            $transaksi->save();

            if ($transaksi->status == 3) {
                if ($request->user_note) {
                    $transaksi->user_note = $request->user_note;
                    $transaksi->save();
                    if($transaksi->id_tagihan != null) {
                        // try {

                        //     $basic  = new \Vonage\Client\Credentials\Basic(getenv("NEXMO_KEY"), getenv("NEXMO_SECRET"));
                        //     $client = new \Vonage\Client($basic);

                        //     $response = $client->sms()->send(
                        //         new \Vonage\SMS\Message\SMS($transaksi->tagihan->siswa->no_tlp, 'Keuangan BKM', 'Yth. ' . $transaksi->tagihan->siswa->nama . ' Kelas ' . $transaksi->tagihan->siswa->kelas . ' Pembayaran Ditolak !. Karena ' . $request->user_note)
                        //     );

                        //     $message = $response->current();

                        // } catch (Exception $e) {
                        //     $notification=array(
                        //         'message'=>"Maaf, Mengirim SMS Gagal",
                        //         'alert-type'=>'danger',
                        //     );
                        //     return back()->with($notification);
                        // }

                    }
                } else {
                    $notification=array(
                        'message'=>"Maaf, Keterangan Ditolak Harus Diisi",
                        'alert-type'=>'danger',
                    );
                    return back()->with($notification);
                }

            }
            if ($transaksi->status_transaksi == 1) {
                $keuangan = New Keuangan();
                $keuangan->tgl = date('Y-m-d');
                // $keuangan->id_kategori = $transaksi->id_kategori;

                // if ($transaksi->kategori->type == 1) {
                $keuangan->nominal_kas = $transaksi->nominal_transaksi;
                $keuangan->notes = $transaksi->keterangan;
                $keuangan->trans_id = $transaksi->trans_id;
                $keuangan->save();

                if($transaksi->tag_id != null) {
                    $tagihan = Tagihan::find($transaksi->tag_id);
                    $nominal_tagihan = (isset($tagihan->spp->nominal_spp) ? $tagihan->spp->nominal_spp : 0) * $tagihan->jumlah;
                    $sisa_tagihan = ($nominal_tagihan - $transaksi->nominal_transaksi ) / $tagihan->spp->nominal_spp;

                    $bulanSekarang = intval(date('m'));
                    $jumlahBulanTahunIni = 12 - $bulanSekarang - 1; 
                    $jumlahBulan =  $sisa_tagihan;
                    $bulanList = $data = [];
                    if ($jumlahBulan > $jumlahBulanTahunIni) {
                        for ($i = $bulanSekarang; $i <= 12; $i++) {
                            $namaBulan = date('F', mktime(0, 0, 0, $i, 1)); 
                            $bulanList[] = $namaBulan;
                        }
                        $bulanAwalTahun = $jumlahBulan - $jumlahBulanTahunIni;
                        for ($i = 1; $i <= $bulanAwalTahun; $i++) {
                            $namaBulan = date('F', mktime(0, 0, 0, $i, 1));
                            $bulanList[] = $namaBulan;
                            $data = $bulanList;
                        }
                    } else {
                        $data = [];
                        for ($i = $bulanSekarang; $i <= 12; $i++) {
                            $namaBulan = date('F', mktime(0, 0, 0, $i, 1));
                            $bulanList[] = $namaBulan;
                        }
                        
                        for ($i = 0; $i < $jumlahBulan; $i++) {
                            $namaBulan = date('F', mktime(0, 0, 0, $i, 1)); 
                            $data[] = $bulanList[$i % 12];
                        }
                    }
                    $arrayBulan = json_decode($tagihan->bulan, true);
                    $nomorBulan = $tagihan->jumlah - $sisa_tagihan;
                    if ($nomorBulan >= 1 && $nomorBulan <= count($arrayBulan)) {
                        for ($ix = 1; $ix <= $nomorBulan; $ix++) {
                            unset($arrayBulan[$nomorBulan - $ix]);
                            $arrayBulan = array_values($arrayBulan);
                        }
                    }   
                    $tagihan->bulan = json_encode($arrayBulan);
                    $tagihan->jumlah = $sisa_tagihan;;
                    $tagihan->save();

                    if ($tagihan->jumlah == 0) {
                        $tagihan->status = 1;
                        $tagihan->save();
                    }
                }
            }
        }

        $notification=array(
            'message'=>"Transaksi Berhasil Di Ubah",
            'alert-type'=>'success',
        );
        return redirect()->route('transaksi')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
    }

    public function getSiswa(Request $request) {
        $id_kelas = $request->id;
        $jurusan_id = $request->jurusan_id;
        $siswa = Siswa::where('kelas', $id_kelas)->where('jur_id', $jurusan_id)->get();
        if (count($siswa) > 0 ) {
            return response()->json(['status' => 'success','data' => $siswa]);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Data not found']);;
        }
    }

    public function Riwayat() {
        $title = "Transaksi";
        $transaksi = Transaksi::orderBy('created_at', 'desc')->where('status_transaksi', 1)->get();
        $menu = 'Pembayaran';

        return view('data_keuangan.riwayat', compact('title', 'transaksi','menu'));
    }


}
