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
                            <input type="hidden" id="nis" name="nis" value="{{$siswa->nis}}">
                            <input class="form-control" type="text" id="nama" name="nama" value="{{$siswa->nama}}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Tingkat</label>
                            <input class="form-control" type="varchar" id="kelas" name="kelas" value="{{$siswa->kelas}}" readonly>
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
                            <label>Metode Pembayaran <span class="text-danger">*</span></label>
                            <select class="form-control" id="payment_method" onchange="getCode(this.value)" name="payment_method">
                                <option value="0">Pilih Metode Pembayaran</option>
                                @foreach ($metodePembayaran as $metode)
                                    <option value="{{$metode->id}}">{{$metode->type == 1 ? 'Bank Transfer' : 'Dompet Digital'}} - {{$metode->nama}}</option>
                                @endforeach
                                
                            </select>
                            <br>
                            <a href="#generate_report" data-toggle="modal">Tata Cara Pembayaran</a>
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
                            <label>Nominal Tagihan<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="nominall" name="nominal" value="0" readonly>
                            <input class="form-control" type="hidden" id="nominal" name="nominal" value="0" readonly>
                        </div>
                    </div>

                </div>
                <div class="row"  style="display:none" id="section-three">
                    <div class="col-lg-12">
                        <h1><i> Silahkan Lakukan Konfirmasi Pembayaran</i></h1>
                        <br>
                        <h3>No Pembayaran : {{isset($transaksi) ? $transaksi->metodePembayaran->code : 0}} - {{isset($transaksi) ? $siswa->nis : 0}} </h3>
                        <h3>Total Pembayaran : {{number_format(isset($transaksi) ? $transaksi->nominal_transaksi : 0)}} </h3>
                        <h3>Batas Waktu Pembayaran : <span id="countdown"></span></h3>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Bukti Bayar<span class="text-danger">*</span></label>
                            <input class="form-control" type="file" name="file" value="0"> <i class="fe fe-image"></i>
                        </div>
                    </div> 
                </div>
            </div>
            
            <div class="submit-section">
                <button class="btn btn-danger submit-btn" type="button" name="form_submit" id="btn_next" onclick="NextPage(1)" value="Next" disabled>Selanjutnya</button>
                <button class="btn btn-danger submit-btn" type="button" name="form_submit" style="display: none" id="btn_confirm" onclick="NextPage(2)" value="Next" disabled>Konfirmasi Pembayaran</button>
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
var nis = $("#nis").val();
var transaksi = '{{isset($transaksi->trans_id) ? $transaksi->trans_id : 0}}';

if(transaksi != 0) {
    NextPage(2)
    let deadline = '{{ isset($transaksi) ? $transaksi->expired_pembayaran : 0 }}';
    const deadlineTimestamp = new Date(deadline).getTime()/1000;

    let countdown = setInterval(function() {
      
    const now = Math.floor(Date.now() / 1000);

    const diff = deadlineTimestamp - now;

    if(diff <= 0) {
    clearInterval(countdown);
    document.getElementById('countdown').innerHTML = 'expired!';
    return;
    }

    const hours = Math.floor(diff / 3600);
    const minutes = Math.floor((diff % 3600) / 60);
    const seconds = Math.floor(diff % 60);

    document.getElementById('countdown').innerHTML = 
        hours + ' Jam ' + minutes + ' Menit ' + seconds + ' Detik';

    }, 1000);

}

const inputFile = document.querySelector('input[type="file"]');
inputFile.addEventListener('change', function() {

if (this.files.length > 0) { 
    $('#btn_submit').removeClass('btn btn-danger submit-btn');
    $('#btn_submit').addClass('btn btn-primary submit-btn');
    $('#btn_submit').prop("disabled", false);
} 

});

function NextPage(value) {
    if (value == 1) {
        $("#btn_submit").css("display", "none");
        $("#btn_next").css("display", "none");
        $("#btn_confirm").css("display", "block");
        $("#section-two").css("display", "block");
        $("#section-one").css("display", "none");
        $("#section-three").css("display", "none");

    } else {
        $("#btn_submit").css("display", "none");
        $("#btn_next").css("display", "none");
        $("#btn_confirm").css("display", "none");
        $("#section-two").css("display", "none");
        $("#section-one").css("display", "none");
        $("#section-three").css("display", "block");
        $("#btn_submit").css("display", "block");

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        
        let id_siswa = $("#id_siswa").val();
        let nominal_transaksi = $("#nominal").val();
        let keterangan = $("#keterangan").val();
        let payment_method = $("#payment_method").val();

        console.log('id_siswa' + id_siswa);
        console.log('nominal_transaksi' + nominal_transaksi);

        $.ajax({
            url: 'simpan_pembayaran',
            method: 'GET',
            data: {
                id_siswa: id_siswa,
                nominal_transaksi: nominal_transaksi,
                payment_method : payment_method
            },
            success: function (data) {
                if (data.status == 'success') {
                    if (data.tipe == 'insert') {
                        location.reload()
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
    }  
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
                        $("#nominal").val(data.nomin_ori);
                        $("#nominall").val(data.nom);
                        
                        $("#nominal_transaksi").val(data.nomin_ori);
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

function getCode(id) {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    $.ajax({ 
        url: '/get_code',
        type: 'get',
        dataType: 'JSON',
        data: { 
            id:id
        },
        success: function(data){
            if (data.status =='success') {
                $('#no_pembayaran').val(data.code + ' - '+ nis);
                $('#btn_confirm').removeClass('btn btn-danger submit-btn');
                $('#btn_confirm').addClass('btn btn-primary submit-btn');
                $('#btn_confirm').prop("disabled", false);
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

}

</script>

    </div>

@endsection
