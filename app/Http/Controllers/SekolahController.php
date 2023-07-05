<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Siswa;
use Illuminate\Http\Request;

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
        $menu = 'Siswa';
        return view('data_sekolah.add_siswa',compact(
            'title','jurusan', 'menu'
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
            'nisn.unique' => 'Nisn Sudah Ada'
        ];

        $this->validate($request, $rules, $customMessages);
        $random = '';
        $limit = 7;
        for($i = 0; $i < $limit; $i++) {
            $random .= mt_rand(0, 9);
        }
        $code = date("Y") . $random;

        Siswa::create([
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
        ]);
        $notification = array(
            'message'=>"Siswa Berhasil Ditambahkan",
            'alert-type'=>'success',
        );
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
        return view('data_sekolah.edit_siswa',compact(
            'title','siswa','jurusan'
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
            Excel::import(new SiswaImport, public_path('/file_siswa/'.$nama_file));

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
        }

        return back()->with($notification);
    }

    public function tentang()
    {
        $title ="Tentang Sekolah";
        $tentang = TentangSekolah::get();
        return view('sekolah.tentang-sekolah',compact('title','tentang'));
    }

    public function detail_tentang(Request $request,$id)
    {
        $title = "Edit Tentang Sekolah";
        $akreditasi = [1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D'];
        $tentang = TentangSekolah::find($id);
        return view('sekolah.edit-sekolah',compact(
            'title','tentang','akreditasi'
        ));
    }

    public function update_tentang(Request $request, $id)
    {
        $tentang = TentangSekolah::find($id);
        $tentang->update($request->all());
        $notification = array(
            'message'=>"Tentang Sekolah Berhasil Di Rubah",
            'alert-type'=>'success',
        );
        return redirect()->route('tentang')->with($notification);
    }

    public function destroy($id)
    {
        $title = "edit Siswa";
        $siswa = Siswa::find($id);
        $tagihan = Tagihan::where('id_siswa', $id)->first();
        $transaksi = null;
        if ($tagihan) {
            $transaksi = Transaksi::where('id_tagihan', $tagihan->id_tagihan)->first();
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
}

