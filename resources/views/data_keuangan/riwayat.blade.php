@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Data Report Transaksi') }}</h1>

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
                    <h6 class="m-0 font-weight-bold text-primary">Data Report Transaksi Siswa</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="datatable-siswa" width="100%" cellspacing="0">
                            <thead class="text-center thead-light">
                                <tr>
                                <tr>
                                    <th scope="col">Kode Transaksi</th>    
                                    <th scope="col">Nama Siswa</th>
                                    <th scope="col">Kelas</th>
                                    <th scope="col">Tanggal Pembayaran</th>
                                    <th scope="col">Jumlah Bulan yang Dibayarkan</th>
                                    <th scope="col">Jumlah Pembayaran</th>
                                    <th scope="col">Sisa Tagihan</th>
                                    <th scope="col">Notes</th>
                                    {{-- <th class="action-btn">Action</th> --}}
                                </tr>
                            </thead>
                            
                                <tbody>
                                    @foreach ($transaksi as $item)

                                        @php 
                                            $jumlah = $item->getJumlahBulan($item->tag_id, $item->nominal_transaksi);
                                            $sisa_tagihan = $item->getSisaTagihan($item->tag_id, $item->nominal_transaksi);
                                        @endphp
                                        <tr>
                                            <td>{{$item->no_transaksi}}</td>    
                                            <td>{{isset($item->tagihan->siswa) ? $item->tagihan->siswa->nama : '-' }}</td>
                                            <td>{{isset($item->siswa->namakelas) ? $item->siswa->namakelas->nama_kelas : ''}} {{isset($item->siswa->jurusan) ? $item->siswa->jurusan->nama_jurusan : ''}} {{isset($item->siswa->namakelas) ? $item->siswa->namakelas->type : ''}} </td>
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
                            
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

<div class="modal fade" id="generate_report" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bukti Transaksi</h5>
                <button type="button" class="close" onclick="location.reload();" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="bukti">
                @csrf

            </div>
        </div>
    </div>
</div>

<script>

    function getBukti(val) {
        console.log(val);
        var bukti ='<img src="/img/payment/'+val+'" alt="" width="400" height="500">'
            $('#bukti').append(bukti);
            console.log(bukti);
    }
</script>
@endsection
