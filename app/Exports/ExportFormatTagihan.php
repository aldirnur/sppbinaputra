<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ExportFormatTagihan implements FromView
{
    public function view(): View {
        $siswa = Siswa::get();
        return view('data_keuangan.export_format_tagihan', compact('siswa'));
    }
}
