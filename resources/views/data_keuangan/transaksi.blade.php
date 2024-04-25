@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Data Transaksi') }}</h1>

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
                    <h6 class="m-0 font-weight-bold text-primary">Data Transaksi Siswa</h6>
                    <a class="btn btn-sm btn-primary shadow-sm" href="{{route('add-transaksi')}}"><i class="fas fa-user-plus fa-sm"></i> Tambah Transaksi</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="datatable-siswa" width="100%" cellspacing="0">
                            <thead class="text-center thead-light">                               
                                <tr>
                                    <th scope="col">Kode Transaksi</th>
                                    <th scope="col">Nama Siswa</th>
                                    <th scope="col">Kelas</th>                                                               
                                    <th scope="col">Tanggal Transaksi</th>
                                    <th scope="col">Nominal</th>
                                    <th scope="col">Bukti Transaksi</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">Status</th>
                                    <th class="action-btn">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                    @foreach ($transaksi as $item)
                                        <tr>
                                        <td>{{$item->no_transaksi}}</td>
                                            <td>{{isset($item->tagihan->siswa) ? $item->tagihan->siswa->nama : '-' }}</td>
                                            <td>{{isset($item->siswa->namakelas) ? $item->siswa->namakelas->nama_kelas : ''}} {{isset($item->siswa->jurusan) ? $item->siswa->jurusan->nama_jurusan : ''}} {{isset($item->siswa->namakelas) ? $item->siswa->namakelas->type : ''}} </td>
                                            <td>{{$item->tgl}}</td>
                                            <td>Rp. {{number_format($item->nominal_transaksi,2, ',', '.')}}</td>
                                            <td><a href="#generate_report" data-toggle="modal" onclick="getBukti('{{$item->bukti_transaksi}}');">{{$item->bukti_transaksi}}</a></td>
                                            <td>{{$item->keterangan}}</td>
                                            
                                            
                                            {{-- <td>-</td> --}}
                                            @if ($item->status_transaksi == 1)
                                                <td><span class="btn-sm bg-success-light">Diterima</span></td>
                                            @elseif ($item->status_transaksi == 2)
                                                <td><span class="btn-sm bg-warning-light">Verifikasi</span></td>
                                            @else
                                                <td><span class="btn-sm bg-danger-light">Ditolak</span></td>
                                            @endif 
                                            <td>
                                                <div class="actions">
                                                    @if ($item->status_transaksi != 1)
                                                        <a class="btn btn-sm btn-primary shadow-sm" href="{{route('edit-transaksi',$item->trans_id)}}">
                                                            <i class="fe fe-pencil"></i> Verifikasi
                                                        </a>
                                                    @endif
                                                </div>
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
