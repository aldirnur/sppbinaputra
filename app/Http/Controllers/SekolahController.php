<?php

namespace App\Http\Controllers;

use App\Exports\SiswaExport;
use App\Imports\SiswaImport;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Spp;
use App\Models\Tagihan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title ="Siswa";
        $siswa = Siswa::get();
        $menu = 'Siswa';
        return view('data_sekolah.data_siswa',compact('title','siswa','menu'));
    }

    /**
     * Display a form for adding the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_jurusan()
    {
        $title = "Jurusan";
        $jurusan = Jurusan::get();
        $menu = 'Siswa';
        return view('data_sekolah.Jurusan',compact(
            'title','jurusan','menu'
        ));
    }

    public function create(){
        $title= "Add Siswa";
        $jurusan = Jurusan::get();
        $kelas = Kelas::get();
        $spp = Spp::get();
        $menu = 'Siswa';
        return view('data_sekolah.add_siswa',compact(
            'title','jurusan', 'menu' , 'kelas', 'spp'
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
        $this->validate($request,[
            'nama_jurusan'=>'required',
        ]);
        Jurusan::create([
            'nama_jurusan'=>$request->nama_jurusan,
            'type'=>$request->type,
        ]);
        $notification = array(
            'message'=>"Jurusan Berhasil Ditambahkan",
            'alert-type'=>'success',
        );
        return redirect()->route('jurusan')->with($notification);
    }


    public function store_sekolah(Request $request)
    {
        $rules = [
            'nis' => 'required|unique:siswa,nis',
            'nisn' => 'required|unique:siswa,nisn',
            'nama'=>'required',
            'pin'=>'required|integer',
            'no_tlp'=>'required',
            'nama_wali'=>'required',
            'kelas'=>'required|max:200',
            'alamat' =>'max:200',
            // 'angkatan' => 'required|digits:4|max:' . (date('Y')+1)
        ];

        $customMessages = [
            'nama.required' => 'Nama Harus Diisi',
            'nama_wali.required' => 'Nama Wali Harus Diisi',
            'pin.required' => 'Pin Harus Diisi',
            'pin.integer' => 'Pin Harus Berupa Nomor',
            'kelas.required' => 'Kelas Harus Diisi',
            'alamat.required' => 'Alamat Harus Diisi',
            'no_tlp.required' => 'No Telepon Harus Diisi',
            'nis.required' => 'Nis Harus Diisi',
            'nisn.required' => 'Nisn Harus Diisi',
            'nis.unique' => 'Nis Sudah Ada',
            'nisn.unique' => 'Nisn Sudah Ada',
            'angkatan.required' => 'Angkatan Harus Diisi',
            'angkatan.digits' => 'Input Tahun Angkatan Harus 4 Angka Saja',
            'angkatan.max' => 'Maximal Input Tahun Yaitu ' . date('Y')
        ];

        $this->validate($request, $rules, $customMessages);
        $random = '';
        $limit = 7;
        for($i = 0; $i < $limit; $i++) {
            $random .= mt_rand(0, 9);
        }
        $code = date("Y") . $random;

        $angkatan = $request->angkatan;
        $found = true;

        $kelas = Kelas::find($request->kelas);
        if ($kelas->nama_kelas == 'X') {
            $loop = 3;
        } elseif ($kelas->nama_kelas == 'XI') {
            $loop = 2;
        } else {
            $loop = 1;
        }
        for ($ix = 1; $ix <= $loop ; $ix++) {
            $checkDataSpp = Spp::where('tahun_ajaran', $angkatan)->first();
            if (!$checkDataSpp) {
                $found =  false;
            }
            $angkatan++;
        }
        
       
        
        if ($found) {
            $siswa = Siswa::create([
                'nis' => $request->nis,
                'nisn' => $request->nisn,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'kelas' => $request->kelas,
                'alamat' => $request->alamat,
                'tgl_lahir' => $request->tgl,
                'no_tlp' => $request->no_tlp,
                'nama_wali' => $request->nama_wali,
                'jur_id' => $request->jurusan,
                'pin' => $request->pin,
                'agama' => $request->agama,
                'angkatan' => $request->angkatan,
                'status' => $request->status
            ]);

            $ankt = $request->angkatan;
            for ($ix = 1; $ix <= $loop ; $ix++) {
                $checkDataSpp = Spp::where('tahun_ajaran', $ankt)->first();
                $tagihan = New Tagihan();

                $bulanSekarang = date('m');
                $jumlahBulanTahunIni = 12 - $bulanSekarang + 1; 
                $jumlahBulan =  12;
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

                $tagihan->jumlah = 12;
                $tagihan->id_spp = $checkDataSpp->id_spp;
                $tagihan->id_siswa = $siswa->id_siswa;
                $tagihan->bulan = json_encode($data);
                $tagihan->save();

                $ankt++;
                
            }

            $notification = array(
                'message'=>"Siswa Berhasil Ditambahkan",
                'alert-type'=>'success',
            );
        } else {
            $notification = array(
                'message'=>"Data Siswa Gagal Di Buat, Data Belum Memiliki Data SPP.",
                'alert-type'=>'danger',
            );
        }
        
        return redirect()->route('siswa')->with($notification);
    }
    /**
     * Display the specified resource.
     *@param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $title = "edit Siswa";
        $jurusan = Jurusan::get();
        $siswa = Siswa::find($id);
        $kelas = Kelas::get();
        return view('data_sekolah.edit_siswa',compact(
            'title','siswa','jurusan', 'kelas'
        ));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $rules = [
            'nama'=>'required',
            'pin'=>'required|integer',
            'no_tlp'=>'required',
            'nama_wali'=>'required',
            'kelas'=>'required|max:200',
            'alamat' =>'max:200',
        ];

        $customMessages = [
            'nama.required' => 'Nama Harus Diisi',
            'nama_wali.required' => 'Nama Wali Harus Diisi',
            'pin.required' => 'Pin Harus Diisi',
            'pin.integer' => 'Pin Harus Berupa Nomor',
            'kelas.required' => 'Kelas Harus Diisi',
            'alamat.required' => 'Alamat Harus Diisi',
            'no_tlp.required' => 'No Telepon Harus Diisi',
        ];

        $this->validate($request, $rules, $customMessages);

        $siswa->update($request->all());
        $notification = array(
            'message'=>"Siswa has been updated",
            'alert-type'=>'success',
        );
        return redirect()->route('siswa')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function show_jurusan(Request $request,$id)
    {
        $title = "Edit Jurusan";
        $jurusan = jurusan::find($id);
        return view('data_sekolah.edit_jurusan',compact(
            'title','jurusan'
        ));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier $supplier
     * @return \Illuminate\Http\Response
     */

    public function update_jurusan(Request $request, $id)
    {

        $rules = [
            'nama_jurusan'=>'required',
        ];

        $customMessages = [
            'nama_jurusan.required' => 'Nama Jurusan Harus Diisi',
        ];
        $this->validate($request, $rules, $customMessages);

        $jurusan = Jurusan::find($id);
        if ($jurusan) {
            $jurusan->nama_jurusan = $request->nama_jurusan;
            $jurusan->save();
        }

        $notification = array(
            'message'=>"Jurusan Berhasil Di Ubah",
            'alert-type'=>'success',
        );
        return redirect()->route('jurusan')->with($notification);
    }

    public function delete_jurusan(Request $request, $id) {
        $jurusan = Jurusan::find($id);
        if ($jurusan) {
            $jurusan->delete();
        }
        $notification = array(
            'message'=>"Jurusan Berhasil Di Hapus",
            'alert-type'=>'success',
        );

        return redirect()->route('jurusan')->with($notification);
    }

    public function export_excel()
	{
		return Excel::download(new SiswaExport, 'siswa.xlsx');
	}

    public function import_excel(Request $request)
    {
        $file = $request->file('file');

        $nama_file = rand().$file->getClientOriginalName();
        $file->move('file_siswa',$nama_file);
        try {
            $test = Excel::import(new SiswaImport, public_path('/file_siswa/'.$nama_file));
            
            $notification = array(
                'message'=>"Data Siswa Berhasil Di Import",
                'alert-type'=>'success',
            );
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $msg = '';
            $failures = $e->failures();
            foreach ($failures as $failure) {
                $msg =$failure->errors()[0]; // Actual error messages from Laravel validator
                // $msg = $msg.' : met waarde '.$failure->values(); // The values of the row that has failed: not available in version
                $notification = array(
                    'message'=> $msg,
                    'alert-type'=>'warning',
                );

            }
            // return back()->with('error', $msg);
        } catch (\Exception $e) {
           
        }

        return back()->with($notification);
    }

    public function destroy($id)
    {
        $title = "edit Siswa";
        $siswa = Siswa::find($id);
        $tagihan = Tagihan::where('id_siswa', $id)->first();
        $transaksi = null;
        if ($tagihan) {
            $transaksi = Transaksi::where('tag_id', $tagihan->id_tagihan)->first();
        }
        if ($siswa && !$transaksi) {
            if ($tagihan) {
                $tagihan->delete();
            }
            $siswa->delete();
            $notification = array(
                'message'=>"Tentang Sekolah Berhasil Di Rubah",
                'alert-type'=>'success',
            );
        } else {
                $notification = array(
                    'message'=>"Data Siswa Memiliki Transaksi",
                    'alert-type'=>'danger',
                );
            }

        return redirect()->route('siswa')->with($notification);
    }

    public function index_kelas()
    {
        $title = "Kelas";
        $jurusan = Kelas::with('siswa')->get();
        $menu = 'Siswa';
        return view('data_sekolah.data-kelas',compact(
            'title','jurusan','menu'
        ));
    }

    public function store_kelas(Request $request)
    {
        $this->validate($request,[
            'nama_kelas'=>'required',
        ]);

        $kelas = Kelas::where('nama_kelas', $request->nama_kelas)->where('type', $request->type)->first();
        if (!$kelas) {
            Kelas::create([
                'nama_kelas'=> $request->nama_kelas,
                'type'=> $request->type,
            ]);
            $notification = array(
                'message'=>"Data Kelas Berhasil Ditambahkan",
                'alert-type'=>'success',
            );
        } else {
            $notification = array(
                'message'=>"Data Kelas Sudah ada",
                'alert-type'=>'danger',
            );
        }
        
        return redirect()->route('kelas')->with($notification);
    }

    public function update_kelas(Request $request, $id)
    {

        $rules = [
            'nama_kelas'=>'required',
        ];

        $customMessages = [
            'nama_kelas.required' => 'Nama Kelas Harus Diisi',
        ];
        $this->validate($request, $rules, $customMessages);

        $jurusan = Kelas::find($id);
        if ($jurusan) {
            $jurusan->nama_kelas = $request->nama_kelas;
            $jurusan->type = $request->type;
            $jurusan->save();
        }

        $notification = array(
            'message'=>"Data Kelas Berhasil Di Ubah",
            'alert-type'=>'success',
        );
        return redirect()->route('kelas')->with($notification);
    }

    public function show_kelas(Request $request,$id)
    {
        $title = "Edit Kelas";
        $jurusan = Kelas::find($id);
        return view('data_sekolah.edit-kelas',compact(
            'title','jurusan'
        ));
    }

    public function delete_kelas(Request $request, $id)
    {
       $kelas = Kelas::find($id);
       if ($kelas) {
        $kelas->delete();
       }
       $notification = array(
            'message'=>"Data Kelas Berhasil Di Hapus",
            'alert-type'=>'success',
        );
        return redirect()->route('kelas')->with($notification);
    }
}

