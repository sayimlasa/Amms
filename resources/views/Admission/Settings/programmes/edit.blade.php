@extends('layouts.admin')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

    </section>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h6 class=" mb-0 flex-grow-1">New Programme</h6>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <form method="POST" action="{{ route('programmes.update', $programme->id) }}">
                                    @csrf
                                    @method('PUT') <!-- Since we're updating, we need to specify the PUT method -->

                                    <div class="row g-4">
                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="iaa_code" class="form-label">IAA Code</label>
                                                <input type="text" class="form-control" id="iaa_code" name="iaa_code" placeholder="IA01"
                                                    value="{{ old('iaa_code', $programme->iaa_code) }}" oninput="capitalizeAllLetters(this)" required>
                                            </div>
                                        </div>

                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="tcu_code" class="form-label">TCU Code</label>
                                                <input type="text" class="form-control" id="tcu_code" name="tcu_code" placeholder="TC01"
                                                    value="{{ old('tcu_code', $programme->tcu_code) }}" oninput="capitalizeAllLetters(this)">
                                            </div>
                                        </div>

                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="nacte_code" class="form-label">NACTE Code</label>
                                                <input type="text" class="form-control" id="nacte_code" name="nacte_code" placeholder="NA01"
                                                    value="{{ old('nacte_code', $programme->nacte_code) }}" oninput="capitalizeAllLetters(this)">
                                            </div>
                                        </div>

                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Bachelor Of Computer Science"
                                                    value="{{ old('name', $programme->name) }}" oninput="capitalizeOnlyFirstLetter(this)" required>
                                            </div>
                                        </div>

                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="short" class="form-label">Short</label>
                                                <input type="text" class="form-control" id="short" name="short" placeholder="BCS"
                                                    value="{{ old('short', $programme->short) }}" oninput="capitalizeAllLetters(this)" required>
                                            </div>
                                        </div>

                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="campus_id" class="form-label">Campuses</label>
                                                <select class="form-control" name="campus_id[]" id="campus_id" multiple required>
                                                    @foreach ($campuses as $campus)
                                                    <option value="{{ $campus->id }}"
                                                        @if(in_array($campus->id, $programme->campuses->pluck('id')->toArray())) selected @endif>
                                                        {{ $campus->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="intake_id" class="form-label">Intakes</label>
                                                <select class="form-control" name="intake_id[]" id="intake_id" multiple required>
                                                    @foreach ($intakes as $intake)
                                                    <option value="{{ $intake->id }}"
                                                        @if(in_array($intake->id, $programme->intakes->pluck('id')->toArray())) selected @endif>
                                                        {{ $intake->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="application_level_id" class="form-label">Level</label>
                                                <select class="form-control select2" name="application_level_id" id="application_level_id" required>
                                                    @foreach ($levels as $level)
                                                    <option value="{{ $level->id }}"
                                                        @if($level->id == $programme->application_level_id) selected @endif>
                                                        {{ $level->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="computing" class="form-label">Is Computing?</label>
                                                <div class="form-check">
                                                    <input type="hidden" name="computing" value="0">
                                                    <input class="form-check-input" type="checkbox" id="computing" name="computing" value="1"
                                                        {{ old('computing', $programme->computing) == 1 ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="active" class="form-label">Is Active?</label>
                                                <div class="form-check">
                                                    <input type="hidden" name="active" value="0">
                                                    <input class="form-check-input" type="checkbox" id="active" name="active" value="1"
                                                        {{ old('active', $programme->active) == 1 ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-success">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!--end col-->
                            </div>
                            <!-- /.row -->
                        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@yield('script')
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<script>
    function capitalizeOnlyFirstLetter(input) {
        // Capitalize the first letter and make the rest lowercase
        input.value = input.value.charAt(0).toUpperCase() + input.value.slice(1).toLowerCase();
    }

    function capitalizeAllLetters(input) {
        // Convert the entire input value to uppercase
        input.value = input.value.toUpperCase();
    }
    document.addEventListener('DOMContentLoaded', function() {
        const intakeSelect = document.getElementById('intake_id');
        const campuSelect = document.getElementById('campus_id');

        new Choices(intakeSelect, {
            removeItemButton: true, // Allows deselecting an option with a close button
            searchEnabled: true,
        });
        new Choices(campuSelect, {
            removeItemButton: true, // Allows deselecting an option with a close button
            searchEnabled: true,
        });
    });
</script>
@endsection