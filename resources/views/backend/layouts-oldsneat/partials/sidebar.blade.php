<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="#" class="app-brand-link">
            {{-- <span class="app-brand-logo demo">
        
      </span> --}}
            <img src="{{ asset('assets/img/auth/penghargaan-main-logo.jpg') }}" style="max-width: 80%">
            {{-- <span class=" demo fw-bold ms-2">Simply Management</span> --}}
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    @php
        $usr = Auth::guard('admin')->user();
    @endphp

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-store"></i>
                <div class="text-truncate" data-i18n="Client">Client</div>
            </a>
        </li>

        @if ($usr->can('dashboard.view') || $usr->can('monitoring.view'))
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link ">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Dashboards">Dashboard</div>
                </a>
            </li>
        @endif

        <li class="menu-item">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-desktop"></i>
                <div class="text-truncate" data-i18n="Monitoring">Monitoring</div>
            </a>
        </li>

        @if ($usr->can('calendar.view'))
        <li class="menu-item">
            <a href="{{ route('event') }}" class="menu-link ">
                <i class='menu-icon tf-icons bx bx-calendar'></i>
                <div class="text-truncate">Event</div>
            </a>
        </li>
        @endif

        @if ($usr->can('customer.view'))
        <li class="menu-item ">
            <a href="{{ route('customer') }}" class="menu-link ">
                <i class='menu-icon tf-icons bx bx-group'></i>
                <div class="text-truncate">Customer</div>
            </a>
        </li>
        @endif
        @if ($usr->can('quotation.view'))
        <li class="menu-item ">
            <a href="{{ route('quotation') }}" class="menu-link ">
                <i class="menu-icon tf-icons bx bx-task"></i>
                <div class="text-truncate">Quotation</div>
            </a>
        </li>
        @endif
        @if ($usr->can('purchase.order.view'))
        <li class="menu-item ">
            <a href="{{ route('purchase-order') }}" class="menu-link ">
                <i class="menu-icon tf-icons bx bx-cart-add"></i>
                <div class="text-truncate">Purchase Order</div>
            </a>
        </li>
        @endif
        @if ($usr->can('project.view'))
        <li class="menu-item">
            <a href="{{ route('project') }}" class="menu-link ">
                <i class="menu-icon tf-icons bx bx-chalkboard"></i>
                <div class="text-truncate">Project</div>
            </a>
        </li>
        @endif
        @if ($usr->can('invoice.view'))
        <li class="menu-item">
            <a href="#" class="menu-link ">
                <i class="menu-icon tf-icons bx bx-receipt"></i>
                <div class="text-truncate">Invoice</div>
            </a>
        </li>
        @endif
        @if ($usr->can('admin.view'))
        <li class="menu-item">
            <a href="{{ route('admin.admins.index') }}" class="menu-link ">
                <i class='menu-icon tf-icons bx bx-user'></i>
                <div class="text-truncate">Team</div>
            </a>
        </li>
        @endif
      
        @if ($usr->can('absensi.view'))
        <li class="menu-item">
            <a href="#" class="menu-link ">
              <i class='menu-icon tf-icons bx bx-time-five'></i>
                <div class="text-truncate">Attendance</div>
            </a>
        </li>
        @endif
        @if ($usr->can('tugas.keluar.view'))
        <li class="menu-item">
            <a href="#" class="menu-link ">
                <i class='menu-icon tf-icons bx bx-briefcase' ></i>
                <div class="text-truncate">Assignment</div>
            </a>
        </li>
        @endif
        @if ($usr->can('invoice.view'))
        <li class="menu-item">
            <a href="#" class="menu-link ">
                <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
                <div class="text-truncate">Activity Task</div>
            </a>
        </li>
        @endif

        <li class="menu-item">
            <a href="" class="menu-link">
                <i class="menu-icon tf-icons bx bx-support"></i>
                <div class="text-truncate" data-i18n="Support">Support</div>
            </a>
        </li>


        @if ($usr->can('role.view') || $usr->can('services.view') || $usr->can('divisi.view'))
            <!-- Layouts -->
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-cog"></i>
                    <div data-i18n="Layouts">Master Data</div>
                </a>

                <ul class="menu-sub">

                    @if ($usr->can('role.view'))
                        <li class="menu-item">
                            <a href="{{ route('admin.roles.index') }}" class="menu-link">
                                <div data-i18n="Fluid">Role & Permissions</div>
                            </a>
                        </li>
                    @endif
                    @if ($usr->can('services.view'))
                        <li class="menu-item">
                            <a href="{{ route('services') }}" class="menu-link">
                                <div data-i18n="Fluid">Services</div>
                            </a>
                        </li>
                    @endif

                    @if ($usr->can('divisi.view'))
                        <li class="menu-item">
                            <a href="{{ route('divisi') }}" class="menu-link">
                                <div data-i18n="Container">Divisi</div>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
     

    </ul>
</aside>
