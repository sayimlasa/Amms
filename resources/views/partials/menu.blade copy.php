
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Light Logo-->
        <a href="index.html" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{url('assets/images/iaawhitelogo.png')}}" alt="" height="30">
            </span>
            <span class="logo-lg">
                <img src="{{url('assets/images/iaalogoword.png')}}" alt="" height="50" class="menu-logo">
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
                    <a class="nav-link menu-link" href="#" role="button" aria-expanded="false">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#" role="button" aria-expanded="false">
                        <i class="ri-user-line"></i> <span data-key="t-dashboards">My Profile</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#mainSettings" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="mainSettings">
                        <i class="las la-cog"></i> <span data-key="t-apps">Main Settings</span>
                    </a>
                    <div class="collapse menu-dropdown" id="mainSettings">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('academic-years.index')}}" class="nav-link {{ request()->is("AcademicYears") || request()->is("AcademicYears/*") ? "active" : "" }}">
                                    Academic Years
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{route('countries.index')}}" class="nav-link {{ request()->is("Countries") || request()->is("Countries/*") ? "active" : "" }}">
                                    Countries
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('regions-states.index')}}" class="nav-link {{ request()->is("Districts") || request()->is("Districts/*") ? "active" : "" }}">
                                    Regions & States
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('districts.index')}}" class="nav-link {{ request()->is("Districts") || request()->is("Districts/*") ? "active" : "" }}">
                                    Dsitricts
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('nationalities.index')}}" class="nav-link {{ request()->is("Countries") || request()->is("Countries/*") ? "active" : "" }}">
                                    Nationalities
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('campuses.index')}}" class="nav-link {{ request()->is("Campuses") || request()->is("Campuses/*") ? "active" : "" }}">
                                    Campuses
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a href="{{route('intakes.index')}}" class="nav-link {{ request()->is("Intakes") || request()->is("Intakes/*") ? "active" : "" }}">
                                    Intakes
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('education-levels.index')}}" class="nav-link {{ request()->is("EducationLevels") || request()->is("EducationLevels/*") ? "active" : "" }}">
                                    Education Levels
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('application-levels.index')}}" class="nav-link {{ request()->is("ApplicationLevels") || request()->is("ApplicationLevels/*") ? "active" : "" }}">
                                    Application Levels
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('application-categories.index')}}" class="nav-link {{ request()->is("ApplicationCategories") || request()->is("ApplicationCategories/*") ? "active" : "" }}">
                                    Application Categories
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('application-windows.index')}}" class="nav-link {{ request()->is("ApplicationWindows") || request()->is("ApplicationWindows/*") ? "active" : "" }}">
                                    Application Windows
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('programmes.index')}}" class="nav-link {{ request()->is("Programmes") || request()->is("Programmes/*") ? "active" : "" }}">
                                    Programmes
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('disabilities.index')}}" class="nav-link {{ request()->is("disabilities") || request()->is("disabilities/*") ? "active" : "" }}">
                                    Disabilities
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('employers.index')}}" class="nav-link {{ request()->is("employers") || request()->is("employers/*") ? "active" : "" }}">
                                    Employers
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('employment-statuses.index')}}" class="nav-link {{ request()->is("employment-statuses") || request()->is("employment-statuses/*") ? "active" : "" }}">
                                    Employment Status
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('marital-statuses.index')}}" class="nav-link {{ request()->is("marital-statuses") || request()->is("marital-statuses/*") ? "active" : "" }}">
                                    Marital Status
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('relationships.index')}}" class="nav-link {{ request()->is("relationships") || request()->is("relationships/*") ? "active" : "" }}">
                                    Relationships
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('attachment-types.index')}}" class="nav-link {{ request()->is("attachment-types") || request()->is("attachment-types/*") ? "active" : "" }}">
                                    Attachement Types

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
                @can('applicants_user_access')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#applicants" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="applicants">
                    <i class="las la-user-check"></i> <span data-key="t-apps">Applicants</span>
                    </a>
                    <div class="collapse menu-dropdown" id="applicants">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#" class="nav-link {{ request()->is("site-settings") || request()->is("site-settings/*") ? "active" : "" }}">
                                    Applicant User
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{route('applicants-infos.index')}}" class="nav-link {{ request()->is("applicants-infos") || request()->is("applicants-infos/*") ? "active" : "" }}">
                                    Applicant Info
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('nextof-kins.index')}}" class="nav-link {{ request()->is("nextof_kins") || request()->is("nextof_kins/*") ? "active" : "" }}">
                                    Next Of Kins
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('applicants-academics.index')}}" class="nav-link {{ request()->is("applicants_academics") || request()->is("applicants_academics/*") ? "active" : "" }}">
                                    Academic Details
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('attachments.index')}}" class="nav-link {{ request()->is("attachments") || request()->is("attachments/*") ? "active" : "" }}">
                                    Applicant Attachement
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endcan
                @can('applicants_selection_access')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#applicantselect" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="applicants">
                    <i class="las la-user-check"></i> <span data-key="t-apps">Selection Student</span>
                    </a>
                    <div class="collapse menu-dropdown" id="applicantselect">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#" class="nav-link {{ request()->is("site-settings") || request()->is("site-settings/*") ? "active" : "" }}">
                                    Applicant User
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endcan
                @can('applicants_selection_access')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#applicantschoice" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="applicantschoice">
                    <i class="las la-user-check"></i> <span data-key="t-apps">Application Choice</span>
                    </a>
                    <div class="collapse menu-dropdown" id="applicantschoice">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                            <a href="{{ route('applicants-choice.index') }}" class="nav-link {{ request()->is("site-settings") || request()->is("site-settings/*") ? "active" : "" }}">
                            Main Campus
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endcan
                @can('applicants_user_control_access')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#applicantcontrol" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="applicants">
                    <i class="fas fa-dollar-sign"></i> <span data-key="t-apps">Applicants Payments</span>
                    </a>
                    <div class="collapse menu-dropdown" id="applicantcontrol">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('application-fee.index')}}" class="nav-link {{ request()->is("site-settings") || request()->is("site-settings/*") ? "active" : "" }}">
                                Applicant Control number
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endcan
                @can('main_setting_access')                    
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#nactevet" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="nactevet">
                        <i class="las la-cog"></i> <span data-key="t-apps">Nactevet</span>
                    </a>
                    <div class="collapse menu-dropdown" id="nactevet">
                        <ul class="nav nav-sm flex-column">
                            @can('academic_year_access')                                
                            <li class="nav-item">
                                <a href="{{route('academic-years.index')}}" class="nav-link {{ request()->is("AcademicYears") || request()->is("AcademicYears/*") ? "active" : "" }}">
                                    Tamisemi Student
                                </a>
                            </li>
                            @endcan
                            @can('application_categories_access')
                            <li class="nav-item">
                                <a href="{{route('application-categories.index')}}" class="nav-link {{ request()->is("ApplicationCategories") || request()->is("ApplicationCategories/*") ? "active" : "" }}">
                                    Upload List Of Selected For Verification
                                </a>
                            </li>
                            @endcan
                            @can('application_categories_access')
                            <li class="nav-item">
                                <a href="{{route('application-categories.index')}}" class="nav-link {{ request()->is("ApplicationCategories") || request()->is("ApplicationCategories/*") ? "active" : "" }}">
                                    Download Verified Applicats
                                </a>
                            </li>
                            @endcan
                            @can('application_categories_access')
                            <li class="nav-item">
                                <a href="{{route('application-categories.index')}}" class="nav-link {{ request()->is("ApplicationCategories") || request()->is("ApplicationCategories/*") ? "active" : "" }}">
                                    Get Feedback and Error Correction
                                </a>
                            </li>
                            @endcan
                            @can('application_categories_access')
                            <li class="nav-item">
                                <a href="{{route('application-categories.index')}}" class="nav-link {{ request()->is("ApplicationCategories") || request()->is("ApplicationCategories/*") ? "active" : "" }}">
                                Enroll students 
                                </a>
                            </li>
                            @endcan
                            @can('application_categories_access')
                            <li class="nav-item">
                                <a href="{{route('application-categories.index')}}" class="nav-link {{ request()->is("ApplicationCategories") || request()->is("ApplicationCategories/*") ? "active" : "" }}">
                                Download List Of Enrolled Student 
                                </a>
                            </li>
                            @endcan
                            @can('application_categories_access')
                            <li class="nav-item">
                                <a href="{{route('application-categories.index')}}" class="nav-link {{ request()->is("ApplicationCategories") || request()->is("ApplicationCategories/*") ? "active" : "" }}">
                                Update Biodata – Enrollement 
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcan
                @can('main_setting_access')                    
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#tcu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="tcu">
                        <i class="las la-cog"></i> <span data-key="t-apps">Tcu</span>
                    </a>
                    <div class="collapse menu-dropdown" id="tcu">
                        <ul class="nav nav-sm flex-column">
                            @can('academic_year_access')                                
                            <li class="nav-item">
                                <a href="{{route('academic-years.index')}}" class="nav-link {{ request()->is("AcademicYears") || request()->is("AcademicYears/*") ? "active" : "" }}">
                                    Check Applicat Status
                                </a>
                            </li>
                            @endcan
                           @can('countries_access')                               
                            <li class="nav-item">
                                <a href="{{route('countries.index')}}" class="nav-link {{ request()->is("Countries") || request()->is("Countries/*") ? "active" : "" }}">
                                    Add Applicants
                                </a>
                            </li>
                            @endcan
                            @can('region_access')                                
                            <li class="nav-item">
                                <a href="{{route('regions-states.index')}}" class="nav-link {{ request()->is("Districts") || request()->is("Districts/*") ? "active" : "" }}">
                                 Confrim Applicant Selection
                                </a>
                            </li>
                            @endcan
                            @can('district_access')
                            <li class="nav-item">
                                <a href="{{route('districts.index')}}" class="nav-link {{ request()->is("Districts") || request()->is("Districts/*") ? "active" : "" }}">
                                    Unconfirm Addmission
                                </a>
                            </li>
                            @endcan
                            @can('nation_access')
                            <li class="nav-item">
                                <a href="{{route('nationalities.index')}}" class="nav-link {{ request()->is("Countries") || request()->is("Countries/*") ? "active" : "" }}">
                                    Get Admitted Applicant
                                </a>
                            </li>  
                            @endcan
                            @can('campus_access')
                            <li class="nav-item">
                                <a href="{{route('campuses.index')}}" class="nav-link {{ request()->is("Campuses") || request()->is("Campuses/*") ? "active" : "" }}">
                                    Get Programmes with Admitted Candidates(Total)
                                </a>
                            </li>
                            @endcan 
                            @can('intake_access')
                            <li class="nav-item">
                                <a href="{{route('intakes.index')}}" class="nav-link {{ request()->is("Intakes") || request()->is("Intakes/*") ? "active" : "" }}">
                                    Get Applicants' Admmission Status
                                </a>
                            </li>
                            @endcan
                            @can('application_level_access')
                            <li class="nav-item">
                                <a href="{{route('application-levels.index')}}" class="nav-link {{ request()->is("ApplicationLevels") || request()->is("ApplicationLevels/*") ? "active" : "" }}">
                                     Get a List Confirmed Applicants
                                </a>
                            </li>  
                            @endcan
                            @can('application_categories_access')
                            <li class="nav-item">
                                <a href="{{route('application-categories.index')}}" class="nav-link {{ request()->is("ApplicationCategories") || request()->is("ApplicationCategories/*") ? "active" : "" }}">
                                    Cancel/Reject Admission
                                </a>
                            </li>
                            @endcan
                            @can('application_windows_access')
                            <li class="nav-item">
                                <a href="{{route('application-windows.index')}}" class="nav-link {{ request()->is("ApplicationWindows") || request()->is("ApplicationWindows/*") ? "active" : "" }}">
                                    Submit Internal Transfers
                                </a>
                            </li>  
                            @endcan
                            @can('program_access')
                            <li class="nav-item">
                                <a href="{{route('programmes.index')}}" class="nav-link {{ request()->is("Programmes") || request()->is("Programmes/*") ? "active" : "" }}">
                                  Get Applicants' Verification Status
                                </a>
                            </li>
                            @endcan
                            @can('program_access')
                            <li class="nav-item">
                                <a href="{{route('programmes.index')}}" class="nav-link {{ request()->is("Programmes") || request()->is("Programmes/*") ? "active" : "" }}">
                                  Submit Enrolled Student
                                </a>
                            </li>
                            @endcan
                            @can('program_access')
                            <li class="nav-item">
                                <a href="{{route('programmes.index')}}" class="nav-link {{ request()->is("Programmes") || request()->is("Programmes/*") ? "active" : "" }}">
                                  Submit Graduate 
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
                        <i class="lab la-whmcs"></i> <span data-key="t-apps"> System Settings</span>
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

