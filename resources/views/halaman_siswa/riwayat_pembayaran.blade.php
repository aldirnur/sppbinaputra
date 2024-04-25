@extends('layouts.app-siswa')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('History Pembayaran') }}</h1>

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

        <div class="container-fluid">

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Riwayat Pembayaran Siswa</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
                            <thead class="text-center thead-light">
                                <tr>
                                <tr>
                                    <th scope="col">Nama Siswa</th>
                                    <th scope="col">Kode Transaksi</th>
                                    <th scope="col">Tanggal Pembayaran</th>
                                    <th scope="col">Jumlah Bulan</th>
                                    <th scope="col">Jumlah Pembayaran</th>
                                    <th scope="col">Sisa Tagihan</th>
                                    <th scope="col">Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tbody>
                                    @foreach ($history as $item)
                                        @php 
                                            $jumlah = $item->getJumlahBulan($item->tag_id, $item->nominal_transaksi);
                                            $sisa_tagihan = $item->getSisaTagihan($item->tag_id, $item->nominal_transaksi);
                                        @endphp
                                        <tr>
                                            <td>{{isset($item->tagihan->siswa) ? $item->tagihan->siswa->nama : '-' }}</td>
                                            <td>{{$item->no_transaksi}}</td>
                                            <td>{{$item->tgl}}</td>
                                            <td>{{$jumlah}}</td>
                                            <td>Rp. {{number_format($item->nominal_transaksi,2, ',', '.')}}</td>
                                            <td>Rp. {{number_format($sisa_tagihan,2, ',', '.')}}</td>
                                            <td>
                                                {{$item->keterangan}}
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection
