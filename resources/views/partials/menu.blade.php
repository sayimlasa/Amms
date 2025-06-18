<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Light Logo-->
        <a href="index.html" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{url('assets/images/iaawhitelogo1.png')}}" alt="" height="30">
            </span>
            <span class="logo-lg">
                <img src="{{url('assets/images/iaalogoword1.png')}}" alt="" height="50" class="menu-logo">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu"></span></li>
                <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarDashboards">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="{{route('main.index')}}" class="nav-link" data-key="t-analytics"> Main Report </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('arusha.campus')}}" class="nav-link" data-key="t-crm"> Arusha Campus </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('dar.campus')}}" class="nav-link" data-key="t-ecommerce"> Dar Campus </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('babati.campus')}}" class="nav-link" data-key="t-crypto"> Babati Campus </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('dodoma.campus')}}" class="nav-link" data-key="t-projects"> Dodoma Campus </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('songea.campus')}}" class="nav-link" data-key="t-nft"> Songea Campus</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('polisi.campus')}}" class="nav-link" data-key="t-job">Polisi Cmapus</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('magereza.campus')}}" class="nav-link" data-key="t-job">Magereza Campus</a>
                                    </li>
                                </ul>
                            </div>
                        </li> <!-- end Dashboard Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#" role="button" aria-expanded="false">
                        <i class="ri-user-line"></i> <span data-key="t-dashboards">My Profile</span>
                    </a>
                </li>
                @can('user_management_access')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="las la-users-cog"></i> <span data-key="t-apps">Users Management</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApps">
                        <ul class="nav nav-sm flex-column">
                        @can('permission_access')
                            <li class="nav-item">
                                <a href="{{route('admin.permissions.index')}}" class="nav-link {{ request()->is("permissions") || request()->is("permissions/*") ? "active" : "" }}">
                                    Permissions
                                </a>
                            </li>
                            @endcan
                            @can('role_access')
                            <li class="nav-item">
                                <a href="{{route('admin.roles.index')}}" class="nav-link {{ request()->is("roles") || request()->is("roles/*") ? "active" : "" }}">
                                    Roles
                                </a>
                            </li>
                            @endcan
                            @can('user_access')
                            <li class="nav-item">
                                <a href="{{route('admin.users.index')}}" class="nav-link {{ request()->is("roles") || request()->is("roles/*") ? "active" : "" }}">
                                    Users
                                </a>
                            </li>
                            @endcan
                            @can('audit_log_access')
                            <li class="nav-item">
                                <a href="#" class="nav-link {{ request()->is("Programmes") || request()->is("Programmes/*") ? "active" : "" }}">
                                    Audit Logs
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcan
                @can('main_setting_access')                    
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#mainSettings" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="mainSettings">
                        <i class="las la-cog"></i> <span data-key="t-apps">Main Settings</span>
                    </a>
                    <div class="collapse menu-dropdown" id="mainSettings">
                        <ul class="nav nav-sm flex-column">
                            @can('academic_year_access')                                
                            <li class="nav-item">
                                <a href="{{route('academic-years.index')}}" class="nav-link {{ request()->is("AcademicYears") || request()->is("AcademicYears/*") ? "active" : "" }}">
                                    Academic Years
                                </a>
                            </li>
                            @endcan
                           @can('countries_access')                               
                            <li class="nav-item">
                                <a href="{{route('countries.index')}}" class="nav-link {{ request()->is("Countries") || request()->is("Countries/*") ? "active" : "" }}">
                                    Countries
                                </a>
                            </li>
                            @endcan
                            @can('region_access')                                
                            <li class="nav-item">
                                <a href="{{route('regions-states.index')}}" class="nav-link {{ request()->is("Districts") || request()->is("Districts/*") ? "active" : "" }}">
                                    Regions & States
                                </a>
                            </li>
                            @endcan
                            @can('district_access')
                            <li class="nav-item">
                                <a href="{{route('districts.index')}}" class="nav-link {{ request()->is("Districts") || request()->is("Districts/*") ? "active" : "" }}">
                                    Districts
                                </a>
                            </li>
                            @endcan
                            @can('nation_access')
                            <li class="nav-item">
                                <a href="{{route('nationalities.index')}}" class="nav-link {{ request()->is("Countries") || request()->is("Countries/*") ? "active" : "" }}">
                                    Nationalities
                                </a>
                            </li>  
                            @endcan
                            @can('campus_access')
                            <li class="nav-item">
                                <a href="{{route('campuses.index')}}" class="nav-link {{ request()->is("Campuses") || request()->is("Campuses/*") ? "active" : "" }}">
                                    Campuses
                                </a>
                            </li>
                            @endcan 
                            @can('intake_access')
                            <li class="nav-item">
                                <a href="{{route('intakes.index')}}" class="nav-link {{ request()->is("Intakes") || request()->is("Intakes/*") ? "active" : "" }}">
                                    Intakes
                                </a>
                            </li>
                            @endcan
                            @can('application_level_access')
                            <li class="nav-item">
                                <a href="{{route('application-levels.index')}}" class="nav-link {{ request()->is("ApplicationLevels") || request()->is("ApplicationLevels/*") ? "active" : "" }}">
                                    Application Levels
                                </a>
                            </li>  
                            @endcan
                            @can('application_categories_access')
                            <li class="nav-item">
                                <a href="{{route('application-categories.index')}}" class="nav-link {{ request()->is("ApplicationCategories") || request()->is("ApplicationCategories/*") ? "active" : "" }}">
                                    Application Categories
                                </a>
                            </li>
                            @endcan
                            @can('application_windows_access')
                            <li class="nav-item">
                                <a href="{{route('application-windows.index')}}" class="nav-link {{ request()->is("ApplicationWindows") || request()->is("ApplicationWindows/*") ? "active" : "" }}">
                                    Application Windows
                                </a>
                            </li>  
                            @endcan
                            @can('program_access')
                            <li class="nav-item">
                                <a href="{{route('programmes.index')}}" class="nav-link {{ request()->is("Programmes") || request()->is("Programmes/*") ? "active" : "" }}">
                                    Programmes
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcan           
                @can('site_setting_access')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#report" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="report">
                        <i class="lab la-whmcs"></i> <span data-key="t-apps">Ac Asset Unit</span>
                    </a>
                    <div class="collapse menu-dropdown" id="report">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="" class="nav-link {{ request()->is('site-settings') || request()->is("site-settings/*") ? "active" : "" }}">

                                    Site setting

                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link {{ request()->is('site-settings') || request()->is("site-settings/*") ? "active" : "" }}">

                                SMS Gateways
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link {{ request()->is('site-settings') || request()->is("site-settings/*") ? "active" : "" }}">

                                Payment Gateways

                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link {{ request()->is('site-settings') || request()->is("site-settings/*") ? "active" : "" }}">

                                Mail settings
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link {{ request()->is("attachments") || request()->is("attachments/*") ? "active" : "" }}">
                                    Applicant Attachement
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endcan
                  @can('site_setting_access')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#report" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="report">
                        <i class="lab la-whmcs"></i> <span data-key="t-apps">Inventory Management </span>
                    </a>
                    <div class="collapse menu-dropdown" id="report">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="" class="nav-link {{ request()->is('site-settings') || request()->is("site-settings/*") ? "active" : "" }}">

                                    Site setting

                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link {{ request()->is('site-settings') || request()->is("site-settings/*") ? "active" : "" }}">

                                SMS Gateways
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link {{ request()->is('site-settings') || request()->is("site-settings/*") ? "active" : "" }}">

                                Payment Gateways

                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link {{ request()->is('site-settings') || request()->is("site-settings/*") ? "active" : "" }}">

                                Mail settings
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link {{ request()->is("attachments") || request()->is("attachments/*") ? "active" : "" }}">
                                    Applicant Attachement
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endcan
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
