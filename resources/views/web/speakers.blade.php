@extends('layouts.web')

@section('content')

<section style="margin-top: 30px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-xl-8">
                <div class="title-block">
                    Home / Speakers
                </div>
            </div>
        </div>
    </div>
</section>

@php
$members = App\Models\Member::with('speaker')
    ->join('speakers', 'members.speaker_id', '=', 'speakers.id')
    ->where('members.is_published', 1)
    ->orderBy('speakers.no') 
    ->get();
    
// Group members by speaker_id
$groupedMembers = $members->groupBy('speaker_id');

@endphp
@foreach ($groupedMembers as $speaker_id => $membersGroup)
<section class="section-instructors" style="padding-top:50px">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="section-heading mb-70 text-center">
                    @php
                    $type = $membersGroup->first()->speaker->type;
                    @endphp
                    <h3>{{ $type}}</h3>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            @foreach ($membersGroup as $member)
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="team-item mb-5">
                    <div class="team-img">
                        <img src="/storage/{{$member->photo}}" alt="" class="img-fluid">
                    </div>
                    <div class="team-content text-center" style="margin-left: 9px; width: 250px;">
                        <div class="team-info">
                            <h6>{{$member->name}}</h6>
                            <p style="text-transform:capitalize;">{{$member->title}} <br>
                            {{$member->organization}}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endforeach

@endsection