@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Data Metode Pembayaran') }}</h1>

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
                    <h6 class="m-0 font-weight-bold text-primary">Data Metode Pembayaran</h6>
                    <a class="btn btn-sm btn-primary shadow-sm" href="#generate_report" data-toggle="modal"><i class="fas fa-plus fa-sm"></i> Tambah Data Metode Pembayaran</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="export-id" class="table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>No Account</th>
                                    <th>Status</th>
                                    <th class="action-btn">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payment as $item)
                                <tr>
                                    <td>{{$item->pm_id}}</td>
                                    <td>
                                        {{$item->nama}} 
                                    </td>
                                    <td>
                                        {{$item->no_account}} 
                                    </td>
                                    <td>{{$item->status == 1 ? 'Aktif' : 'Tidak Aktif'}}</td>
                                    <td>
                                        <div class="actions">
                                            <a class="btn btn-sm btn-primary shadow-sm" href="{{route('edit-spp',$item->pm_id)}}">
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
                    <h5 class="modal-title">Tambahkan Payment Method</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('add-payment')}}">
                        @csrf
                        <div class="row form-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Nama<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="nama">
                                    <label>No Account<span class="text-danger">*</span></label>
                                    <input class="form-control" type="number" name="no_account">
                                    <label>Tata Cara<span class="text-danger">*</span></label>
                                    <textarea class="form-control" type="number" name="tata_cara"></textarea>
                                   
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
