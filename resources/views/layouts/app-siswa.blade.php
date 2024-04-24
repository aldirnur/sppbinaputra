<html>
    <head>
        <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Laravel SB Admin 2">
    <meta name="author" content="Alejandro RH">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Fonts -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link href="{{ asset('img/favicon.png') }}" rel="icon" type="image/png">
    <link rel="stylesheet" href="{{asset('plugins/snackbar/snackbar.min.css')}}">
    <!DOCTYPE html>
    <script src="{{asset('plugins/snackbar/snackbar.min.js')}}"></script>


    <link rel="stylesheet" href="{{asset('plugins/DataTables/datatables.css')}}">

    <style>
        .otp-field {
        flex-direction: row;
        column-gap: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        }

        .otp-field input {
        height: 45px;
        width: 42px;
        border-radius: 6px;
        outline: none;
        font-size: 1.125rem;
        text-align: center;
        border: 1px solid #ddd;
        }
        .otp-field input:focus {
        box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
        }
        .otp-field input::-webkit-inner-spin-button,
        .otp-field input::-webkit-outer-spin-button {
        display: none;
        }

        .resend {
        font-size: 12px;
        }

        .footer {
        position: absolute;
        bottom: 10px;
        right: 10px;
        color: black;
        font-size: 12px;
        text-align: right;
        font-family: monospace;
        }

        .footer a {
        color: black;
        text-decoration: none;
        }
    </style>

</head>
<body id="page-top">


