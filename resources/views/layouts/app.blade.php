<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'Page Title' }}</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/png" />
    <!-- GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet" />
    <!-- BOXICONS -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <!-- Plugin -->
    <link rel="stylesheet" href="{{ asset('libs/owl.carousel/assets/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />

    <!-- APP CSS -->
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/grid.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}" />
    @stack('styles')

    @livewireStyles
</head>

<body class="sidebar-expand">
    <div class="scale-wrapper">
        {{-- @if ($errors->any())
            <div class="position-fixed" style="top: 100px; right: 20px; z-index: 1050;">
                <div class="alert alert-danger alert-dismissible fade show auto-dismiss" role="alert">
                    <h5 class="alert-heading">Terjadi Kesalahan!</h5>
                    <p>Harap periksa kembali input Anda:</p>
                    <ul class="mb-0 list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-danger mr-2">!</span>
                                <strong>{{ $error }}</strong>
                            </li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        @endif --}}

        @if (session('error'))
            <div class="position-fixed" style="top: 100px; right: 20px; z-index: 1050;">
                <div class="alert alert-danger alert-dismissible fade show auto-dismiss" role="alert">
                    <strong>{{ session('error') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        @endif

        @if (session('success'))
            <div class="position-fixed" style="top: 100px; right: 20px; z-index: 1050;">
                <div class="alert alert-success alert-dismissible fade show auto-dismiss" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        @endif

        <!-- SIDEBAR -->
        <x-sidebar></x-sidebar>
        <!-- END SIDEBAR -->

        <!-- Main Header -->
        <div class="main-header">
            <div class="d-flex">
                <div class="mobile-toggle" id="mobile-toggle">
                    <i class="bx bx-menu"></i>
                </div>
                <div class="main-title">{{ $subTitle }}</div>
            </div>

            <div class="d-flex align-items-center">
                <div class="dropdown d-inline-block d-lg-none ms-2">
                    <button type="button" class="btn header-item noti-icon waves-effect"
                        id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="bx bx-search-alt"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-search-dropdown">
                        <form class="p-3">
                            <div class="form-group m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search ..."
                                        aria-label="Recipient's username" />
                                    <div class="input-group-append">
                                        <button class="btn btn-primary h-100" type="submit">
                                            <i class="bx bx-search-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="dropdown d-inline-block mt-12">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user" src="{{ asset('images/profile/profile.png') }}"
                            alt="Header Avatar" />
                        <span class="pulse-css"></span>
                        <span class="info d-xl-inline-block color-span">
                            <span class="d-block fs-20 font-w600">{{ Auth::user()->name }}</span>
                            <span class="d-block mt-7">{{ Auth::user()->email }}</span>
                        </span>

                        <i class="bx bx-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

                        <a class="dropdown-item text-danger" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Main Header -->

        <!-- MAIN CONTENT -->
        <div class="main">
            <div class="main-content project">
                {{ $slot }}
            </div>
        </div>
        <!-- END MAIN CONTENT -->

        <div class="overlay"></div>
    </div>

    @stack('modals')

    <!-- SCRIPT -->

    @livewireScripts
    <!-- APP JS -->
    <script src="{{ asset('js/main.js') }}"></script>
    {{-- <script src="{{ asset('js/shortcode.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    @stack('scripts')

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('pageLoading', {
                active: false
            })

            window.addEventListener('livewire:navigating-start', () => {
                Alpine.store('pageLoading').active = true
            })

            window.addEventListener('livewire:navigating-end', () => {
                Alpine.store('pageLoading').active = false
            })
        })

        document.addEventListener('DOMContentLoaded', () => {
            const alertElement = document.querySelector('.auto-dismiss');

            if (alertElement) {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(alertElement);

                setTimeout(() => {
                    bsAlert.close(); // ini akan trigger fade out & remove otomatis
                }, 5000);
            }
        });

        Livewire.on('flashMessage', (data) => {
            const message = data[0].message;
            const type = data[0].type;

            let alertClass = 'alert-info';

            if (type === 'success') {
                alertClass = 'alert-success';
            } else if (type === 'danger') {
                alertClass = 'alert-danger';
            } else if (type === 'warning') {
                alertClass = 'alert-warning';
            }

            // Div paling luar
            const outerWrapper = document.createElement('div');
            outerWrapper.classList.add('scale-wrapper');

            // Position fixed wrapper
            const fixedWrapper = document.createElement('div');
            fixedWrapper.classList.add('position-fixed');
            fixedWrapper.style.top = '100px';
            fixedWrapper.style.right = '20px';
            fixedWrapper.style.zIndex = '1050';
            fixedWrapper.style.maxWidth = '400px';
            fixedWrapper.style.width = 'auto';

            // Alert element
            const alertDiv = document.createElement('div');
            alertDiv.classList.add('alert', alertClass, 'alert-dismissible', 'fade', 'show', 'auto-dismiss');
            alertDiv.setAttribute('role', 'alert');
            alertDiv.innerHTML = `
        <strong>${message}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

            // Gabungkan semua
            fixedWrapper.appendChild(alertDiv);
            outerWrapper.appendChild(fixedWrapper);
            document.body.appendChild(outerWrapper);

            // Auto dismiss
            setTimeout(() => {
                outerWrapper.remove();
            }, 5000);
        });
    </script>
</body>

</html>
