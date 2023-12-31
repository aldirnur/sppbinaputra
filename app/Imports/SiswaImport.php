<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Spp;
use App\Models\Tagihan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SiswaImport implements ToModel, WithStartRow,WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    /**
     * @return int
     */

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $checkDataSpp = Spp::where('tahun_ajaran', $row[10])->first();
        if ($checkDataSpp) {
            $siswa =  new Siswa([
                'nis' => $row[1],
                'nisn' => $row[2],
                'nama' => $row[3],
                'jenis_kelamin' => $row[4],
                'kelas' => $row[5],
                'alamat' => $row[6],
                'tgl_lahir' => date('Y-m-d', strtotime($row[7])),
                'no_tlp' => $row[8],
                'nama_wali' => $row[9],
                'angkatan' => $row[10],
                'agama' => $row[11],
                'pin' => $row[12],
                'id_jurusan' => $row[13],
                'status' => 1
            ]);
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
        } else {
            return false;
        }
        return $siswa;
    }

    public function rules(): array
    {
        return [
            '1' => 'required|unique:siswa,nis',
            '2' => 'required|unique:siswa,nisn',
            '3'=> 'required|string',
            '4'=> 'required|integer',
            '5'=> 'required',
            '6' => 'required',
            '7' => 'required|date',
            // '8' => 'required|no_tlp',
            '9' => 'required|string',
            '10' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '1.required' => 'Nis Tidak Boleh Kosong',
            '2.required' => 'Nisn Tidak Boleh Kosong',
            '3.required' => 'Nama Tidak Boleh Kosong',
            '4.required' => 'Jenis Kelamin Tidak Boleh Kosong',
            '5.required' => 'Kelas Tidak Boleh Kosong',
            '6.required' => 'alamat Tidak Boleh Kosong',
            '7.required' => 'Tanggal Lahir Tidak Boleh Kosong',
            // '8.required' => 'no telpon Tidak Boleh Kosong',
            '9.required' => 'Nama Ayah Tidak Boleh Kosong',
            '10.required' => 'Nama Ibu Tidak Boleh Kosong',

            '3.string' => 'Format Nama Tidak Sesuai',
            '4.integer'=> 'Format Jenis Kelamin Tidak Sesuai',
            '7.date' => 'Format Tanggal Lahir Tidak Sesuai, Contoh : 2022-01-01',
            '8.integer' => 'Format No Telfon Tidak Sesuai',
            '9.string' => 'Format Nama Ayah Tidak Sesuai',
            // '10.number' => 'Format Nama Ibu Tidak Sesuai',

            '1.unique' => 'Nis Sudah Terdaftar',
            '2.unique' => 'Nisn SUdah Terdaftar'
        ];
    }
}
