@extends('layouts.admin')

@section('content')
<div class="dashboard">
<header class="dashboard-header">
        <div class="container-fluid d-flex justify-content-between align-items-center py-6">
            <h1 class="dashboard-title">General Summary Report</h1>
        </div>
</header>
    <!-- Row 1: Stats Cards -->
    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-header">Total Campuses Available</div>
                <div class="card-body">
                    <h2 id="totalCampuses">{{ $totalCampuses }}</h2>
                    <a href="{{ route('campuses.index') }}" class="view-link">View campuses</a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-header">Total Programs Offered</div>
                <div class="card-body">
                    <h2 id="totalPrograms">{{ $totalPrograms }}</h2>
                    <a href="#" class="view-link">View programs</a>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-header">Study Level</div>
                <div class="card-body">
                    <h2 id="totalPrograms">{{ $totalPrograms }}</h2>
                    <a href="#" class="view-link">View study level</a>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-header">Main Campus(Arusha)</div>
                <div class="card-body">
                    <h2 id="totalPrograms">{{ $totalPrograms }}</h2>
                    <a href="#" class="view-link">View Total applicants</a>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-header">Dar Campus</div>
                <div class="card-body">
                    <h2 id="totalPrograms">{{ $totalPrograms }}</h2>
                    <a href="#" class="view-link">View Total applicants</a>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-header">Babati Campus</div>
                <div class="card-body">
                    <h2 id="totalPrograms">{{ $totalPrograms }}</h2>
                    <a href="#" class="view-link">View Total applicants</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-header">Dodoma Campus</div>
                <div class="card-body">
                    <h2 id="totalPrograms">{{ $totalPrograms }}</h2>
                    <a href="#" class="view-link">View Total applicants</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-header">Songea Campus</div>
                <div class="card-body">
                    <h2 id="totalPrograms">{{ $totalPrograms }}</h2>
                    <a href="#" class="view-link">View Total applicants</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-header">Polisi Campus</div>
                <div class="card-body">
                    <h2 id="totalPrograms">{{ $totalPrograms }}</h2>
                    <a href="#" class="view-link">View Total applicants</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-header">Magereza Campus</div>
                <div class="card-body">
                    <h2 id="totalPrograms">{{ $totalPrograms }}</h2>
                    <a href="#" class="view-link">View Total applicants</a>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-header">Total Applicants Applied Today</div>
                <div class="card-body">
                    <h2 id="totalApplicantsToday">{{ $totalApplicantsToday }}</h2>
                    <a href="#" class="view-link">View daily applicants</a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-header">Total Applicants</div>
                <div class="card-body">
                    <h2 id="totalApplicants">{{ $totalApplicants }}</h2>
                    <a href="#" class="view-link">View all applicants</a>
                </div>
            </div>
        </div>

        <!-- Row 2: Gender Distribution Card -->

        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-header">Total Male vs Female All Applicants</div>
                <div class="card-body">
                    <h2 id="genderDetails">Male: / Female: </h2>
                    <a href="#" class="view-link">See gender details</a>
                </div>
            </div>
          
        </div>
        @endsection

        @section('scripts')
        @parent