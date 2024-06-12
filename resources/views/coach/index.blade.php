@extends('layouts.coach')
@section('content')
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
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
                                                Handled Sport</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalSportsCount }}</div>
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
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Handled Athlete</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAthleteCount }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example 
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
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
                        </div>-->

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                               Posted Task</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalMaterialsCount }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

<!-- Content Row -->  
<div class="row">
    @php
        $colors = ['success', 'info', 'primary', 'secondary', 'dark', 'danger', 'warning'];
        $colorIndex = 0;
    @endphp

    @foreach($sports as $sport)
        @php
            $colClass = count($sports) == 1 ? 'col-lg-12' : 'col-lg-6'; // Set column class based on the number of sports
            $athleteCount = $athletePerSportCounts[$sport->id] ?? 0; // Get the athlete count for the current sport
            $materialCount = $materialPerSportCounts[$sport->id] ?? 0; // Get the material count for the current sport
        @endphp
        <div class="{{ $colClass }} mb-4">
            <a href="{{ route('class-page', ['sport_id' => $sport->id]) }}" style="text-decoration: none;">
                <div class="card bg-{{ $colors[$colorIndex % count($colors)] }} text-white shadow" title="Click here">
                    <div class="card-body">
                        <h4>{{ $sport->name }}</h4>
                        <i class="fa fa-user"></i> {{ $athleteCount }} Athletes <!-- Display the athlete count for the current sport --><br>
                        <i class="fas fa-file"></i> {{ $materialCount }}  Posted Task <!-- Display the material count for the current sport -->
                        <div style="float:right;">
                            @if($sport->customize && $sport->customize->photo_path)
                                <img class="rounded-circle border-black" src="{{ asset($sport->customize->photo_path) }}" width="40" height="40">
                            @else
                                <img class="rounded-circle border-black" src="{{ asset('assets/img/CVSU-LOGO.png') }}" width="40" height="40">
                            @endif
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @php $colorIndex++; @endphp
    @endforeach
</div>



@endsection
@section('title','Coach Dashboard')