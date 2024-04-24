@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Data Tagihan')}} {{$tahun}}</h1>

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
                     <h6 class="m-0 font-weight-bold text-primary">Data Tagihan</h6> 

                    <div class="col-sm-0 col">
                        <a class="btn btn-sm btn-primary shadow-sm"  href="#generate_report" data-toggle="modal"><i class="fas fa-download fa-sm"></i> Import Tagihan</a>
                        <a class="btn btn-sm btn-primary shadow-sm"  href="#add-tagihan" data-toggle="modal"><i class="fas fa-plus fa-sm"></i>  Tambah Tagihan</a>
                        <!-- <a class="btn btn-sm btn-primary shadow-sm"  onclick="location.reload()" href="#" data-toggle="modal"><i class="fas fa-fw fa-comments"></i>  Send Notfikasi Tagihan</a> -->
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-siswa" class=" table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Tahun Pembayaran</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <!-- <th>Jurusan</th> -->
                                    <th>Nominal SPP</th>
                                    <th>Jumlah Bulan Yang Belum Di Bayarkan</th>
                                    <!-- <th>Bulan Yang Belum Di Bayarkan</th> -->
                                    <th>Jumlah Tagihan</th>
                                    <th>Status</th>
                                    <th class="action-btn">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tagihan as $item)
                                @php
                                    $nomin = isset($item->spp->nominal_spp) ? $item->spp->nominal_spp : 0;
                                    $total = $nomin * $item->jumlah
                                @endphp
                                    <tr>
                                        <td>{{$item->angkatan}}</td>
                                        <td>
                                            {{isset($item->siswa->nama) ? $item->siswa->nama : ''}}
                                        </td>
                                        <td>
                                            {{isset($item->siswa->namakelas) ? $item->siswa->namakelas->nama_kelas : ''}} {{isset($item->siswa->jurusan) ? $item->siswa->jurusan->nama_jurusan : ''}} {{isset($item->siswa->namakelas) ? $item->siswa->namakelas->type : ''}} 
                                        </td>
                                        
                                        <td>Rp. {{number_format($item->spp->nominal_spp,2, ',', '.')}}</td>
                                        <td>{{$item->jumlah}}</td>
                                        <!-- <td>
                                            @php ($bulan = json_decode($item->bulan))@endphp
                                            @php ($namaBulan = $bulan) @endphp
                                            @foreach ($bulan as $index => $value)
                                                @php ($nama = $namaBulan[$index % 12]) @endphp
                                                {{$nama}}
                                                @if ($index != count($bulan) - 1)
                                                    ,
                                                @endif
                                            @endforeach
                                        </td> -->
                                        <td>Rp. {{number_format($total,2, ',', '.')}}</td>
                                        @if ($item->status == 1)
                                            <td><span class="btn btn-sm bg-success-light">Lunas</span></td>
                                        @else
                                            <td><span class="btn btn-sm bg-danger-light">Belum Lunas</span></td>
                                        @endif
                                        <td>
                                            <div class="actions">
                                                <a class="btn btn-sm btn-primary shadow-sm" href="{{route('edit-tagihan',$item->tag_id)}}">
                                                    <i class="fe fe-pencil"></i> Edit
                                                </a>
                                                <a onclick="preLoad();" class="btn btn-sm btn-danger shadow-sm" href="/delete-tagihan/{{$item->tag_id}}">
                                                    <i class="fe fe-trash"></i> Hapus
                                                </a>
                                                <a  class="btn btn-sm btn-success shadow-sm" href="/kirim-tagihan/{{$item->tag_id}}">
                                                    <i class="fas fa-fw fa-comments"></i> Kirim SMS
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
        @foreach ($spp  as $sp )
            <a class="btn btn-sm btn-primary shadow-sm" href="{{route('tagihan', 'tahun=' . $sp->tahun_ajaran)}}"><i class="fa-solid fa-bars-staggered"></i>{{$sp->tahun_ajaran}}</a>
        @endforeach
    </div>
    <div class="modal fade" id="generate_report" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Tagihan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('import-excel-tagihan')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row form-row">
                            <div class="col-12">
                                <input type="file" name="file" required="required">
                                <a href="{{route('export-excel-tagihan')}}" class="btn btn-primary float-left mt-2">Download Format Tagihan Siswa</a>
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary btn-block">Import</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add-tagihan" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Tagihan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('add-tagihan')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row form-row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Jurusan <span class="text-danger">*</span></label>
                                    <select class="select2 form-select form-control" name="jur" id="jurusan" required>>
                                        <option value="0">-</option>
                                        @foreach ($jurusan as $jrsn)
                                            <option value="{{$jrsn->jur_id}}">{{$jrsn->nama_jurusan}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Kelas <span class="text-danger">*</span></label>
                                    <select class="select2 form-select form-control" name="kelas" id="" onchange="get_siswa(this.value)" required>>
                                        <option value="0">-</option>
                                        @foreach ($kelas as $kls)
                                            <option value="{{$kls->id}}">{{$kls->nama_kelas}} - {{$kls->type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Nama Siswa <span class="text-danger">*</span></label>
                                    <select class="select2 form-select form-control" name="siswa" id="siswa">
                                        <option value="0">-</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Jumlah <span class="text-danger">*</span></label><br>
                                    <input type="number" name="jumlah" required="required" value="12" readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <button  onclick="preLoad();" type="submit" class="btn btn-primary btn-block">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
function getSpp(val) {
    event.preventDefault();
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            }
        });
    $.ajax({
        url: '/get_spp',
        type: 'get',
        dataType: 'JSON',
        data: {
            id:val
        },
        success: function(data) {
            if (data.status == 'success') {
                $("#nominal").val(data.nom);
                $("#id_spp").val(data.id);
            } else {
                Snackbar.show({
                text: data.message,
                pos: 'top-right',
                actionTextColor: '#fff',
                backgroundColor: '#e7515a',
            });
                $("#nominal").val(data.nom);
                $("#id_spp").val('');

            }
        }
    }); 
}

function get_siswa(val) {
    let jurusan_id = $("#jurusan").val();
    $.ajaxSetup({ 
    headers: { 
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
    }
    });
    $.ajax({
        url : '/get_siswa',
        type : 'get',
        dataType : 'JSON',
        data : {
            id : val,
            jurusan_id : jurusan_id
        },
        success : function(data){
            if(data.status =='success'){
                let option = '';
                $.each(data.data, function(key, value){
                    console.log(value)
                    option += '<option value="'+value.id_siswa+'">'+value.nama+'</option>';
                    $("#siswa").html(option);
                });
            } else {
                Snackbar.show({
                    text: "Maaf, Data Siswa Tidak Ditemukan",
                    pos: 'top-right',
                    actionTextColor: '#fff',
                    backgroundColor: '#e7515a',
                })
            }
        }
    });
}  

</script>