<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Light Logo-->
        <a href="index.html" class="logo logo-light">

            <span class="logo-lg">
                <img src="{{ url('assets/images/jarufu.jpeg') }}" alt="" height="50" width="50"
                    class="menu-logo">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>
    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('home') }}" role="button" aria-expanded="false">
                        <i class="ri-user-line"></i> <span data-key="t-dashboards">Dashboard</span>
                    </a>
                </li>
                @can('user_management_accessr')
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarApps">
                            <i class="las la-users-cog"></i> <span data-key="t-apps">Users Management</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarApps">
                            <ul class="nav nav-sm flex-column">
                                @can('permission_access6')
                                    <li class="nav-item">
                                        <a href="{{ route('admin.permissions.index') }}"
                                            class="nav-link {{ request()->is('permissions') || request()->is('permissions/*') ? 'active' : '' }}">
                                            Permissions
                                        </a>
                                    </li>
                                @endcan
                                @can('role_access6')
                                    <li class="nav-item">
                                        <a href="{{ route('admin.roles.index') }}"
                                            class="nav-link {{ request()->is('roles') || request()->is('roles/*') ? 'active' : '' }}">
                                            Roles
                                        </a>
                                    </li>
                                @endcan
                                @can('user_access')
                                    <li class="nav-item">
                                        <a href="{{ route('admin.users.index') }}"
                                            class="nav-link {{ request()->is('roles') || request()->is('roles/*') ? 'active' : '' }}">
                                            Users
                                        </a>
                                    </li>
                                @endcan
                                @can('audit_log_access6')
                                    <li class="nav-item">
                                        <a href="#"
                                            class="nav-link {{ request()->is('Programmes') || request()->is('Programmes/*') ? 'active' : '' }}">
                                            Audit Logs
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#mainSettings" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="mainSettings">
                        <i class="las la-cog"></i> <span data-key="t-apps">Main Settings</span>
                    </a>
                    <div class="collapse menu-dropdown" id="mainSettings">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('locations.index') }}"
                                    class="nav-link {{ request()->is('AcademicYears') || request()->is('AcademicYears/*') ? 'active' : '' }}">
                                    Location
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('suppliers.index') }}"
                                    class="nav-link {{ request()->is('Countries') || request()->is('Countries/*') ? 'active' : '' }}">
                                    Supplier
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('brands.index') }}"
                                    class="nav-link {{ request()->is('Districts') || request()->is('Districts/*') ? 'active' : '' }}">
                                    Brands
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#reportac" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="reportac">
                        <i class="lab la-whmcs"></i> <span data-key="t-apps">Ac Asset Unit</span>
                    </a>
                    <div class="collapse menu-dropdown" id="reportac">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('ac-assets.index') }}"
                                    class="nav-link {{ request()->is('site-settings') || request()->is('site-settings/*') ? 'active' : '' }}">
                                    Manage Asset Unit
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('attachments.index') }}"
                                    class="nav-link {{ request()->is('site-settings') || request()->is('site-settings/*') ? 'active' : '' }}">
                                    Asset Attachment
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#reportam" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="reportam">
                        <i class="lab la-whmcs"></i> <span data-key="t-apps">Ac Movement</span>
                    </a>
                    <div class="collapse menu-dropdown" id="reportam">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('ac-movements.index') }}"
                                    class="nav-link {{ request()->is('site-settings') || request()->is('site-settings/*') ? 'active' : '' }}">
                                    Manage AC movement
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#reportase" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="reporTase">
                        <i class="lab la-whmcs"></i> <span data-key="t-apps">Report</span>
                    </a>
                    <div class="collapse menu-dropdown" id="reportase">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('track.history') }}"
                                    class="nav-link {{ request()->is('site-settings') || request()->is('site-settings/*') ? 'active' : '' }}">
                                    Track history Ac
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                 <!-- Logout -->
                <li class="nav-item">
                    <a href="#" class="nav-link menu-link"
                       onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        <i class="ri-logout-box-line"></i> <span>Logout</span>
                    </a>
                    <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
             
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <script>
        // Suppose dynamicId is determined dynamically in JavaScript
        const dynamicId = 'Email'; // Replace this with a dynamic value as needed
        document.getElementById('sidebarPlaceholder').id = 'sidebar' + dynamicId;
    </script>
</div>
