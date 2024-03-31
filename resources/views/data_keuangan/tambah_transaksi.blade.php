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

    <!-- Page Heading -->
    {{-- <h1 class="h3 mb-2 text-primary"><?= $title; ?></h1> --}}

    <!-- card -->
    <div class="card shadow mb-4 py-4 px-4">

        <!-- form Input data -->

        <form method="post" enctype="multipart/form-data" id="update_service" action="{{route('add-transaksi')}}">
            <h3 class="page-title">Form Transaksi</h3>
            @csrf

            <div class="service-fields mb-3">
                <div class="row">

                </div>
            </div>

            <div class="service-fields mb-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Kelas <span class="text-danger">*</span></label>
                            <select class="select2 form-select form-control" name="jur" id="jurusan" required>>
                                <option value="0">-</option>
                                @foreach ($jurusan as $jrsn)
                                    <option value="{{$jrsn->jur_id}}">{{$jrsn->nama_jurusan}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
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
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Nama Siswa <span class="text-danger">*</span></label>
                            <select class="select2 form-select form-control" name="siswa" id="siswa">
                                <option value="0">-</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Nominal Tagihan<span class="text-danger">*</span></label>
                            <input class="form-control" type="number" id="nominal" name="nominal" value="0" readonly>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Tanggal Transaksi<span class="text-danger">*</span></label>
                            <input class="form-control" type="date" id = "date" name="date" > <i class="fe fe-image"></i>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Bulan<span class="text-danger">*</span></label>
                            <input class="form-control" type="number" id = "jumlah" name="Bulan" value="0"  onchange="getTagihan()"> <i class="fe fe-image"></i>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Bukti Pembayaran<span class="text-danger">*</span></label>
                            <input class="form-control" type="file" name="file" value="0"> <i class="fe fe-image"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="service-fields mb-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Keterangan <span class="text-danger">*</span></label>
                            <textarea class="form-control service-desc" name="keterangan"></textarea>
                        </div>
                    </div>

                </div>
            </div>


            <div class="submit-section">
                <button onclick="preLoad();" class="btn btn-primary submit-btn" type="submit" name="form_submit" value="submit">Submit</button>
            </div>
        </form>
    </div>
    </div>

        <!-- akhir form input -->

    </div>
    <!-- /.card -->

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
        $(".body").keyup(function(){
            var tunggakan = parseInt($("#tunggakan").val())
            var jumlah_bayar = parseInt($("#jumlah_bayar").val())

            var sisa = tunggakan - jumlah_bayar;
        $("#sisa").attr("value",sisa)
        });
        function getBukti(val) {
        console.log(val);
        var bukti ='<img src="/img/payment/'+val+'" alt="" width="400" height="500">'
            $('#bukti').append(bukti);
            console.log(bukti);
    }

    function getTagihan() {
        id =  $("#siswa").val();
        jumlah =  $("#jumlah").val();

        console.log(id);
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    }
                });
            $.ajax({
                url: '/get_tagihan',
                type: 'get',
                dataType: 'JSON',
                data: {
                    id:id,
                    jumlah:jumlah
                },
                success: function(data){
                    if (data.status == 'success') {
                        $("#nominal").val(data.nomin_ori);
                    } else {
                        Snackbar.show({
                        text: "Maaf, Jumlah Bulan Yang Anda Masukan Lebih,  Sisa Tagihan Anda Sebanyak " +data.nom + " Bulan",
                        pos: 'top-right',
                        actionTextColor: '#fff',
                        backgroundColor: '#e7515a',
                    });
                        $("#jumlah").val(data.nomin_ori);
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

@endsection
