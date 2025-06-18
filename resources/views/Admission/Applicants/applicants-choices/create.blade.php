@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <!-- Content header -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h6 class="mb-0 flex-grow-1">Apply Programme</h6>
                        </div>
                        <div class="card-body">
                            <div class="live-preview">
                                <form method="POST" action="{{ route('applicants-choice.store') }}">
                                    @csrf
                                    <div class="row g-4">
                                        <!-- <div class="col-12">
                                            <label for="application_level_id" class="form-label">Choice One</label>
                                            <select class="form-control select2" name="application_level_id" id="application_level_id" required>
                                                <option value="" disabled selected>Choose a level...</option>
                                            </select>
                                        </div> -->
                                        <div class="col-12">
                                            <label for="application_level_id" class="form-label">Choice One</label>
                                            <select class="form-control select2" name="choice1" id="application_level" required>
                                            <option>Select first choice</option>
                                              @foreach ( $levels as $level)
                                                    <option value="{{$level->id}}">{{$level->name}}</option>
                                                    @endforeach
                                             </select>
                                        </div>
                                        <div class="col-12">
                                            <label for="application_level_id" class="form-label">Choice Two</label>
                                            <select class="form-control select2" name="choice2" id="application_level" required>
                                            <option>Select two choice</option>
                                              @foreach ( $levels as $level)
                                                    <option value="{{$level->id}}">{{$level->name}}</option>
                                                    @endforeach
                                             </select>
                                        </div>
                                        <div class="col-12">
                                            <label for="application_level_id" class="form-label">Choice Three</label>
                                            <select class="form-control select2" name="choice3" id="application_level" required>
                                            <option>Select third choice</option>
                                              @foreach ( $levels as $level)
                                                    <option value="{{$level->id}}">{{$level->name}}</option>
                                                    @endforeach
                                             </select>
                                        </div>
                                        <div class="col-12 text-end">
                                            <button type="submit" class="btn btn-success">Apply Now</button>
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
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script> -->
<script>
    $(document).ready(function() {
        $('#application_level_id').select2({
            placeholder: "Search for a level",
            allowClear: true,
            minimumInputLength: 5,
            ajax: {
                url: "route('programme.choice')",
                method: 'GET',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { search: params.term };
                },
                processResults: function (data) {
                    return {
                        results: data.results
                    };
                },
                cache: true
            }
        });
    });
</script>
@endsection

