@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Data Kelas') }}</h1>

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
                    <h6 class="m-0 font-weight-bold text-primary">Data Kelas</h6>
                    {{-- <a class="btn btn-sm btn-primary shadow-sm" href=""><i class="fas fa-user-plus fa-sm"></i> Tambah Siswa</a> --}}
                    <a href="#generate_report" data-toggle="modal" class="btn btn-sm btn-primary shadow-sm" ><i class="fas fa-plus fa-sm"></i>Tambah Data Kelas</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-export" class="table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Kelas</th>
                                    <th>Type</th>
                                    <th class="action-btn">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jurusan as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>
                                        {{$item->nama_kelas}}
                                    </td>
                                    <td>{{$item->type}}</td>
                                    <td>
                                        <div class="actions">
                                            <a onclick="preLoad();" class="btn btn-sm btn-primary shadow-sm"href="{{route('edit-kelas',$item->id)}}">
                                                <i class="fas fa-pencil fa-sm"></i> Edit
                                            </a>

                                            <a onclick="preLoad();" class="btn btn-sm btn-danger shadow-sm" href="/delete-siswa/{{$item->id_siswa}}">
                                                    <i class="fe fe-trash"></i> Delete
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
                    <h5 class="modal-title">Tambahkan Jurusan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('add-kelas')}}">
                        @csrf
                        <div class="row form-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Kelas <span class="text-danger">*</span></label>
                                    <select class="form-control" name="nama_kelas">
                                        <option value="X">X</option>
                                        <option value="XI">XI</option>
                                        <option value="XII">XII</option>
                                    </select>
                                    <br>
                                    <label>Type Kelas <span class="text-danger">*</span></label>
                                    <select class="form-control" name="type">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button onclick="preLoad();" type="submit" class="btn btn-primary btn-block">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
