@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Data SPP') }}</h1>

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
                    <h6 class="m-0 font-weight-bold text-primary">Data SPP</h6>
                    <a class="btn btn-sm btn-primary shadow-sm" href="#generate_report" data-toggle="modal"><i class="fas fa-plus fa-sm"></i> Tambah Data SPP</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="export-id" class="table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Nominal</th>
                                    <th class="action-btn">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($spp as $item)
                                <tr>
                                    <td>{{$item->id_spp}}</td>
                                    <td>
                                        {{$item->tahun_ajaran}}
                                    </td>
                                    <td>{{number_format($item->nominal_spp,2, ',', '.')}}</td>
                                    <td>
                                        <div class="actions">
                                            <a class="btn btn-sm btn-primary shadow-sm" href="{{route('edit-spp',$item->id_spp)}}">
                                                 Edit
                                            </a>
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
                    <h5 class="modal-title">Tambahkan SPP</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('add-spp')}}">
                        @csrf
                        <div class="row form-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Tahun Ajaran<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="tahun_ajaran">
                                    <label>Nominal<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="nominal">
                                </div>
                            </div>
                        </div>
                        <button  onclick="preLoad();" type="submit" class="btn btn-primary btn-block">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
