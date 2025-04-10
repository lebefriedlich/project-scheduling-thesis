<div class="sidebar">
    <div class="sidebar-logo">
        <a wire:navigate href="" style="margin-top: 50px;">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Light" class="logo-light"
                style="width: 150px; height: 150px;" />
            <img src="{{ asset('images/logo-dark.png') }}" alt="Logo Dark" class="logo-dark"
                style="width: 150px; height: 150px; display: none;" />
        </a>
        <div class="sidebar-close" id="sidebar-close">
            <i class="bx bx-left-arrow-alt"></i>
        </div>
    </div>
    <!-- SIDEBAR MENU -->
    <div class="simlebar-sc" data-simplebar>
        <ul class="sidebar-menu tf">
            <li>
                <a wire:navigate href="{{ route('admin.periode.index') }}">
                    <i class="bx bxs-timer"></i>
                    <span>List Periode</span>
                </a>
            </li>
            <li>
                <a wire:navigate href="{{ route('admin.location.index') }}">
                    <i class="bx bx-current-location"></i>
                    <span>List Lokasi</span>
                </a>
            </li>
            <li>
                <a wire:navigate href="{{ route('admin.jadwal-mengajar-dosen.index') }}">
                    <i class="bx bxs-calendar-event"></i>
                    <span>Jadwal Mengajar</span>
                </a>
            </li>
            <li>
                <a wire:navigate href="{{ route('admin.lecturer.index') }}">
                    <i class="bx bxs-user-pin"></i>
                    <span>Data Dosen</span>
                </a>
            </li>
            {{-- <li>
                <a wire:navigate href="{{ route('course') }}">
                    <i class="bx bxs-book"></i>
                    <span>List Kursus</span>
                </a>
            </li>
            <li>
                <a wire:navigate href="{{ route('article') }}">
                    <i class="bx bxs-news"></i>
                    <span>Artikel</span>
                </a>
            </li>
            <li>
                <a wire:navigate href="{{ route('voucher.index') }}">
                    <i class="bx bxs-coupon"></i>
                    <span>Voucher</span>
                </a>
            </li> --}}
            {{-- <li class="sidebar-submenu">
                <a href="#" @click.prevent="open = !open" class="sidebar-menu-dropdown">
                    <i class="bx bxs-book"></i>
                    <span>Kurikulum</span>
                    <div class="dropdown-icon">
                        <i class="bx bx-chevron-down"></i>
                    </div>
                </a>
                <ul class="sidebar-menu sidebar-menu-dropdown-content">
                    <li>
                        <a wire:navigate href="{{ route('course') }}"> List Kursus </a>
                    </li>
                    <li>
                        <a href="project-details.html"> Bab </a>
                    </li>
                    <li>
                        <a href="new-project.html"> Sub Bab </a>
                    </li>
                </ul>
            </li> --}}
            <li>
                <a class="darkmode-toggle" id="darkmode-toggle" onclick="switchTheme()">
                    <div>
                        <i class="bx bx-cog mr-10"></i>
                        <span>darkmode</span>
                    </div>

                    <span class="darkmode-switch"></span>
                </a>
            </li>
        </ul>
    </div>

    <!-- END SIDEBAR MENU -->
</div>
