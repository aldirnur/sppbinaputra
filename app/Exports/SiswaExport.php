<?php

namespace App\Exports;

use App\Models\Siswa;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class SiswaExport implements FromView
{
    public function view(): View {
        return view('halaman_siswa.export_format');
    }
}
