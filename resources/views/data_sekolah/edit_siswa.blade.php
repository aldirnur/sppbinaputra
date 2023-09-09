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

        <form method="post" enctype="multipart/form-data" action="{{route('update-siswa',$siswa)}}">
            @csrf
            <div class="service-fields mb-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Nis<span class="text-danger">*</span></label>
                            <input class="form-control" value="{{$siswa->nis}}" type="text" name="nis" readonly>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <label>Nisn<span class="text-danger">*</span></label>
                        <input class="form-control" value="{{$siswa->nisn}}" type="text"  name="nisn" readonly>
                    </div>
                </div>
            </div>

            <div class="service-fields mb-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Nama<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" value="{{$siswa->nama}}"  name="nama">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Jenis Kelamin <span class="text-danger">*</span></label>
                            <select class="form-control" name="jenis_kelamin">
                                <option value="1" {{$siswa->jenis_kelamin == 1 ? 'selected' : ''}}>Laki Laki </option>
                                <option value="2" {{$siswa->jenis_kelamin == 2 ? 'selected' : ''}}>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select class="form-control" name="status">
                                <option value="1" {{$siswa->status == 1 ? 'selected' : ''}}>Aktif </option>
                                <option value="2" {{$siswa->status == 2 ? 'selected' : ''}}>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="service-fields mb-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>No Telfon <span class="text-danger">*</span></label>
                            <input type="number" name="no_tlp" value="{{$siswa->no_tlp}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tgl" value="{{$siswa->tgl_lahir}}" class="form-control">
                    </div>
                </div>
            </div>

            <div class="service-fields mb-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Agama <span class="text-danger">*</span></label>
                            <select class="form-control" name="agama">
                                <option value="Islam" {{$siswa->agama == 'Islam' ? 'selected' : ''}}>Islam </option>
                                <option value="Kristen" {{$siswa->agama == 'Kristen' ? 'selected' : ''}} >Kristen</option>
                                <option value="Protestan" {{$siswa->agama == 'Protestan' ? 'selected' : ''}} >Protestan</option>
                                <option value="Hindhu" {{$siswa->agama == 'Hindhu' ? 'selected' : ''}} >Hindhu</option>
                                <option value="Budha" {{$siswa->agama == 'Budha' ? 'selected' : ''}} >Budha</option>
                                <option value="Lainnya" {{$siswa->agama == 'Lainnya' ? 'selected' : ''}} >Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <label>Wali</label>
                        <input type="text" name="nama_wali" value="{{$siswa->nama_wali}}" class="form-control">
                    </div>
                </div>
            </div>

            <div class="service-fields mb-3">
                <div class="row">
                <div class="col-lg-12">
                        <label>Angkatan</label>
                        <input type="text" name="angkatan" value="{{$siswa->angkatan}}" class="form-control">
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Kelas <span class="text-danger">*</span></label>
                            <select class="form-control" name="kelas">
                                @foreach ($kelas as $kls )
                                    <option value="{{$kls->id}}" {{$kls->id == $siswa->kelas ? 'selected' : ''}}>{{$kls->nama_kelas}} - {{$kls->type}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Jurusan <span class="text-danger">*</span></label>
                            <select class="select2 form-select form-control" name="jurusan">
                                <option value="0">-</option>
                                @foreach ($jurusan as $jrs)
                                    <option value="{{$jrs->jur_id}}" {{$siswa->jur_id == $jrs->jur_id ? 'selected' : ''}}>{{$jrs->nama_jurusan}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <label>Pin</label>
                        <input type="text" maxlength="6" name="pin" value="{{$siswa->pin}}" placeholder="123456" class="form-control">
                    </div>
                </div>
            </div>

            <div class="service-fields mb-3">
                <div class="row">
                    <div class="col-12">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control" value="" cols="30" rows="10">{{$siswa->alamat}}</textarea>
                    </div>
                </div>
            </div>

            <div class="submit-section">
                <button onclick="preLoad();" class="btn btn-primary submit-btn" type="submit" name="form_submit" value="submit">Submit</button>
                <a href="{{route('siswa')}}" class="btn btn-primary submit-btn">Batal</a>
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
