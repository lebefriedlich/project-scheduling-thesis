<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/logo.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <title>
        {{ $title }} | {{ config('app.name') }}
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <!-- Forbidden -->
    {{-- <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script> --}}
    <!-- CSS Files Templates Argon Dashboard 3 -->
    <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css') }}?v=2.1.0" rel="stylesheet" />
    <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard-pro.css') }}" rel="stylesheet" />
    @vite([''])
</head>

<body class="g-sidenav-show   bg-gray-100">
    @if ($errors->any())
        <div class="position-fixed" style="top: 100px; right: 20px; z-index: 1050;">
            <div class="alert alert-danger alert-dismissible fade show auto-dismiss" role="alert">
                <h5 class="alert-heading">Terjadi Kesalahan!</h5>
                <p>Harap periksa kembali input Anda:</p>
                <ul class="mb-0 list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li class="d-flex align-items-center mb-2">
                            <span class="badge badge-danger mr-2">!</span>
                            <strong class="ms-1">{{ $error }}</strong>
                        </li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="position-fixed" style="top: 100px; right: 20px; z-index: 1050;">
            <div class="alert alert-danger alert-dismissible fade show auto-dismiss" role="alert">
                <strong>{{ session('error') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="position-fixed" style="top: 100px; right: 20px; z-index: 1050;">
            <div class="alert alert-success alert-dismissible fade show auto-dismiss" role="alert">
                <strong>{{ session('success') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <div class="position-absolute w-100 min-height-300 top-0"
        style="background-image: url('{{ asset('assets/img/kampus-uinma.png') }}'); background-position-y: 50%; background-size: 100% auto;">
        <span class="mask bg-primary opacity-6"></span>
    </div>
    <!-- Sidebar -->
    <x-layouts.user-sidebar></x-layouts.user-sidebar>
    <!-- Main Content -->
    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        <x-layouts.navbar>{{ $title }}</x-layouts.navbar>
        {{ $slot }}
    </main>
    <!-- Core JS Files Templates Argon Dashboard 3 -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('assets/js/argon-dashboard.min.js') }}?v=2.1.0"></script>
    <script src="{{ asset('assets/js/argon-dashboard-pro.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const alertElement = document.querySelector('.auto-dismiss');

            if (alertElement) {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(alertElement);

                setTimeout(() => {
                    bsAlert.close(); // ini akan trigger fade out & remove otomatis
                }, 5000);
            }
        });
    </script>
</body>

</html>
