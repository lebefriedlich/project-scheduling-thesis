<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="">
            <img src="{{ asset('images/logo.png') }}" width="26px" height="26px" class="navbar-brand-img h-100"
                alt="main_logo">
            <span class="ms-1 font-weight-bold">Penjadwalan Ujian</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            {{-- <li class="nav-item">
                    <a class="nav-link " href="/user/periode">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-calendar-grid-58 text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Periode</span>
                    </a>
                </li> --}}
            <li class="nav-item">
                <a class="nav-link " href="{{ route('user.sempro.index') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-collection text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Sempro</span>
                </a>
            </li>

            @php
                use App\Models\Sempro;
                use App\Models\Schedule;
                use Carbon\Carbon;

                $now = Carbon::now();

                $sempro = Sempro::where('user_id', Auth::user()->id)->first();
                // dd($sempro);
                $isActiveSemhas = false;

                if ($sempro) {
                    $schedule = Schedule::where('exam_type', Sempro::class)->where('exam_id', $sempro->id)->first();

                    if (isset($schedule) && $schedule->schedule_date <= $now) {
                        $isActiveSemhas = true;
                    } else {
                        $isActiveSemhas = false;
                    }
                } else {
                    $isActiveSemhas = false;
                }

                $isActiveSemhas = true;
            @endphp

            @if ($isActiveSemhas)
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('user.semhas.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-collection text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Semhas</span>
                    </a>
                </li>
            @endif

            @php
                use App\Models\Semhas;

                $now = Carbon::now();

                $semhas = Semhas::with('sempro')
                    ->whereHas('sempro', function ($query) {
                        $query->where('user_id', Auth::user()->id);
                    })
                    ->first();

                $isActiveSkripsi = false;

                if ($semhas) {
                    $schedule = Schedule::where('exam_type', Semhas::class)->where('exam_id', $semhas->id)->first();

                    if (isset($schedule) && $schedule->schedule_date <= $now) {
                        $isActiveSkripsi = true;
                    } else {
                        $isActiveSkripsi = false;
                    }
                } else {
                    $isActiveSkripsi = false;
                }
                
                $isActiveSkripsi = true;
            @endphp
            @if ($isActiveSkripsi)
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('user.skripsi.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-collection text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Skripsi</span>
                    </a>
                </li>
            @endif

            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-button-power text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</aside>
