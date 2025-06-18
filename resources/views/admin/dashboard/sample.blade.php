<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script>
    // Data for the pie chart
    const campuses = @json(campuses);
    const campusLabels = campuses.map(campus => campus.name);
    const campusApplicantsData = campuses.map(campus => campus.applicants_count);

    // Create Pie Chart using Chart.js
    const ctx = document.getElementById('applicantsPieChart').getContext('2d');
    const applicantsPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: campusLabels,
            datasets: [{
                label: 'Applicants by Campus',
                data: campusApplicantsData,
                backgroundColor: ['#FF5733', '#33FF57', '#3357FF', '#FF33A1', '#A1FF33'],
                borderColor: ['#FF5733', '#33FF57', '#3357FF', '#FF33A1', '#A1FF33'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                datalabels: {
                    formatter: function(value, ctx) {
                        const total = ctx.dataset._meta[Object.keys(ctx.dataset._meta)[0]].total;
                        const percentage = ((value / total) * 100).toFixed(2) + '%';
                        return percentage;
                    },
                    color: '#fff', // White color for the percentage text
                    font: {
                        weight: 'bold',
                        size: 14
                    }
                }
            }
        }
    });
</script>
@endsection
  <!-- Pie Chart: Applicants per Campus -->
  <div class="row">
                <div class="col-md-12">
                    <div class="card chart-card">
                        <div class="card-header">Applicants by Campus</div>
                        <div class="card-body">
                            <canvas id="applicantsPieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
