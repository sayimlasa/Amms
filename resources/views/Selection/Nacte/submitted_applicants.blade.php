@extends('layouts.admin')
@section('content')
<style>
    .header {
        top: 0;
    }

    .content {
        width: 100%;
        background-color: green;
        display: flex;
        position: relative;
        margin-bottom: 50px;
    }

    table {
        width: 100%;
        table-layout: fixed;
        word-wrap: break-word;
        margin-top: 10px;
    }

    table,
    th,
    td {
        border: 1px solid #000;
        border-collapse: collapse;
    }

    table tr td {
        padding-left: 6px;
    }

    table tr th {
        padding-left: 6px;
    }

    table.reportTable thead th {
        width: auto;
    }

    .table-head h4 {
        text-align: center;
        font-weight: 600;
    }

    table thead th:nth-child(1) {
        width: 3%;
    }

    table thead th:nth-child(8) {
        width: 8%;
    }

    .activestudent {
        margin: 30px;
    }

    .blue {
        width: 50%;
        height: 96px;
        background-color: #10497E;
    }

    .red {
        width: 50%;
        height: 96px;
        background-color: #A41E22;
    }

    .white {
        background-color: #fff;
        z-index: 2;
        position: absolute;
        left: 25px;
        right: 25px;
        top: 25px;
        display: flex;
        padding: 10px;
        justify-content: space-between;
        border-bottom: #10497E solid 1px;
    }

    .nation {
        display: flex;
        gap: 50px;
    }

    .white img {
        height: 60px;
    }

    .chevron-red {
        width: 20%;
        /* Width of the main body */
        height: 20px;
        /* Height of the arrow */
        background-color: #A41E22;
        clip-path: polygon(0% 0%,
                /* Top left corner */
                90% 0%,
                /* Top right indent start */
                100% 50%,
                /* Point of the arrow */
                90% 100%,
                /* Bottom right indent end */
                0% 100%,
                /* Bottom left corner */
                10% 50%
                /* Middle left */
            );
    }

    .chevron-blue {
        width: 20%;
        /* Width of the main body */
        height: 20px;
        /* Height of the rectangle */
        background: linear-gradient(to right, #10497E, #1E90FF);
        clip-path: polygon(0% 0%,
                /* Top left corner */
                100% 0%,
                /* Top right indent start */
                90% 50%,
                /* Tip of the arrow */
                100% 100%,
                /* Bottom right indent end */
                0% 100%
                /* Bottom left corner */
            );
        transform: rotate(180deg);
    }

    .pentagon {
        width: 60%;
        /* Adjust width */
        height: 20px;
        /* Adjust height */
        background: linear-gradient(to right, #1E90FF, #10497E);
        clip-path: polygon(0% 0%,
                /* Top left */
                calc(100% - 40px) 0%,
                /* Top right before the arrowhead (dynamic) */
                100% 50%,
                /* Tip of the arrowhead */
                calc(100% - 40px) 100%,
                /* Bottom right after the arrowhead (dynamic) */
                0% 100%
                /* Bottom left */
            );
    }

    .shapes {
        width: 100%;
        display: flex;
    }

    .iconinfo {
        display: flex;
        justify-content: space-between;
        margin-left: 40px;
        margin-right: 40px;
    }

    .icon {
        width: 30px;
        height: 30px;
        background-color: #A41E22;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 20%;
        margin-right: 10px;
    }

    .icon img {
        max-width: 80%;
        max-height: 80%;
    }

    .imagegroup {
        display: flex;
    }

    .info {
        font-size: 10px;
    }

    .footer-content {
        border-top: 1px solid #10497E;
        text-align: center;
    }

    .footer-content strong {
        font-size: 12px;
    }
</style>
<div class="row">
    <div class="card">
        <div class="col-md-3">
            <div>
                <a class="btn btn-info" href="{{route("submitted-applicants.submit")}}">Click here to submit new list</a>
            </div>
        </div>
        <div class="card-body">
            <form action="#">
                <div class="row g-3">
                <div class="col-md-3">
                        <label for="campus_id" class="form-label">Campus</label>
                        <select class="form-control select2" name="campus_id" id="campus_id" required>
                            <option selected disabled><-- Choose Campus --></option>
                            @foreach ($campuses as $campus)
                            <option value="{{ $campus->id }}">{{ $campus->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="application_level_id" class="form-label">Level</label>
                        <select class="form-control select2" name="application_level_id" id="application_level_id" required>
                            <option selected disabled><-- Choose Application Level --></option>

                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="programme_id" class="form-label">Programme</label>
                        <select class="form-control select2" name="programme_id" id="programme_id" required>
                            <option selected disabled><-- Choose Programme --></option>

                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="faculty" class="form-label">Date Submitted</label>
                        <select class="form-select faculty" name="faculty" id="faculty">
                            <option value="">All</option>
                            <option>Certificate</option>
                            <option value="">Diploma</option>
                            <option>Bachelor</option>
                            <option value="">Masters</option>
                        </select>
                        <small class="text-muted">optional</small>
                    </div> <!-- Repeat similar divs for Program, Session, Semester, Section, and Status -->
                </div>

                <div class="col-md-3">
                    <button type="button" class="btn btn-warning" id="filterBtn">Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="card" id="filteredTable" style="display:none">
        <div class="card-header" style="display:flex; justify-content:space-between">
            <div class="col-md-3">
                <button type="submit" class="btn btn-info" id="downloadReport"><i class="fas fa-print"></i> Get pdf</button>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-info" id="downloadExcelReport"><i class="ri-file-excel-2-line"></i> Get Excel</button>
            </div>
            <div class="col-md-3">
                <p class="btn btn-success"><strong>Total Students:</strong>&nbsp; 50</p>
            </div>
            <!-- Close Button -->
            <div class="ms-auto">
                <button type="button" class="btn btn-close" aria-label="Close" onclick="document.getElementById('filteredTable').style.display='none'"></button>
            </div>

        </div>
        <div class="card-body" id="cardBodyContent">
            <div class="header">
                <div class="content">
                    <div class="blue">

                    </div>
                    <div class="red">

                    </div>
                    <div class="white">
                        <div class="nation">
                            <div class="image">
                                <img src="{{url('assets/images/nation.png')}}" alt="logo">
                            </div>
                            <div class="title">
                                <p><strong>THE UNITED REPUBLIC OF TANZANIA <br> MINISTRY OF FINANCE</strong></p>
                            </div>
                        </div>
                        <div class="iaa">
                            <img src="{{url('assets/images/iaalogo.png')}}" alt="logo">
                        </div>
                    </div>
                </div>
            </div>
            <div class="activestudent">
                <div class="table-head">
                    <h4>LIST OF ACTIVE STUDENT</h4>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>NA</th>
                            <th>Campus</th>
                            <th>Level</th>
                            <th>Year of Study</th>
                            <th>Full Name</th>
                            <th>Registration Number</th>
                            <th>Programme</th>
                            <th>Gender</th>
                            <th>Disability</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Main Campus</td>
                            <td>Nta Level 08</td>
                            <td>1</td>
                            <td>John Doe</td>
                            <td>BSC-0034-2019</td>
                            <td>Computer Science</td>
                            <td>Male</td>
                            <td>None</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Dar Campus</td>
                            <td>Nta Level 08</td>
                            <td>1</td>
                            <td>Jane Doe</td>
                            <td>BIT-0034-2019</td>
                            <td>Information Technology</td>
                            <td>Female</td>
                            <td>None</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Babati Campus</td>
                            <td>Nta Level 08</td>
                            <td>1</td>
                            <td>John Smith</td>
                            <td>BSC-0034-2019</td>
                            <td>Computer Science</td>
                            <td>Male</td>
                            <td>None</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
            <div id="footerText" style="display:none;">ALL COMMUNICATION TO BE ADDRESSED TO THE RECTOR <br>
                Njiro Hill, P.O. Box 2798, Arusha, Tel: +255 27 2970232 Mob: +255 763 462109 Telex: 50009 IAA TZ
                Fax: +255 27 2970234 <br> Email:iaa@iaa.ac.tzWebsite:www.iaa.ac.tz
            </div>
        </div>
    </div>
</div>


<!-- Velzon JS -->
<script src="{{('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{('assets/libs/simplebar/simplebar.min.js')}}"></script>

<!-- jsPDF for PDF Export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<!-- PapaParse for CSV Export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>

<!-- jQuery and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.5/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.5/vfs_fonts.js"></script>

<!-- Custom JS -->
<!-- jQuery script to toggle visibility -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#filterBtn').on('click', function() {
        // Show the table when the filter button is clicked
        $('#filteredTable').show();
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
<script>
    document.getElementById('downloadReport').addEventListener('click', function() {
        var element = document.getElementById('cardBodyContent');

        var footerText = document.getElementById('footerText').innerText;

        // Optionally, ensure the element is visible
        element.style.display = 'block';
        element.style.visibility = 'visible';

        // Add a slight delay before rendering the PDF
        setTimeout(() => {
            html2pdf()
                .from(element)
                .set({
                    margin: [0, 0, 0, 0],
                    filename: 'report.pdf',
                    html2canvas: {
                        scale: 1
                    },
                    jsPDF: {
                        orientation: 'landscape',
                        unit: 'in',
                        format: 'letter',
                        putOnlyUsedFonts: true
                    },
                    // Add custom footer using the `pageAdded` event
                    pagebreak: {
                        mode: ['avoid-all', 'css', 'legacy']
                    }
                })
                .toPdf()
                .get('pdf')
                .then(function(pdf) {
                    // Add footer on each page
                    const pageCount = pdf.internal.getNumberOfPages();
                    for (let i = 1; i <= pageCount; i++) {
                        pdf.setPage(i);
                        pdf.setFontSize(8); // Font size for footer
                        pdf.setTextColor(164, 30, 34);
                        pdf.text(footerText, pdf.internal.pageSize.getWidth() / 2, pdf.internal.pageSize.getHeight() - 0.5, {
                            align: 'center'
                        });
                    }
                })
                .save(); // Save the PDF
        }, 100); // 100ms delay
    });
</script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>

<script>
    $(document).ready(function () {
        var table = $('#exampleTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="ri-file-excel-2-line"></i> Export to Excel',
                    className: 'btn btn-success',
                    title: 'Active Student List'
                },
                {
                    extend: 'csvHtml5',
                    text: '<i class="ri-file-text-line"></i> Export to CSV',
                    className: 'btn btn-primary',
                    title: 'Active Student List'
                }
            ]
        });

        // Attach export actions to buttons
        $('#exportExcel').click(function () {
            table.button('.buttons-excel').trigger();
        });

        $('#exportCSV').click(function () {
            table.button('.buttons-csv').trigger();
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
<script>
    document.getElementById('downloadExcelReport').addEventListener('click', function() {
        // Get the table
        var table = document.querySelector('table');
        var rows = Array.from(table.rows);
        
        // Extract data including the header
        var data = rows.map(function(row) {
            return Array.from(row.cells).map(function(cell) {
                return cell.innerText;
            });
        });
        
        // Create a new worksheet
        var ws = XLSX.utils.aoa_to_sheet(data);
        
        // Create a new workbook and add the worksheet to it
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Student Report");
        
        // Trigger the download
        XLSX.writeFile(wb, "students_report.xlsx");
    });
</script>
<script>
    $(document).ready(function() {
        // Fetch Application Levels when Campus is selected
        $('#campus_id').on('change', function() {
            var campus_id = $(this).val();
            if (campus_id) {
                $.ajax({
                    url: "{{ route('get-application-levels', '') }}/" + campus_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#application_level_id').empty().append('<option selected disabled><-- Choose Application Level --></option>');
                        $.each(data, function(key, value) {
                            $('#application_level_id').append('<option value="' + value.id + '|' + value.nta_level + '">' + value.nta_level + '</option>');
                        });
                    }
                });
            }
        });

        // Fetch Programmes when Application Level is selected
        $('#application_level_id').on('change', function() {
            var application_level_id = $(this).val();
            if (application_level_id) {
                $.ajax({
                    url: "{{ route('get-programmes', '') }}/" + application_level_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#programme_id').empty().append('<option selected disabled><-- Choose Programme --></option>');
                        $.each(data, function(key, value) {
                            $('#programme_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            }
        });
    });
</script>
@endsection