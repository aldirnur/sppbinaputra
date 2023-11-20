@extends('layouts.app-siswa')

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

        <!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-primary">Form Pembayaran SPP</h1>

    <!-- card -->
    <div class="card shadow mb-4 py-4 px-4">

        <form method="post" enctype="multipart/form-data" id="update_service" action="/pembayaran/{{$siswa->id_siswa}}">
            @csrf
            <input type="hidden" name="id_siswa" id="id_siswa" value="{{$siswa->id_siswa}}">
            <input type="hidden" name="nominal_transaksi" id="nominal_transaksi">
            <div class="service-fields mb-3">
                <div class="row" style="display:block" id="section-one">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Nama</label>
                            <input class="form-control" type="text" id="nis" name="nama" value="{{$siswa->nama}}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input class="form-control" type="varchar" id="kelas" name="kelas" value="{{$siswa->namakelas->nama_kelas}} - {{$siswa->namakelas->type}}" readonly>
                        </div>
                    </div>  
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Jurusan</label>
                            <input class="form-control" type="varchar" id="kelas" name="kelas" value="{{$siswa->jurusan->nama_jurusan}}" readonly>
                        </div>
                    </div>     
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Angkatan</label>
                            <input class="form-control" type="varchar" id="kelas" name="kelas" value="{{$siswa->angkatan}}" readonly>
                        </div>
                    </div>                    
                    
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Nominal Tagihan<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="nominal" name="nominal" value="0" readonly>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Jumlah Bulan<span class="text-danger">*</span></label>
                            <input class="form-control" type="number" id="jumlah" name="Bulan" value="0"  onchange="getTagihan()"> <i class="fe fe-image"></i>
                        </div>
                    </div>
                </div>
                <div class="row" style="display:none" id="section-two">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>No Pembayaran</label>
                            <input class="form-control" type="text" id="nominal" name="no_" value="001-{{$siswa->nisn}}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Jumlah Pembayaran<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="jmlh_pembayaran" name="jmlh_pembayaran" value="0" readonly>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Metode Pembayaran <span class="text-danger">*</span></label>
                            <select class="form-control" onchange="getTerm(this.value)" name="payment_method">
                                <option value="1">Pilih Metode Pembayaran</option>
                                <option value="1">Dompet Digital</option>
                                <option value="2">Transfer Bank</option>
                            </select>
                            <br>
                            <a href="#generate_report" data-toggle="modal">Tata Cara Pembayaran</a>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Nominal Tagihan<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="nominall" name="nominal" value="0" readonly>
                            <input class="form-control" type="hidden" id="nominal" name="nominal" value="0" readonly>
                        </div>
                    </div>

                    <!-- <div class="col-lg-12">
                        <div class="form-group">
                            <label>Bukti Bayar<span class="text-danger">*</span></label>
                            <input class="form-control" type="file" name="file" value="0"> <i class="fe fe-image"></i>
                        </div>
                    </div> -->
                </div>
            </div>
            
            <div class="submit-section">
                <button class="btn btn-danger submit-btn" type="button" name="form_submit" id="btn_next" onclick="NextPage()" value="Next" disabled>Lanjutkan Pembayaran</button>
                <button class="btn btn-danger submit-btn" type="submit" style="display:none" id="btn_submit" value="submit" disabled>Bayar</button>
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
<div class="modal fade" id="generate_report" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tata Cara Pembayaran</h5>
                <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="bukti">
            </div>
        </div>
    </div>
</div>
<!-- End of Main Content -->

<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
function getTerm(val) {
    if (val == 1) {
        var bukti ='<p> Dompet Digital<p>'+
                '<p>Pilih Pembayaran';
    } else {
        var bukti ='<p> Rekening<p>'+
                '<p>Pilih Pembayaran';
    }
    
        $('#bukti').append(bukti);
}

function NextPage() {
    $("#btn_submit").css("display", "block");
    $("#btn_next").css("display", "none");
    $("#section-two").css("display", "block");
    $("#section-one").css("display", "none");
    
}
function getTagihan() {
    id =  $("#id_siswa").val();
    jumlah =  $("#jumlah").val();
    console.log(id)

    event.preventDefault();
    if (jumlah > 0) {
        $('#btn_submit').removeClass('btn btn-danger submit-btn');
        $('#btn_submit').addClass('btn btn-primary submit-btn');
        $('#btn_submit').prop("disabled", false);

        $('#btn_next').removeClass('btn btn-danger submit-btn');
        $('#btn_next').addClass('btn btn-primary submit-btn');
        $('#btn_next').prop("disabled", false);
    }

    if (jumlah < 0) {
        $('#btn_submit').removeClass('btn btn-primary submit-btn');
        $('#btn_submit').addClass('btn btn-danger submit-btn');
        $('#btn_submit').prop("disabled", true);

        $('#btn_next').removeClass('btn btn-primary submit-btn');
        $('#btn_next').addClass('btn btn-danger submit-btn');
        $('#btn_next').prop("disabled", true);

        Snackbar.show({
            text: "Maaf , Jumlah Bulan Tidak boleh Kurang dari 0",
            pos: 'top-right',
            actionTextColor: '#fff',
            backgroundColor: '#e7515a',
        });
        $("#nominal").val(0);
        $("#jumlah").val(0);
    }

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
                    if (jumlah > 0) {
                        $("#jmlh_pembayaran").val(data.nom);
                        $("#nominal").val(data.nom);
                        $("#nominal_transaksi").val(data.nominal);
                    }
                    $("#bulan").val(data.bulan);
                } else {
                    Snackbar.show({
                    text: data.message,
                    pos: 'top-right',
                    actionTextColor: '#fff',
                    backgroundColor: '#e7515a',
                });
                    $("#jumlah").val(data.nom);
                    $("#jmlh_pembayaran").val(data.nom);
                }
            }
        });
    }

function changePm (val) {
    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            });
        $.ajax({
            url: '/get_pm',
            type: 'get',
            dataType: 'JSON',
            data: {
                id:val
            },
            success: function(data){
                if (data.status == 'success') {
                    var myDiv = document.getElementById("myDiv");
                    console.log(data.text);
                    var textArray = data.text.split(" ");
                    myDiv.innerHTML = "";
                    for (var i = 0; i < textArray.length; i++) {
                        var paragraph = document.createElement("p");
                        paragraph.textContent = textArray[i];
                        myDiv.appendChild(paragraph);
                    }
                     
                } else {
                    Snackbar.show({
                    text: data.message,
                    pos: 'top-right',
                    actionTextColor: '#fff',
                    backgroundColor: '#e7515a',
                });

                }
            }
        });
    var test = $("#desc"+val).val();
    console.log(test);
}

</script>

    </div>

@endsection
