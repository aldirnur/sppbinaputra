@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Data Keuangan') }}</h1>

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
                    <h6 class="m-0 font-weight-bold text-primary">Data Kas Sekolah</h6>
                    {{-- <a class="btn btn-sm btn-primary shadow-sm" href=""><i class="fas fa-user-plus fa-sm"></i> Tambah Siswa</a> --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-export" class="table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Uang Masuk</th>
                                    <th>Notes</th>
                                    <th>Saldo (Rp. {{number_format($saldo,2, ',', '.')}} )</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $tot_saldo = 0;
                                @endphp
                                @foreach ($keuangan as $item)
                                    <?php
                                       $tot_saldo += $item->nominal_kas;
                                    ?>
                                    <tr>
                                        <td>
                                            {{$item->tgl}}
                                        </td>
                                        <td>{{number_format($item->nominal_kas,2, ',', '.')}}</td>
                                        <td>{{$item->notes}}</td>
                                        <td>{{number_format($tot_saldo,2, ',', '.')}}</td>
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
