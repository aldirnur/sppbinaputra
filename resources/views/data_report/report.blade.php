@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Data Report') }}</h1>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="pl-4 my-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">

        {{-- <div class="col-lg-4 order-lg-2">

            <div class="card shadow mb-4">
                <div class="card-profile-image mt-4">
                    <figure class="rounded-circle avatar avatar font-weight-bold" style="font-size: 60px; height: 180px; width: 180px;" data-initial=""></figure>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <h5 class="font-weight-bold"></h5>
                                <p>Administrator</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card-profile-stats">
                                <span class="heading">22</span>
                                <span class="description">Friends</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-profile-stats">
                                <span class="heading">10</span>
                                <span class="description">Photos</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-profile-stats">
                                <span class="heading">89</span>
                                <span class="description">Comments</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div> --}}

        <div class="container-fluid">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Pembayaran Siswa</h6>
                    <a class="btn btn-sm btn-primary shadow-sm" href="#generate_report" data-toggle="modal"><i class="fas fa-book fa-sm"></i> Filter Laporan</a>
                </div>
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Saldo</div>
                            {{-- <div class="">{{$saldo}}</div> --}}

                            <h3 class="h5 mb-0 font-weight-bold text-gray-800">Rp. {{number_format($saldo,2, ',', '.')}}</h3>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
                @isset($uang_masuk)
                    <!--  Sales -->
                    <div class="card shadow mb-4">

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="report-export" class="table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Tanggal Pembayaran</th>
                                            <th>Nama Siswa</th>
                                            <th>Kelas</th>
                                            <th>Jurusan</th>
                                            <th>Angkatan</th>
                                            <th>Uang Masuk</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $saldo = 0;
                                        @endphp
                                        
                                        @foreach ($uang_masuk as $item)

                                            <?php
                                                $saldo += $item->nominal_kas;
                                                // if($item->kategori->type == 2) $saldo -= $item->uang_keluar;
                                            ?>
                                            <tr>
                                                <td>
                                                    {{$item->tgl}}
                                                </td>
                                                {{-- <td>{{$item->kategori->nama_kategori}}</td> --}}
                                                <td>{{isset($item->transaksi->siswa) ? $item->transaksi->siswa->nama : '-' }}</td>
                                                <td>{{isset($item->transaksi->siswa->namaKelas) ? $item->transaksi->siswa->namaKelas->nama_kelas : '-' }}</td>
                                                <td>{{isset($item->transaksi->siswa->namaKelas) ? $item->transaksi->siswa->jurusan->nama_jurusan : '-' }}</td>
                                                <td>{{isset($item->transaksi->siswa) ? $item->transaksi->siswa->angkatan : '-' }}</td>
                                                <td>{{$item->nominal_kas}}</td>
                                                <td>{{$item->notes}}</td>
                                            </tr>

                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endisset
        </div>

    </div>

<div class="modal fade" id="generate_report" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Laporan Keuangan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="get" action="{{route('reports')}}">
                    @csrf
                    <div class="row form-row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Kelas</label>
                                        <select class="form-control" name="kelas" id="">
                                            @foreach ($kelas as $klss)
                                                <option value="{{$klss->id}}" {{$klss->id == $kls ? 'selected' : ''}}>{{$klss->nama_kelas}} - {{$klss->type}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Jurusan</label>
                                        <select class="form-control" name="jurusan" id="">
                                            @foreach ($jurusan as $jrs)
                                                <option value="{{$jrs->jur_id}}" {{$jrs->jur_id == $jrsn ? 'selected' : ''}}>{{$jrs->nama_jurusan}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Dari</label>
                                        <input type="date" name="from_date" value="{{$from_date}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Sampai</label>
                                        <input type="date" name="to_date" value="{{$to_date}}" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Resource</label>
                                <select class="form-control select" name="resource">
                                    <option value="pemasukan">Pemasukan</option>
                                    {{-- <option value="pengeluaran">Pengeluaran</option> --}}
                                </select>
                            </div>
                        </div>
                    </div>
                    <button onclick="preLoad();" type="submit" class="btn btn-primary btn-block">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
