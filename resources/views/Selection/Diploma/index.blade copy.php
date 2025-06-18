@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('diploma-selection.index') }}" method="GET">
                @csrf
                <div class="row g-3">
                    <input type="hidden" name="application_level_id" id="application_level_id" value="{{ $applicationLevels[0] }}">

                    <div class="col-md-3">
                        <label for="capacity" class="form-label">Capacity</label>
                        <input type="number" class="form-control" name="capacity" id="capacity">
                    </div>

                    <div class="col-md-3">
                        <label for="programme_id" class="form-label">Programme</label>
                        <select class="form-control select2" name="programme_id" id="programme_id" required>
                            <option selected disabled><-- Choose Programme --></option>
                            @foreach ($programmes as $programme)
                            <option value="{{ $programme->id }}">{{ $programme->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button type="submit" class="btn btn-info" id="runselection">Run Selection</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if ((isset($fornta4lists) && $fornta4lists->isNotEmpty()) || (isset($forsixlists) && $forsixlists->isNotEmpty()))
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Applicants Who Meet the Criteria </h6>
            <p id="selected-count" class="badge bg-success d-none"></p>
            <div>
                <button id="selectional" type="submit" class="btn btn-info d-none">Save Selected Applicants</button>
            </div>
        </div>

        <div class="card-body">
            <p id="select-message" class="text-danger d-none">Please make sure you check at least one applicant to save.</p>
            <div class="table-responsive">
                <table class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    @php $na = 1; @endphp
                    <thead>
                        <tr>
                            <th>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="select-all">
                                </div>
                            </th>
                            <th hidden>ID</th>
                            <th>No</th>
                            <th>Index Number</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Category</th>
                            <th>Course</th>
                            <th>More</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (($fornta4lists ?? collect())->merge($forsixlists ?? collect()) as $applicant)
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input applicant-checkbox" type="checkbox"
                                        value="{{ $applicant->id }}"
                                        data-programme-id="{{ $applicant->programme_id }}"
                                        data-education-level="{{ $applicant->education_level }}">
                                </div>
                            </td>
                            <td hidden>{{ $applicant->id }}</td>
                            <td>{{ $na++ }}</td>
                            <td>{{ $applicant->index_no }}</td>
                            <td>{{ $applicant->applicantUser->email }}</td>
                            <td>{{ $applicant->applicantUser->mobile_no }}</td>
                            <td>{{ isset($fornta4lists) && $fornta4lists->contains($applicant) ? 'NTA Level 4' : 'Form Six' }}</td>
                            <td> @php
                                $programme = $programmes->firstWhere('id', $applicant->programme_id);
                                @endphp
                                {{ $programme ? $programme->name : 'N/A' }}
                            </td>
                            <td>
                                <a class="dropdown-item view-item-btn" href="{{ route('detailed-applicant-info', ['applicant_user_id' => $applicant->applicant_user_id, 'index_no' => $applicant->index_no]) }}">
                                    <i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                    more
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- JavaScript Section --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const selectAllCheckbox = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.applicant-checkbox');
            const saveButton = document.getElementById('selectional');
            const message = document.getElementById('select-message');
            const selectedCount = document.getElementById('selected-count');

            function updateSelectionCount() {
                const checkedCount = document.querySelectorAll('.applicant-checkbox:checked').length;

                if (checkedCount > 0) {
                    saveButton.classList.remove('d-none');
                    message.classList.add('d-none');
                    selectedCount.textContent = `${checkedCount} Applicants Selected`;
                    selectedCount.classList.remove('d-none');
                } else {
                    saveButton.classList.add('d-none');
                    message.classList.remove('d-none');
                    selectedCount.classList.add('d-none');
                }
            }

            // Handle "Select All" checkbox
            selectAllCheckbox.addEventListener('change', function() {
                checkboxes.forEach(checkbox => checkbox.checked = this.checked);
                updateSelectionCount();
            });

            // Handle individual checkbox selection
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectionCount);
            });

            // Ensure the save button is hidden initially
            updateSelectionCount();

            // Save selected applicants
            saveButton.addEventListener('click', function(event) {
                event.preventDefault();

                let selectedApplicants = Array.from(document.querySelectorAll('.applicant-checkbox:checked')).map(checkbox => {
                    return {
                        applicant_id: checkbox.value,
                        programme_id: checkbox.getAttribute('data-programme-id'),
                        education_level:checkbox.getAttribute('data-education-level')
                    };
                });

                if (selectedApplicants.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Selection',
                        text: 'Please select at least one applicant.',
                        confirmButtonColor: '#3085d6'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You are about to save selected applicants.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, save them!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch("{{ route('diploma-selection.store') }}", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                },
                                body: JSON.stringify({
                                    applicants: selectedApplicants
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        text: 'Applicants saved successfully!',
                                        confirmButtonColor: '#3085d6'
                                    }).then(() => location.reload());
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: 'Failed to save applicants. Please try again.',
                                        confirmButtonColor: '#d33'
                                    });
                                }
                            })
                            .catch(error => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'An unexpected error occurred.',
                                    confirmButtonColor: '#d33'
                                });
                            });
                    }
                });
            });

        });
    </script>

@endif

</div>

<!-- JS Libraries -->
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.5/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.5/vfs_fonts.js"></script>

@endsection