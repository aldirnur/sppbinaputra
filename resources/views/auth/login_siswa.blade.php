@extends('layouts.auth')

@section('main-content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-lg-8">

        <style type="text/css">
              body {
                background-image: linear-gradient(120deg,#2FA2E5,#65D6F4);
            }
          </style>

          <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-5">
              <!-- Nested Row within Card Body -->
              <div class="row">
                <div class="col-lg">
                  <div class="p-4">
                    <div class="text-center">
                      <img src="{{ asset('img/cover-login.png') }}" alt="logo-image" class="img-circle"><br><br>
                      <h1 class="h4 text-gray-900 mb-0"><b>SISTEM INFORMASI<br>PEMBAYARAN SPP<br>SMK BINA PUTRA</h1>
                      <p class="mb-1"><em class="text-primary">Selamat datang silahkan masuk sebagai</em></p>
                      <!-- <p class="lead text-gray-900 mb-3">SMK BINA PUTRA</p> -->
                      <hr>
                      @if(session('error'))
                          <div class="alert alert-danger">
                              {{ session('error') }}
                          </div>
                      @endif
                      <h1 class="h4 text-gray-900">Login Siswa</h1><br>
                    </div>
                    @if(session('login_error'))
                        <div class="alert alert-danger">
                            {{ session('login_error') }}
                        </div>
                    @endif
                    <form class="user" action="/pembayaran" method="get">
                        @csrf
                        <div class="form-group">
                            <input class="form-control" name="nis" type="text" value="{{old('name')}}" placeholder="NIS"> <br>
                            <input class="form-control" id="password" name="password" type="password" value="{{old('nis')}}" placeholder="Password">
                        </div>
                      <div class="form-group">
                          <label for="new_password"> <h6>&emsp;</h6></label>
                          <input type="checkbox" class="form-check-input" id="show-password">Tampilkan Pin
                      </div>

                      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                        <script>
                            $(document).ready(function() {
                                $('#show-password').click(function() {
                                    if ($(this).is(':checked')) {
                                        $('#password').attr('type', 'text');
                                    } else {
                                        $('#password').attr('type', 'password');
                                    }
                                });
                            });
                        </script>

                      <button type="submit" class="btn btn-primary btn-user btn-block">
                        Login
                      </button>
                    </form><br>
                    <div class="text-center dont-have"><a href="{{route('login')}}">Akses Admin</a></div>
                    <hr>

                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
</div>
@endsection
