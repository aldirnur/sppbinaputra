<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Siswa;
use App\Models\Spp;
use App\Models\Tagihan;
use App\Models\Transaksi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "keuangan";
        $keuangan = Keuangan::orderBy('created_at', 'asc')->get();

        $saldo = $keuangan->sum('nominal_kas');
        $menu = 'Pembayaran';

        return view('data_keuangan.keuangan',compact(
            'title','keuangan','saldo','menu'
        ));
    }

    public function create(){
        $title= "Add Kategori";
        return view('keuangan.add-kategori',compact(
            'title',
        ));
    }


    /**
     * Display a listing of expired resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function kategori_keuangan(){
        $title = "Kategori Keuangan";
        $kategori = Kategori::all();


        return view('keuangan.kategori',compact(
            'title','kategori'
        ));
    }

    /**
     * Display a listing of out of stock resources.
     *
     * @return \Illuminate\Http\Response
     */

    public function tagihan(Request $request){
        $title = "Tagihan";
        $tahun = $request->tahun;
        $tagihan = Tagihan::where(function ($q) use ($tahun) {
            if ($tahun) {
                $q->where('angkatan', $tahun);
            }
        })->get();
        
        $siswa = Siswa::get();
        $spp = Spp::get();
        $menu = 'Pembayaran';

        return view('data_keuangan.tagihan',compact(
            'title','tagihan','spp','siswa','menu','tahun'
        ));
    }

    public function tagihan_siswa($id){
        $title = "Tagihan";
        $tagihan = Tagihan::where('id_siswa', $id)->get();
        $siswa = Siswa::find($id);
        $nisn = $siswa->nisn;
        $spp = Spp::get();
        $menu = 'Pembayaran';

        return view('halaman_siswa.tagihan_siswa',compact(
            'title','tagihan','spp','siswa','menu','nisn'
        ));
    }

    public function store_tagihan(Request $request)
    {
        $rules = [
            'jumlah'=>'required',
            'spp'=>'required',
        ];
        $customMessages = [
            'jumlah.required' => 'Jumlah Tagihan Harus Diisi',
            'spp.required' => 'Pastikan data yang anda inputkan memiliki Spp',
        ];

        $this->validate($request, $rules, $customMessages);
        $cekTagihan = Tagihan::where('id_siswa', $request->siswa)->where('id_spp', $request->spp)->first();

        if (!$cekTagihan) {

            $tagihan = New Tagihan();
            $bulanSekarang = 6;
            $jumlahBulanTahunIni = 12 - $bulanSekarang + 1; 
            $jumlahBulan =  $request->jumlah;
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
            $test = json_encode($data);
    
    
            $tagihan->jumlah = $request->jumlah;
            $tagihan->id_spp = $request->spp;
            $tagihan->id_siswa = $request->siswa;
            $tagihan->bulan = json_encode($data);
            $tagihan->save();
            $notification=array(
                'message'=>"Tagihan Berhasil Ditambahkan ",
                'alert-type'=>'success',
            );
        } else {
            $notification=array(
                'message'=>"Tagihan Sudah Ada ",
                'alert-type'=>'danger',
            );
        }
        return redirect()->route('tagihan')->with($notification);
    }

    public function edit_tagihan(Request $request, $id)
    {
        $title = "Edit Tagihan";
        $tagihan = Tagihan::find($id);
        $spp = Spp::get();
        return view('data_keuangan.edit_tagihan',compact(
            'title','tagihan','spp',
        ));
    }

    public function update_tagihan(Request $request,$id)
    {
        $this->validate($request,[
            'jumlah'=>'required',
        ]);

        $tagihan = Tagihan::find($id);
        if ($tagihan) {
            $bulanSekarang = intval(date('m'));
            $jumlahBulanTahunIni = 12 - $bulanSekarang + 1; 
            $jumlahBulan =  $request->jumlah;
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
            $tagihan->bulan = json_encode($data);
            $tagihan->jumlah = $request->jumlah;
            $tagihan->id_spp = $request->spp;
            $tagihan->save();
        }


        $notification=array(
            'message'=>"Tagihan has been updated",
            'alert-type'=>'success',
        );
        return redirect()->route('tagihan')->with($notification);
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
            'nama_kategori'=>'required',
        ];
        $customMessages = [
            'nama_kategori.required' => 'Nama Kategori Harus Diisi',
        ];

        $this->validate($request, $rules, $customMessages);
        $type = $request->type;
        Kategori::create([
            'nama_kategori'=>$request->nama_kategori,
            'type'=>$type,
        ]);
        $notification=array(
            'message'=>"Kategori Berhasil Ditambahkan has been added",
            'alert-type'=>'success',
        );
        return redirect()->route('kategori')->with($notification);
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
        $title = "Edit Kategori";
        $kategori = Kategori::find($id);
        return view('keuangan.edit-kategori',compact(
            'title','kategori'
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
            'nama_kategori'=>'required',
        ];
        $customMessages = [
            'nama_kategori.required' => 'Nama Kategori Harus Diisi',
        ];

        $this->validate($request, $rules, $customMessages);


        $type = $request->type;
        $kategori = Kategori::find($id);
        if ($kategori) {
            $kategori->nama_kategori = $request->nama_kategori;
            $kategori->type = $type;
            $kategori->save();
        }


        $notification=array(
            'message'=>"Kategori has been updated",
            'alert-type'=>'success',
        );
        return redirect()->route('kategori')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tagihan = Tagihan::find($id);
        $transaksi = Transaksi::where('tag_id', $tagihan->id_tagihan)->first();
        if (!$transaksi && $tagihan) {
            $tagihan->delete();
            $notification = array(
                'message'=>"Data Tagihan Berhasil Di Hapus",
                'alert-type'=>'success',
            );
        } else {
            $notification = array(
                'message'=>"Data Tagihan Memiliki Transaksi",
                'alert-type'=>'danger',
            );
        }

        return redirect()->route('tagihan')->with($notification);
    }

    public function kirim($id)
    {
       
        try {

            $basic  = new \Vonage\Client\Credentials\Basic("4b93d4ff", "BgvlgENAvx9njK2T");
            $client = new \Vonage\Client($basic);
            // dd($basic);

            $tagihan = Tagihan::with('siswa')->where('tag_id', $id)->first();
            // dd($tagihan->siswa->no_tlp);
    
            $response = $client->sms()->send(
                new \Vonage\SMS\Message\SMS($tagihan->siswa->no_tlp, 'SMKBINAPUTRA', 
                'Kami ingatkan agar segera melakukan pembayaran
                ')
            );
            $message = $response->current();
           
    
        } catch (Exception $e) {
            dd($e->getMessage());
            $notification=array(
                'message'=>"Maaf, Mengirim SMS Gagal",
                'alert-type'=>'danger',
            );
            return back()->with($notification);
        }

        $notification=array(
            'message'=>"Sukses, Mengirim SMS Berhasil Dilakukan",
            'alert-type'=>'success',
        );

        return redirect()->route('tagihan')->with($notification);
    }



    

}