<!-- Page Wrapper -->
<div id="wrapper">
    <!-- Sidebar -->
    <!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-user"></i>
        </div>
        <div class="sidebar-brand-text mx-3">PEMBAYARAN SPP</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <form action="">
        <input type="hidden" name="">
    </form> 
        
        <!-- Nav Item - Charts -->
        {{-- <li class="nav-item">
            <a class="nav-link btn-logout" href="">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li> --}}

        <li class="nav-item">
            <a class="nav-link btn-logout" href="/pembayaran?nis={{$siswa->nis}}&password={{$siswa->pin}}">
            <i class="fas fa-fw fa-wallet"></i>
            <span>Pembayaran SPP</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link btn-logout" href="{{route('tagihan-siswa', $siswa->id_siswa)}}">
            <i class="fas fa-fw fa-credit-card"></i>
            <span>Data Tagihan</span>
        </a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link btn-logout" href="{{route('history',$siswa->id_siswa)}}">
            <i class="fas fa-fw fa-credit-card"></i>
                <span>Data Transaksi</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn-logout" href="{{route('data-pembayaran',$siswa->id_siswa)}}">
                <i class="fas fa-fw fa-history"></i>
                <span>Data Pembayaran</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link btn-logout" href="{{route('logout')}}" >
                <i class="fas fa-fw fa-power-off"></i>
                <span>Logout</span>
            </a>
        </li>
        
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
</ul>
<!-- End of Sidebar
End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>
                <img src="{{asset('/img/binputsmall.png')}}" alt="logo-image" class="img-circle">
                <h4 class="lead text-gray-800 d-none d-lg-block ml-3 mt-2">Sistem Informasi Pengelolaan SPP SMK BINA PUTRA </h4>

                <!-- Topbar Search -->
                {{-- <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form> --}}

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    {{-- <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li> --}}

                    <!-- Nav Item - Alerts -->
                    {{-- <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell fa-fw"></i>
                            <!-- Counter - Alerts -->
                            <span class="badge badge-danger badge-counter">3+</span>
                        </a>
                        <!-- Dropdown - Alerts -->
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                            <h6 class="dropdown-header">
                                Alerts Center
                            </h6>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-file-alt text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 12, 2019</div>
                                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-success">
                                        <i class="fas fa-donate text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 7, 2019</div>
                                    $290.29 has been deposited into your account!
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-warning">
                                        <i class="fas fa-exclamation-triangle text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 2, 2019</div>
                                    Spending Alert: We've noticed unusually high spending for your account.
                                </div>
                            </a>
                            <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                        </div>
                    </li> --}}

                    <!-- Nav Item - Messages -->

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"></span>
                            <figure class="img-profile rounded-circle avatar font-weight-bold" data-initial="">
                                <img src="{{asset('/img/user.png')}}" alt="logo-image" class="img-circle">
                            </figure>

                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="/profile/{{$nisn}}">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                {{ __('Profile') }}
                            </a>
                            <!-- <a class="dropdown-item" href="javascript:void(0)">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                {{ __('Ubah PIN') }}
                            </a>  -->
                            <!-- <a class="dropdown-item" href="javascript:void(0)">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                {{ __('Activity Log') }}
                            </a> -->
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{route('login-siswa')}}" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                {{ __('Logout') }}
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                @yield('main-content')

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">

            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>&copy; SMK Bina Putra | Created by @Aldi.RN - 18111246</span>
                </div>
            </div>

        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Apakah Yakin Keluar?') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Klik Logout Jika Ingin Keluar.</div>
            <div class="modal-footer">
                <button class="btn btn-link" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                <a class="btn btn-danger" href="{{route('login-siswa')}}">{{ __('Logout') }}</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="generate_token" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="text-align: center">Silahkan Masukan Kode OTP</h5>
                
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('add-token')}}">
                    @csrf
                    {{-- <div class="row form-row">
                        <div class="col-12">
                            @if(Session::has('message'))
                                <em class="text-danger">{{ Session::get('message') }}</em>
                            @endif
                            <div class="otp-field mb-4">
                                <input type="number" />
                                <input type="number" disabled />
                                <input type="number" disabled />
                                <input type="number" disabled />
                                <input type="number" disabled />
                                <input type="number" disabled />
                              </div>
                            <div class="form-group">
                                <br>
                                <label style="font-weight: 10px">OTP <span class="text-danger">*</span></label>
                                
                                <input class="form-control" type="number" name="token">
                            </div>
                        </div>
                    </div> --}}
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-6 col-lg-4" style="min-width: 500px;">
                            <div class="card bg-white mb-5 mt-5 border-0" style="box-shadow: 0 12px 15px rgba(0, 0, 0, 0.02);">
                                <div class="card-body p-5 text-center">
                                    
                                    <h4>OTP</h4>
                                    <p>Silahkan Masukan OTP Anda</p>
                                    @if(Session::has('message'))
                                        <em class="text-danger">{{ Session::get('message') }}</em>
                                    @endif
                                    
                                    <div class="otp-field mb-4">
                                        <input type="number" name="otp1"  />
                                        <input type="number" name="otp2" disabled />
                                        <input type="number" name="otp3" disabled />
                                        <input type="number" name="otp4" disabled />
                                        <input type="number" name="otp5" disabled />
                                        <input type="number" name="otp6" disabled />
                                        <input type="hidden" name="nisn" value="{{$nisn}}">
                                    </div>
                        
                                    <button class="btn btn-primary mb-3" onclick="preLoad();" type="submit">
                                        Submit
                                    </button>
                                    <button class="btn btn-danger mb-3" id="resend" type="submit" disabled>
                                        <span id="countdown_token">Kirim Ulang Token</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <button onclick="preLoad();" type="submit" class="btn btn-primary btn-block">Submit</button> --}}
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
<script src="{{asset('js/datatables-customizer.js')}}"></script>
<script>
    $(document).ready(function() {
        document.addEventListener("keydown", function(event) {
            
            var keyCode = event.keyCode;
            switch (keyCode) {
            case 27:
                $('#61').removeClass('show').css('display', 'none')
                break;
            default:
               
                break;
            }
        });
    });
   
    @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){
            case 'info':
                Snackbar.show({
                    text: "{{ Session::get('message') }}",
                    actionTextColor: '#fff',
                    backgroundColor: '#2196f3'
                });
                break;

            case 'warning':
                Snackbar.show({
                    text: "{{ Session::get('message') }}",
                    pos: 'top-right',
                    actionTextColor: '#fff',
                    backgroundColor: '#e2a03f'
                });
                break;

            case 'success':
                Snackbar.show({
                    text: "{{ Session::get('message') }}",
                    pos: 'top-right',
                    actionTextColor: '#fff',
                    backgroundColor: '#8dbf42'
                });
                break;

            case 'danger':
                Snackbar.show({
                    text: "{{ Session::get('message') }}",
                    pos: 'top-right',
                    actionTextColor: '#fff',
                    backgroundColor: '#e7515a'
                });
                break;
            case 'popup':
                $('#generate_token').addClass('show').css('display', 'block'),
                $('#wrapper').css('filter', 'blur(8px)')
                let deadline = new Date();
                deadline.setMinutes(deadline.getMinutes() + 5);
                const deadlineTimestamp = deadline.getTime()/1000;

                let countdown = setInterval(function() {

                const now = Math.floor(Date.now() / 1000);
                const diff = deadlineTimestamp - now;

                if(diff <= 0) {
                    clearInterval(countdown);
                    document.getElementById('countdown_token').innerHTML = 'Kirim Ulang'; 
                    $('#resend').addClass('btn btn-primary submit-btn');
                    $('#resend').prop("disabled", false);
                    return;
                }

                const minutes = Math.floor(diff / 60);
                const seconds = Math.floor(diff % 60);

                document.getElementById('countdown_token').innerHTML =  
                    minutes + ' Menit ' + seconds + ' Detik';

                }, 1000);
            break;
        }
    @endif

    const inputs = document.querySelectorAll(".otp-field > input");
    const button = document.querySelector(".btn");

    window.addEventListener("load", () => inputs[0].focus());
    button.setAttribute("disabled", "disabled");

    inputs[0].addEventListener("paste", function (event) {
    event.preventDefault();

    const pastedValue = (event.clipboardData || window.clipboardData).getData(
        "text"
    );
    const otpLength = inputs.length;

    for (let i = 0; i < otpLength; i++) {
        if (i < pastedValue.length) {
        inputs[i].value = pastedValue[i];
        inputs[i].removeAttribute("disabled");
        inputs[i].focus;
        } else {
        inputs[i].value = ""; // Clear any remaining inputs
        inputs[i].focus;
        }
    }
    });

    inputs.forEach((input, index1) => {
    input.addEventListener("keyup", (e) => {
        const currentInput = input;
        const nextInput = input.nextElementSibling;
        const prevInput = input.previousElementSibling;

        if (currentInput.value.length > 1) {
        currentInput.value = "";
        return;
        }

        if (
        nextInput &&
        nextInput.hasAttribute("disabled") &&
        currentInput.value !== ""
        ) {
        nextInput.removeAttribute("disabled");
        nextInput.focus();
        }

        if (e.key === "Backspace") {
        inputs.forEach((input, index2) => {
            if (index1 <= index2 && prevInput) {
            input.setAttribute("disabled", true);
            input.value = "";
            prevInput.focus();
            }
        });
        }

        button.classList.remove("active");
        button.setAttribute("disabled", "disabled");

        const inputsNo = inputs.length;
        if (!inputs[inputsNo - 1].disabled && inputs[inputsNo - 1].value !== "") {
        button.classList.add("active");
        button.removeAttribute("disabled");

        return;
        }
    });
    });
</script>
<script src="{{asset('plugins/DataTables/datatables.min.js')}}"></script>
{{-- <script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script> --}}
</body>
</html>
