@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Data User') }}</h1>

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
                    <h6 class="m-0 font-weight-bold text-primary">Data User</h6>
                    <a href="#add_user" data-toggle="modal" class="btn btn-sm btn-primary shadow-sm" > <i class="fas fa-user-plus fa-sm"></i>Tambah User</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-export" class="table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <!-- <th>Level</th> -->
                                    <th>Tanggal Pembuatan</th>
                                    <th class="text-center action-btn">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $user)

                                <tr>
                                    <input type="hidden" id="iduser_{{$key}}" value="{{$user->id}}">
                                    <td id="name_{{$key}}">
                                        {{$user->name}}
                                    </td>
                                    <td id="email_{{$key}}">
                                        {{$user->email}}
                                    </td>
                                    {{-- @can('update-role') --}}
                                    <!-- <td id="level_{{$key}}">
                                        {{$user->level}}
                                    </td> -->
                                    {{-- @endcan --}}
                                    <td>{{date_format(date_create($user->created_at),"d M,Y")}}</td>

                                    <td class="text-center">
                                        <div class="actions">
                                            <a data-id="{{$user->id}}" data-name="{{$user->name}}" data-email="{{$user->email}}" class="btn btn-sm btn-primary shadow-sm editbtn"  data-toggle="modal" href="#edit_user" onclick="editUser({{$key}});">
                                                <i class="fe fe-pencil"></i> Edit
                                            </a>

                                            <a data-id="{{$user->id}}" href="javascript:void(0);" class="btn btn-sm btn-danger shadow-sm" data-toggle="modal">
                                                <i class="fe fe-trash"></i> Hapus
                                            </a>

                                            {{-- <a data-id="{{$user->id}}" href="javascript:void(0);" class="btn btn-sm btn-danger shadow-sm" data-toggle="modal">
                                                <i class="fe fe-trash"></i> Delete
                                            </a> --}}

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
    </div>
    <div class="modal fade" id="add_user" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" action="{{route('users')}}">
                        @csrf
                        <div class="row form-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="name" class="form-control" >
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Jabatan</label>
                                    <div class="form-group">
                                        <select class="select2 form-select form-control edit_role" name="level">
                                            @foreach ($level as $key => $lvl)
                                                <option value="{{$key}}">{{$lvl}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Konfirmasi Password</label>
                                            <input type="password" name="password_confirmation" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /ADD Modal -->

    <!-- Edit Details Modal -->
    <div class="modal fade" id="edit_user" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data" action="{{route('users')}}">
                        @csrf
                        @method("PUT")
                        <div class="row form-row">
                            <input type="hidden" name="id" id="edit_id">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="name" id="edit_name" class="form-control edit_name">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control edit_email" id="email">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Jabatan</label>
                                    <div class="form-group">
                                        <select class="select2 form-select form-control edit_role" name="level">
                                            @foreach ($level as $key => $lvl)
                                                <option value="{{$key}}">{{$lvl}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Konfirmasi Password</label>
                                            <input type="password" name="password_confirmation" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
		// $(document).ready(function() {
		// 	$('#datatable-export').on('click','.editbtn',function (){
		// 		event.preventDefault();
		// 		jQuery.noConflict();
		// 		$('#edit_user').modal('show');
		// 		var id = $(this).data('id');
		// 		var name = $(this).data('name');
		// 		var email = $(this).data('email');
		// 		var role = $(this).data('role');
		// 		$('#edit_id').val(id);
		// 		$('.edit_name').val(name);
		// 		$('.edit_email').val(email);
		// 		$('.edit_role').val(role);
		// 	});
		// });
        function editUser(i) {

            console.log(i);
            $('#edit_user').addClass('show');
            var id = $('#iduser_'+i).val();
            console.log(id);
            var name =  document.getElementById("name_"+i).innerText;
            var email =  document.getElementById("email_"+i).innerText;
            var level =  document.getElementById("level_"+i).innerText;
            console.log(level);
            $('#edit_id').val(id);
            $('#edit_name').val(name);
            $('.edit_email').val(email);
            $('.edit_role').val(level);
        }
	</script>
@endsection
