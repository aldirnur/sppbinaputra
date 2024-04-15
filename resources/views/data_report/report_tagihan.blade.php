@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Data Report Tagihan') }}</h1>

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
                    <h6 class="m-0 font-weight-bold text-primary">Data Report Tagihan Siswa</h6>
                    <a class="btn btn-sm btn-primary shadow-sm" href="#generate_report" data-toggle="modal"><i class="fas fa-book fa-sm"></i> Filter Laporan</a>
                </div>
                <div class="card-body">
                    
                </div>
            </div>
                {{-- @isset($siswa) --}}
                    <!--  Sales -->
                    <div class="card shadow mb-4">

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable-siswa" class="table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Siswa</th>
                                            <th>Kelas</th>
                                            <th>Jurusan</th>
                                            <th>Tahun Tagihan</th>
                                            <th>Jumlah Tagihan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php ($no = 1)
                                        @php ($sub = 0)
                                        @foreach ($siswa as $sw)
                                            @if (count($sw->tagihan) > 0) 
                                                @foreach ($sw->tagihan as $tag)
                                                    @for($jmlh =0; $jmlh < $tag->jumlah; $jmlh++)
                                                    @php ($sub += $tag->spp->nominal_spp)
                                                        <tr>
                                                            <td>{{$no++}}</td>
                                                            <td>
                                                                {{$sw->nama}}
                                                            </td>
                                                            <td>{{$sw->namaKelas->nama_kelas}} - {{$sw->namaKelas->type}}</td>
                                                            <td>{{$sw->jurusan->nama_jurusan}}</td>
                                                            <td>{{$tag->angkatan}}</td>
                                                            <td>{{number_format($tag->spp->nominal_spp,2) }}</td>
                                                        </tr>
                                                    @endfor
                                                @endforeach
                                            @endif
                                        @endforeach
                                        @php ($saldo = $sub)
                                    </tbody>
                                </table>
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Tagihan</div>
                                        {{-- <div class="">{{$saldo}}</div> --}}
            
                                        <h3 class="h5 mb-0 font-weight-bold text-gray-800">Rp. {{number_format($saldo,2, ',', '.')}}</h3>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-book fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                {{-- @endisset --}}
        </div>

    </div>

<div class="modal fade" id="generate_report" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Laporan Keuangan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="get" action="{{route('reports-tagihan')}}">
                    @csrf
                    <div class="row form-row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Kelas</label>
                                        <select class="form-control" name="kelas" id="">
                                            @foreach ($kelas as $klss)
                                                <option value="{{$klss->id}}" {{$klss->id == $kls ? 'selected' : ''}}>{{$klss->nama_kelas}} - {{$klss->type}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Jurusan</label>
                                        <select class="form-control" name="jurusan" id="">
                                            @foreach ($jurusan as $jrs)
                                                <option value="{{$jrs->jur_id}}" {{$jrs->jur_id == $jrsn ? 'selected' : ''}}>{{$jrs->nama_jurusan}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Tahun Tagihan</label>
                                        <select class="form-control" name="angkatan" id="">
                                            @for($year = date('Y'); $year >= 2017; $year--)
                                                <option value="{{ $year }}">{{$year}}</option>
                                            @endfor
                                           
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button onclick="preLoad();" type="submit" class="btn btn-primary btn-block">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection