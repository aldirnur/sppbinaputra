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
            <div class="service-fields mb-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Nama</label>

                            <input class="form-control" type="text" id="nis" name="nama" value="{{$siswa->nama}}" readonly>
                        </div>
                    </div>
                    
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input class="form-control" type="varchar" id="kelas" name="kelas" value="{{$siswa->kelas}}" readonly>
                        </div>
                    </div>

                    
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Metode Pembayaran <span class="text-danger">*</span></label>
                            <select class="form-control" name="payment_method" onclick="changePm(this.value)">
                                @foreach ($payment_method as $pm )
                                    <option value="{{$pm->pm_id}}">{{$pm->nama}} - {{$pm->no_account}}</option>
                                @endforeach
                            </select>
                            <div id="myDiv">
                            </div>
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

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Bulan</label>
                            <input class="form-control" type="text" id="bulan" name="bulan" readonly> <i class="fe fe-image"></i>
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
            <div class="submit-section">
                <button class="btn btn-danger submit-btn" type="submit" name="form_submit" id="btn_submit" value="submit" disabled>Bayar</button>
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

function getTagihan() {
    id =  $("#id_siswa").val();
    jumlah =  $("#jumlah").val();

    event.preventDefault();
    if (jumlah > 0) {
        $('#btn_submit').removeClass('btn btn-danger submit-btn');
        $('#btn_submit').addClass('btn btn-primary submit-btn');
        $('#btn_submit').prop("disabled", false);
    }

    if (jumlah < 0) {
        $('#btn_submit').removeClass('btn btn-primary submit-btn');
        $('#btn_submit').addClass('btn btn-danger submit-btn');
        $('#btn_submit').prop("disabled", true);

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
                        $("#nominal").val(data.nom);
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
