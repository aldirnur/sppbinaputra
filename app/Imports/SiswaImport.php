<?php

namespace App\Imports;

use App\Models\Siswa;
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

        $random = '';
        $limit = 7;
        for($i = 0; $i < $limit; $i++) {
            $random .= mt_rand(0, 9);
        }
        $code = date("Y") . $random;
        return new Siswa([
            'nis' => $row[1],
            'nisn' => $row[2],
            'nama' => $row[3],
            'jenis_kelamin' => $row[4],
            'kelas' => $row[5],
            'alamat' => $row[6],
            'tgl_lahir' => date('Y-m-d', strtotime($row[7])),
            'no_tlp' => $row[8],
            'nama_ayah' => $row[9],
            'nama_ibu' => $row[10],
            'id_jurusan' => $row[11],
            'kode_pembayaran' => $code
        ]);

    }

    public function rules(): array
    {
        return [ // use indexes as variables
            '1' => 'required|unique:siswa,nis',            //validate unsigned integer
            '2' => 'required|unique:siswa,nisn',
            '3'=> 'required|string',
            '4'=> 'required|integer',
            '5'=> 'required',
            '6' => 'required',
            '7' => 'required|date',
            '8' => 'required|no_tlp',
            '9' => 'required|string',
            '10' => 'required|string',
            '11' => 'required|integer',
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
            '8.required' => 'no telpon Tidak Boleh Kosong',
            '9.required' => 'Nama Ayah Tidak Boleh Kosong',
            '10.required' => 'Nama Ibu Tidak Boleh Kosong',
            '11.required' => 'ID Jurusan Tidak Boleh Kosong',

            '3.string' => 'Format Nama Tidak Sesuai',
            '4.integer'=> 'Format Jenis Kelamin Tidak Sesuai',
            '7.date' => 'Format Tanggal Lahir Tidak Sesuai, Contoh : 2022-01-01',
            '8.integer' => 'Format No Telfon Tidak Sesuai',
            '9.string' => 'Format Nama Ayah Tidak Sesuai',
            '10.string' => 'Format Nama Ibu Tidak Sesuai',
            '11.integer' => 'Format Jurusan Tidak Sesuai',

            '1.unique' => 'Nis Sudah Terdaftar',
            '2.unique' => 'Nisn SUdah Terdaftar'
        ];
    }
}
