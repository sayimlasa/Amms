@extends('layouts.admin')
@section('content')
<div class="dashboard">
<header class="dashboard-header">
        <div class="container-fluid d-flex justify-content-between align-items-center py-6">
            <h1 class="dashboard-title">Dar Summary Report</h1>
        </div>
</header>
    <!-- Row 1: Stats Cards -->
    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-header">Total Programs Offered</div>
                <div class="card-body">
                    <h2 id="totalPrograms"></h2>
                    <a href="#" class="view-link">View programs</a>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-header">Total Applicants Applied Today</div>
                <div class="card-body">
                    <h2 id="totalApplicantsToday"> </h2>
                    <a href="#" class="view-link">View daily applicants</a>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-header">Total Applicants</div>
                <div class="card-body">
                    <h2 id="totalApplicants"></h2>
                    <a href="#" class="view-link">View all applicants</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-header">Total Certificate Applicants Applied Today</div>
                <div class="card-body">
                    <h2 id="totalApplicants"></h2>
                    <a href="#" class="view-link">View all applicants</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-header">Total Certificate</div>
                <div class="card-body">
                    <h2 id="totalApplicants"></h2>
                    <a href="#" class="view-link">View all applicants</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-header">Total Diploma Applicants Applied Today</div>
                <div class="card-body">
                    <h2 id="totalApplicants"></h2>
                    <a href="#" class="view-link">View all applicants</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-header">Total Diploma</div>
                <div class="card-body">
                    <h2 id="totalApplicants"></h2>
                    <a href="#" class="view-link">View all applicants</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-header">Total Bachelor Applicants Applied Today</div>
                <div class="card-body">
                    <h2 id="totalApplicants"></h2>
                    <a href="#" class="view-link">View all applicants</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-header">Total Bachelor</div>
                <div class="card-body">
                    <h2 id="totalApplicants"></h2>
                    <a href="#" class="view-link">View all applicants</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-header">Total Master Applicants Applied Today</div>
                <div class="card-body">
                    <h2 id="totalApplicants"></h2>
                    <a href="#" class="view-link">View all applicants</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-header">Total Master</div>
                <div class="card-body">
                    <h2 id="totalApplicants"></h2>
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