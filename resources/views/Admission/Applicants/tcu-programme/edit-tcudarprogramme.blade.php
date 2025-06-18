@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h6 class="mb-0 flex-grow-1">Edit Dar Programme</h6>
                        </div>

                        <div class="card-body">
                            <div class="live-preview">
                                <form method="POST" action="{{ route('dar.tcu.update', $program->id) }}">
                                    @csrf
                                    <div class="row g-4">
                                        <!-- Program ID -->
                                        <div class="col-xxl-3 col-md-6">
                                            <label for="program_id" class="form-label">Tcu Code</label>
                                            <input type="text" class="form-control" id="program_id" name="tcu_code" value="{{ $program->tcu_code }}" readonly>
                                        </div>

                                        <!-- NACTEVET Programme Name -->
                                        <div class="col-xxl-3 col-md-6">
                                            <label for="program_name" class="form-label">Tcu Programme Name</label>
                                            <input type="text" class="form-control" id="program_name" name="program_name" value="{{ $program->tcu_name }}" readonly>
                                        </div>

                                        <!-- NTA Level Selection -->
                                        <div class="col-xxl-3 col-md-6">
                                            <label for="nta" class="form-label">NTA Level</label>
                                            <select class="form-control select2" name="nta" id="nta" required>
                                                <option value="">Select Ntal level</option>
                                                @foreach ($levels as $level)
                                                <option value="{{ $level->id }}" {{ $level->id == $program->nta ? 'selected' : '' }}>
                                                    {{ $level->nta_level }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Programme Selection -->
                                        <div class="col-xxl-3 col-md-6">
                                            <label for="program_selection" class="form-label">Arusha Programme</label>
                                            <select id="programmeSelect" name="arusha_program" class="form-control select2">
                                                <option value="">Select Programme</option>
                                                <!-- Options populated dynamically -->
                                            </select>
                                        </div>

                                        <!-- Arusha Program ID -->
                                        <div class="col-xxl-3 col-md-6">
                                            <label for="arusha_program_id" class="form-label">Arusha Program ID</label>
                                            <input type="text" class="form-control" id="arusha_program_id" name="arusha_program_id" value="{{ $program->arusha_program_id }}" readonly required>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="col-12 text-end">
                                            <button type="submit" class="btn btn-success">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ntaSelect = document.getElementById('nta');
        const programmeSelect = document.getElementById('programmeSelect');
        const arushaProgramIdInput = document.getElementById('arusha_program_id');

        ntaSelect.addEventListener('change', function() {
            const levelId = this.value;

            if (levelId) {
                fetch("{{ route('programmes-by-level', ':levelId') }}".replace(':levelId', levelId))
                    .then(response => response.json())
                    .then(data => {
                        // Clear previous programme options
                        programmeSelect.innerHTML = '<option value="">Select Programme</option>';

                        // Populate new options
                        data.forEach(program => {
                            const option = document.createElement('option');
                            option.value = program.id;
                            option.textContent = program.name;
                            programmeSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching programs:', error));
            } else {
                programmeSelect.innerHTML = '<option value="">Select Programme</option>';
            }
        });

        // Listen for programme selection change
        programmeSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const programId = selectedOption ? selectedOption.value : null;

            // If a valid programme is selected, update the Arusha Program ID field
            if (programId) {
                arushaProgramIdInput.value = programId;
            }
        });
    });
</script>

@endsection