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
    {{-- <h1 class="h3 mb-2 text-primary"><?= $title; ?></h1> --}}

    <!-- card -->
    <div class="card shadow mb-4 py-4 px-4">
        <form method="post" enctype="multipart/form-data" id="update_service" action="{{route('edit-transaksi', $transaksi->trans_id)}}">
            <H2>Edit Transaksi</H2>
            @csrf

            <div class="service-fields mb-3">
                <div class="row">

                </div>
            </div>

            <div class="service-fields mb-3">
                <div class="row">

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select class="select2 form-select form-control" onchange="getStatus(this.value)" id="status" name="status">
                                @foreach ($status as $key => $sts)
                                    <option value="{{$key}}" {{$key == $transaksi->status_transaksi ? 'selected' : ''}}>{{$sts}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Nominal<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="nominal" value="{{$transaksi->nominal_transaksi}}">
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Tanggal<span class="text-danger">*</span></label>
                            <input class="form-control" type="date" name="date" value="{{$transaksi->tgl}}"> <i class="fe fe-image"></i>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Bukti Pembayaran </label> <br>
                            <a href="#generate_report"  data-toggle="modal">{{$transaksi->bukti_transaksi}}</a>
                            {{-- <input class="form-control" type="text" name="file" value="{{$transaksi->bukti}}"> <i class="fe fe-image"></i> --}}
                        </div>
                    </div>
                    <div class="col-lg-12" style="display: none" id="user_note">
                        <div class="form-group">
                            <label>Keterangan Ditolak<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="user_note" >
                        </div>
                    </div>
                </div>
            </div>

            <div class="service-fields mb-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Keterangan <span class="text-danger">*</span></label>
                            <textarea class="form-control service-desc" name="keterangan">{{$transaksi->keterangan}}</textarea>
                        </div>
                    </div>

                </div>
            </div>


            <div class="submit-section">
                <button onclick="preLoad()" class="btn btn-primary submit-btn" type="submit" name="form_submit" value="submit">Submit</button>
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
                        $("#nominal").val(data.nom);
                    } else {
                        Snackbar.show({
                        text: "Maaf, Jumlah Bulan Yang Anda Masukan Lebih,  Sisa Tagihan Anda Sebanyak " +data.nom + " Bulan",
                        pos: 'top-right',
                        actionTextColor: '#fff',
                        backgroundColor: '#e7515a',
                    });
                        $("#jumlah").val(data.nom);
                    }
                }
            });
        }
</script>

    </div>

@endsection
