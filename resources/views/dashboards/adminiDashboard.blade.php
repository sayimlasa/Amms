@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Admin Dashboard</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted fw-medium">Total AC Assets</p>
                    <h4 class="text-success">{{ $acassets->count() }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted fw-medium">Total Working AC</p>
                    <h4 class="text-success">{{ $acassets->where('status','Working')->count() }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted fw-medium">Total Under Repair</p>
                    <h4 class="text-success">{{ $acassets->where('status','Under Repair')->count() }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted fw-medium">Total Scrapped</p>
                    <h4 class="text-success">{{ $acassets->where('status','scrapped')->count() }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted fw-medium">Total New AC</p>
                    <h4 class="text-success">{{ $acassets->where('condition','New')->count() }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted fw-medium">Total Old AC</p>
                    <h4 class="text-success">{{ $acassets->where('condition','Old')->count() }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted fw-medium">Total Mid-used AC</p>
                    <h4 class="text-success">{{ $acassets->where('condition','Mid-used')->count() }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row">
        <!-- Status Bar Chart -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">AC Assets by Status</h6>
                    <div id="statusBarChart" style="min-height: 300px;"></div>
                </div>
            </div>
        </div>

        <!-- Condition Bar Chart -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">AC Assets by Condition</h6>
                    <div id="conditionBarChart" style="min-height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    // Status Bar Chart
    const statusChartOptions = {
        chart: {
            type: 'bar',
            height: 300
        },
        series: [{
            name: 'Status Count',
            data: [
                {{ $acassets->where('status', 'Working')->count() }},
                {{ $acassets->where('status', 'Under Repair')->count() }},
                {{ $acassets->where('status', 'Scrapped')->count() }}
            ]
        }],
        xaxis: {
            categories: ['Working', 'Under Repair', 'Scrapped']
        },
        colors: ['#28a745', '#ffc107', '#dc3545'], // Green, Yellow, Red
        plotOptions: {
            bar: {
                distributed: true,
                borderRadius: 4,
                columnWidth: '55%'
            }
        },
        dataLabels: {
            enabled: true
        },
        title: {
            text: 'AC Status Overview',
            align: 'center'
        }
    };
    new ApexCharts(document.querySelector("#statusBarChart"), statusChartOptions).render();

    // Condition Bar Chart
    const conditionChartOptions = {
        chart: {
            type: 'bar',
            height: 300
        },
        series: [{
            name: 'Condition Count',
            data: [
                {{ $acassets->where('condition', 'New')->count() }},
                {{ $acassets->where('condition', 'Old')->count() }},
                {{ $acassets->where('condition', 'Mid-used')->count() }}
            ]
        }],
        xaxis: {
            categories: ['New', 'Old', 'Mid-used']
        },
        colors: ['#007bff', '#6c757d', '#6610f2'], // Blue, Gray, Purple
        plotOptions: {
            bar: {
                distributed: true,
                borderRadius: 4,
                columnWidth: '55%'
            }
        },
        dataLabels: {
            enabled: true
        },
        title: {
            text: 'AC Condition Overview',
            align: 'center'
        }
    };
    new ApexCharts(document.querySelector("#conditionBarChart"), conditionChartOptions).render();
</script>
@endsection
