@extends('layouts.app-siswa')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Data Tagihan') }}</h1>

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
                    <h6 class="m-0 font-weight-bold text-primary">Data Tagihan Anda</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-export" class=" table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Tahun Ajaran</th>
                                    <th>Nama Siswa</th>
                                    <th>Nominal Spp</th>
                                    <th>Jumlah Bulan</th>
                                    <th>Bulan</th>
                                    <th>Jumlah Tagihan</th>
                                    <th>Status</th>
                                    {{-- <th class="action-btn">Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tagihan as $item)
                                @php
                                    $nomin = isset($item->spp->nominal_spp) ? $item->spp->nominal_spp : 0;
                                    $total = $nomin * $item->jumlah
                                @endphp
                                <tr>
                                <td>
                                        {{isset($item->siswa->angkatan) ? $item->siswa->angkatan : ''}}
                                    </td>
                                    <td>
                                        {{isset($item->siswa->nama) ? $item->siswa->nama : ''}}
                                    </td>
                                    <td>Rp. {{number_format($item->spp->nominal_spp,2, ',', '.')}}</td>
                                    <td>{{$item->jumlah}}</td>
                                    <td>
                                        @php ($bulan = json_decode($item->bulan))@endphp
                                        
                                        @php ($namaBulan = $bulan) @endphp
                                        @foreach ($bulan as $index => $value)
                                            @php ($nama = $namaBulan[$index % 12]) @endphp
                                            {{$nama}}
                                            @if ($index != count($bulan) - 1)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>Rp. {{number_format($total,2, ',', '.')}}</td>
                                    @if ($item->status == 1)
                                        <td><span class="btn btn-sm bg-success-light">Lunas</span></td>
                                    @else
                                        <td><span class="btn btn-sm bg-danger-light">Belum Lunas</span></td>
                                    @endif

                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
