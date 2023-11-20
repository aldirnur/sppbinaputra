<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Spp;
use App\Models\Tagihan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportTagihan implements ToModel,WithStartRow
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

    public function model(array $row )
    {

        $siswa = Siswa::where('nis', $row[1])->first();
        $spp = Spp::where('tahun_ajaran', $siswa->angkatan)->first();

        $bulanSekarang = intval(date('m'));
        $jumlahBulanTahunIni = 12 - $bulanSekarang + 1; 
        $jumlahBulan =  $row[2];
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
        $tagihan = Tagihan::where('id_siswa', $siswa->id_siswa)->first();
        $tagihanArray = [];

        if (!$tagihan) {
            $tagihan = new Tagihan([
                'jumlah' => $row[2],
                'id_siswa' => $siswa->id_siswa,
                'id_spp' => $spp->id_spp,
                'bulan' => json_encode($data)
            ]);

            $tagihanArray[] = $tagihan;
        }

        if (empty($tagihanArray)) {
            return [];
        }

        return $tagihanArray;
    }
}

