@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Data Siswa') }}</h1>

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
                    <h6 class="m-0 font-weight-bold text-primary">Data Siswa</h6>
                    <a class="btn btn-sm btn-primary shadow-sm" href="{{route('add-siswa')}}"><i class="fas fa-plus fa-sm"></i> Tambah Siswa</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-export" class="table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Nis</th>
                                    <th>Nisn</th>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tanggal lahir</th>
                                    <th>Alamat</th>
                                    <th>No Telfon</th>
                                    <th>Kelas</th>
                                    <th>Jurusan</th>
                                    <th>Nama Wali</th>
                                    <th>Agama</th>
                                    <th>Pin</th>
                                    <th>Status</th>
                                    <th class="action-btn">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($siswa as $item)
                                <tr>
                                    <td>
                                        {{$item->nis}}
                                    </td>
                                    <td>{{$item->nisn}}</td>
                                    <td>{{$item->nama}}</td>
                                    <td>{{$item->jenis_kelamin == 1 ? 'Laki-Laki' : 'Perempuan'}}</td>
                                    <td>{{$item->tgl_lahir}}</td>
                                    <td>{{$item->alamat}}</td>
                                    <td>{{$item->no_tlp}}</td>
                                    <td>{{$item->kelas}}</td>
                                    <td>{{isset($item->jurusan->nama_jurusan) ? $item->jurusan->nama_jurusan : '' }}</td>
                                    <td>{{$item->nama_wali}}</td>
                                    <td>{{$item->agama}}</td>
                                    <td>{{$item->pin}}</td>
                                    <td>{{$item->status == 1 ? 'Aktif' : 'Tidak Aktif'}}</td>
                                    <td>
                                        <div class="actions">
                                            <a onclick="preLoad();" class="btn btn-sm btn-primary shadow-sm" href="{{route('edit-siswa',$item->id_siswa)}}">
                                                <i class="fe fe-pencil"></i> Edit
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

@endsection
