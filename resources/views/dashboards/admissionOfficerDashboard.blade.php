<div class="container-fluid">
  <!-- Header -->
  <div class="row">
    <div class="col-12">
      <div class="page-title-box d-flex align-items-center justify-content-between">
        <h4 class="mb-0">Admission Officer Dashboard</h4>
        <div class="page-title-right">
          <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Summary Metrics -->
  <div class="row">
    <!-- Total Campuses -->
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <div class="d-flex">
            <div class="flex-grow-1">
              <p class="text-muted fw-medium">Total Campuses</p>
              <h4 class="text-success">{{$totalCampuses}}</h4>
            </div>
            <div class="avatar-sm">
              <span class="avatar-title bg-light text-success rounded-circle">
                <i class="bx bx-building-house"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <div class="d-flex">
            <div class="flex-grow-1">
              <p class="text-muted fw-medium">Total Programmes We Offer</p>
              <h4 class="text-success">{{$totalPrograms}}</h4>
            </div>
            <div class="avatar-sm">
              <span class="avatar-title bg-light text-success rounded-circle">
                <i class="bx bx-book-open"></i> <!-- Icon for Programmes -->
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Total Levels To Be Applied -->
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <div class="d-flex">
            <div class="flex-grow-1">
              <p class="text-muted fw-medium">Total Levels To Be Applied</p>
              <h4 class="text-success">{{$applicationLevels}}</h4>
            </div>
            <div class="avatar-sm">
              <span class="avatar-title bg-light text-success rounded-circle">
                <i class="bx bx-layer"></i> <!-- Icon for Levels -->
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Repeat for Courses, Application Levels, etc. -->
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">Applicants Today by Campus</h6>
          <div id="applicant-bar-chart"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">Total Applicants by Campus</h6>
          <div id="total-applicants-chart"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">Total Applicants by Gender</h6>
          <div id="genderChart"></div>
        </div> 
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">Total Applicants by Disability</h6>
          <div id="total-applicants-chart-disability"></div>
        </div>
      </div> 
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div id="distributed_treemap" data-colors='["--vz-primary", "--vz-secondary", "--vz-success", "--vz-info","--vz-warning", "--vz-danger"]' class="apex-charts" dir="ltr"></div>
        </div>
      </div>
    </div><!--end col-->
  </div>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <!-- Velzon JS -->

  <script src="{{url('assets/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{url('assets/js/app.min.js')}}"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var options = {
        chart: {
          type: 'bar',
          height: 350,
          toolbar: {
            show: true,
            tools: {
              download: true // Enable the download button (CSV, PNG, SVG)
            }
          }
        },
        series: [{
          name: 'Applicants Today',
          data: [
            @json($totalApplicantsToday),
            @json($totalArushaCampusToday),
            @json($totalDarCampusToday),
            @json($totalBabatiCampusToday),
            @json($totalDodomaCampusToday),
            @json($totalSongeaCampusToday),
            @json($totalPolisiCampusToday),
            @json($totalMagerezaCampusToday)
          ]
        }],
        xaxis: {
          categories: [
            'Total Applicants', 'Arusha', 'Dar', 'Babati', 'Dodoma', 'Songea', 'Polisi', 'Magereza'
          ]
        },
        colors: ['#A41E22', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796', '#6f42c1', '#fd7e14'],
        plotOptions: {
          bar: {
            borderRadius: 10,
            dataLabels: {
              position: 'top' // show data labels at the top of the bars
            }
          }
        },
        dataLabels: {
          enabled: true,
          formatter: function(val) {
            return val;
          }
        },
        title: {
          text: 'Applicants Today by Campus',
          align: 'center'
        }
      };

      var chart = new ApexCharts(document.querySelector("#applicant-bar-chart"), options);
      chart.render();
    });
  </script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var applicantCounts = [
        @json($totalApplicants),
        @json($totalArushaCampus),
        @json($totalDarCampus),
        @json($totalBabatiCampus),
        @json($totalDodomaCampus),
        @json($totalSongeaCampus),
        @json($totalPolisiCampus),
        @json($totalMagerezaCampus)
      ];

      var categories = [
        'Total Applicants', 'Arusha', 'Dar', 'Babati', 'Dodoma', 'Songea', 'Polisi', 'Magereza'
      ];

      var colors = ['#10497E', '#A41E22', '#10497E', '#A41E22', '#10497E', '#A41E22', '#10497E', '#A41E22'];

      var seriesData = applicantCounts.map((count, index) => ({
        x: categories[index],
        y: count,
        fillColor: colors[index] // Assign color explicitly
      }));

      var options = {
        chart: {
          type: 'bar',
          height: 350,
          toolbar: {
            show: true,
            tools: {
              download: true // Enable download button (CSV, PNG, SVG)
            }
          }
        },
        series: [{
          name: 'Total Applicants',
          data: seriesData
        }],
        xaxis: {
          categories: categories
        },
        plotOptions: {
          bar: {
            borderRadius: 10,
            dataLabels: {
              position: 'top' // Show data labels at the top of the bars
            }
          }
        },
        dataLabels: {
          enabled: true,
          formatter: function(val) {
            return val;
          }
        },
        title: {
          text: 'Total Applicants by Campus',
          align: 'center'
        }
      };

      var chart = new ApexCharts(document.querySelector("#total-applicants-chart"), options);
      chart.render();
    });
  </script>
  <!-- Chart container -->

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const genderData = @json($genderCounts).original; // Check if this prints correctly in the console

      // If genderData is as expected, then proceed to extract male and female counts:
      const labels = genderData.map(item => item.campus);
      const maleCounts = genderData.map(item => item.male);
      const femaleCounts = genderData.map(item => item.female);

      // Continue with ApexCharts options
      var options = {
        chart: {
          type: 'bar',
          height: 350,
          stacked: false,
          toolbar: {
            show: true,
            tools: {
              download: true, // This enables the download button for CSV, PNG, JPG
            }
          }
        },
        series: [{
            name: 'Male',
            data: maleCounts
          },
          {
            name: 'Female',
            data: femaleCounts
          }
        ],
        xaxis: {
          categories: labels, // Campus names as the x-axis categories
        },
        plotOptions: {
          bar: {
            borderRadius: 10,
            horizontal: false,

          },
        },
        title: {
          text: 'Gender Distribution per Campus',
          align: 'center',
        },
        colors: ['#10497E', '#A41E22'], // Blue for Male, Pink for Female
        dataLabels: {
          enabled: true
        },
        legend: {
          position: 'top',
          horizontalAlign: 'center',
        },
        tooltip: {
          y: {
            formatter: function(val) {
              return val + " Applicants";
            }
          }
        }
      };

      var chart = new ApexCharts(document.querySelector("#genderChart"), options);
      chart.render();
    });
  </script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var applicantData = @json($applicantData); // Convert Laravel data to JavaScript

      // Extract data array if needed
      if (applicantData.original) {
        applicantData = applicantData.original;
      }

      console.log("Processed Applicant Data:", applicantData); // Debugging

      if (!applicantData || applicantData.length === 0) {
        console.warn("No data available for the chart.");
        return;
      }

      // Define colors for each region (looping through available colors)
      var colors = ["#10497E", "#A41E22", "#1E5B9A", "#C3272C"];

      var options = {
        series: [{
          data: applicantData.map((region, index) => ({
            x: region.region || "Unknown",
            y: region.count || 0,
            fillColor: colors[index % colors.length] // Assign color cyclically
          }))
        }],
        chart: {
          type: 'treemap',
          height: 350,
          toolbar: {
            show: true,
            tools: {
              download: true,
            }
          }
        },
        title: {
          text: 'Applicant Statistics by Region'
        }
      };

      var chart = new ApexCharts(document.querySelector("#distributed_treemap"), options);
      chart.render();
    });
  </script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var applicantDisability = @json($applicantDisability).original;

      // Extract disability names and counts
      var categories = applicantDisability.map(item => item.disability);
      var counts = applicantDisability.map(item => parseInt(item.count));

      var options = {
        chart: {
          type: 'bar',
          height: 350,
          toolbar: {
            show: true,
            tools: {
              download: true
            }
          }
        },
        series: [{
          name: 'Applicants Count',
          data: counts
        }],
        xaxis: {
          categories: categories
        },
        plotOptions: {
          bar: {
            borderRadius: 10,
            dataLabels: {
              position: 'top'
            }
          }
        },
        dataLabels: {
          enabled: true,
          formatter: function(val) {
            return val;
          }
        },
        title: {
          text: 'Total Applicants by Disability',
          align: 'center'
        }
      };

      var chart = new ApexCharts(document.querySelector("#total-applicants-chart-disability"), options);
      chart.render();
    });
  </script>