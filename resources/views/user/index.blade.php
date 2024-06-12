@extends('layouts.coach')
@section('content')
                                   <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

<div class="row">
    @php
        $colors = ['success', 'info', 'primary', 'secondary', 'dark', 'danger', 'warning'];
        $colorIndex = 0;
    @endphp

    <div class="col-lg-12 mb-4">
        <a href="{{ route('class-page', ['sport_id' => $sports->id]) }}" style="text-decoration: none;">
            <div class="card bg-{{ $colors[$colorIndex % count($colors)] }} text-white shadow" title="Click here">
                <div class="card-body">
                    {{-- Check if $sports is an object and has a name property --}}
                    @if(isset($sports) && !empty($sports->name))
                        <h4>{{ $sports->name }}</h4>
                    @else
                        <h4>Unknown Sport</h4>
                    @endif
                    <div style="float:right;">
                        {{-- Check if $sports->customize is set and has a photo_path --}}
                        @if(isset($sports->customize) && isset($sports->customize->photo_path) && !empty($sports->customize->photo_path))
                            <img class="rounded-circle border-black" src="{{ asset($sports->customize->photo_path) }}" width="40" height="40">
                        @else
                            <img class="rounded-circle border-black" src="{{ asset('assets/img/CVSU-LOGO.png') }}" width="40" height="40">
                        @endif
                    </div>
                </div>
            </div>
        </a>
    </div>
    @php $colorIndex++; @endphp
</div>
                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                               Overall Task</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalMaterialCount }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                         Overall Checklist</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        {{-- Display the overall checklist count --}}
                        {{ $totalChecklists }}
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-list fa-2x text-gray-300"></i> {{-- Using a checklist icon --}}
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Rating Level Cards Example -->
@foreach($percentageByRating as $ratingLevel => $percentage)
    {{-- Skip rating level 0 --}}
    @if($ratingLevel != 0)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Rating Level {{ $ratingLevel }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{-- Display the percentage for the current rating level --}}
                                {{ number_format($percentage, 2) }}%
                            </div>
                        </div>
                        <div class="col-auto">
                            {{-- Replace this with the appropriate icon for the rating level --}}
                            @if($ratingLevel == 5)
                                <i class="fas fa-star fa-2x text-gray-300"></i>
                            @elseif($ratingLevel == 4)
                                <i class="fas fa-star-half-alt fa-2x text-gray-300"></i>
                            @elseif($ratingLevel == 3)
                                <i class="far fa-star fa-2x text-gray-300"></i>
                            @elseif($ratingLevel == 2)
                                <i class="far fa-star-half fa-2x text-gray-300"></i>
                            @elseif($ratingLevel == 1)
                                <i class="far fa-star fa-2x text-gray-300"></i>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Completion Rate</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        {{-- Display the overall percentage --}}
                        {{ number_format($overallPercentage, 2) }}%
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-user fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
  <!-- Task Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Completed Tasks</div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ number_format($percentageFilledChecklists, 2) }}</div>
                        </div>
                        <div class="col">
                            <div class="progress progress-sm mr-2">
                                <div class="progress-bar bg-info" role="progressbar"
                                    style="width: {{ $percentageFilledChecklists }}%" aria-valuenow="{{ $percentageFilledChecklists }}"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>


          

@endsection
@section('title','Dashboard')