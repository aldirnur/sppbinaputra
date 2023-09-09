@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    {{-- <h1 class="h3 mb-4 text-gray-800">{{ __('Data Transaksi') }}</h1> --}}

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
            <div class="card shadow mb-4 py-4 px-4">
                <form method="post" enctype="multipart/form-data" action="{{route('edit-kelas',$jurusan->id)}}">
                    @csrf
                    @method("PUT")
                    <div class="service-fields mb-3">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Nama Kelas<span class="text-danger">*</span></label>
                                    
                                    <select class="form-control" name="nama_kelas">
                                        <option value="X" {{$jurusan->nama_kelas == 'X' ? 'selected' : ''}}>X</option>
                                        <option value="XI" {{$jurusan->nama_kelas == 'XI' ? 'selected' : ''}}>XI</option>
                                        <option value="XII" {{$jurusan->nama_kelas == 'XII' ? 'selected' : ''}}>XII</option>
                                    </select>
                                    <br>
                                    <label>Type Kelas <span class="text-danger">*</span></label>
                                    <select class="form-control" name="type">
                                        <option value="A" {{$jurusan->type == 'A' ? 'selected' : ''}}>A</option>
                                        <option value="B" {{$jurusan->type == 'B' ? 'selected' : ''}}>B</option>
                                        <option value="C" {{$jurusan->type == 'C' ? 'selected' : ''}}>C</option>
                                    </select>
                                </div> 
                            </div>
                        </div>
                    </div>

                    <div class="submit-section">
                        <button onclick="preLoad();" class="btn btn-primary submit-btn" type="submit" name="form_submit" value="submit">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

</div>


    </div>

@endsection
