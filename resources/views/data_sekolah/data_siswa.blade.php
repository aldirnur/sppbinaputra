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
                    {{-- @if(in_array(auth()->user()->level, [1])) --}}
                        <div class="col-sm-12 col">
                            <a href="#generate_report" data-toggle="modal" class="btn btn-sm btn-primary shadow-sm"> <i class="fas fa-plus fa-sm"></i>Import Siswa</a>
                            <a class="btn btn-sm btn-primary shadow-sm" href="{{route('add-siswa')}}"><i class="fas fa-download fa-sm"></i> Tambah Siswa</a>
                        </div>
                    {{-- @endif --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-siswa" class="table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Nis</th>
                                   
                                    <th>Nama</th>
                                    <!-- <th>Jenis Kelamin</th> -->
                                    <!-- <th>Tanggal lahir</th> -->
                                    <!-- <th>Alamat</th> -->
                                    <!-- <th>Tingkat</th> -->
                                    <th>Kelas</th>
                                    <!-- <th>Jurusan</th> -->
                                    <th>Angkatan</th>
                                    <!-- <th>Nama Wali</th> -->
                                    <th>No Telfon</th>
                                    <!-- <th>Agama</th> -->
                                    <!-- <th>Pin</th> -->
                                    <th>Status</th>
                                    @if(in_array(auth()->user()->level, [1]))
                                        <th class="action-btn">Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($siswa as $item)
                                    <tr>
                                        <td>
                                            {{$item->nis}}
                                        </td>
                                    
                                        <td>{{$item->nama}}</td>
                                    
                                        <td>{{isset($item->namakelas) ? $item->namakelas->nama_kelas : ''}} {{isset($item->jurusan) ? $item->jurusan->nama_jurusan : ''}} {{isset($item->namakelas) ? $item->namakelas->type : ''}}</td>
                                    
                                        <td>{{$item->angkatan}}</td>
                                    
                                        <td>{{$item->no_tlp}}</td>
                                        
                                        <td>{{$item->status == 1 ? 'Aktif' : 'Tidak Aktif'}}</td>
                                        @if(in_array(auth()->user()->level, [1]))
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
    <div class="modal fade" id="generate_report" aria-hidden="true" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Import Data Siswa</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" action="/siswa/import_excel" enctype="multipart/form-data">
					@csrf
					<div class="row form-row">
						<div class="col-12">
                            <input type="file" name="file" required="required">
                            <a href="/siswa/export_excel" class="btn btn-primary float-left mt-2">Download Format Import Siswa</a>
						</div>
					</div>
                    <br>
					<button  onclick="preLoad();" type="submit" class="btn btn-primary btn-block">Import</button>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection
