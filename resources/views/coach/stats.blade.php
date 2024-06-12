@extends('layouts.coach')

@section('content')
 <div class="nav-classlink">
  <div class="nav" style="margin-top: 20px;">
    <ul class="nav nav-tabs" style="background-color: #f8f9fa; border-radius: 8px; padding: 10px;">
        <li class="nav-item">
            <a class="nav-link " aria-current="page"  href="{{-- route('class-page', ['id' => $checklist->material->sport->id]) --}}"style="color: #333; font-size: 16px;">Back to {{ $checklist->material->sport->name }} </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{ route('material.page', ['id' => $checklist->material->id]) }}"style="color: #333; font-size: 16px;">{{ $material->title }}</a>
        </li>
         <li class="nav-item">
            <a class="nav-link " aria-current="page"  href="{{ route('checklists.index', ['id' => $checklist->material->id]) }}" style="color: #333; font-size: 16px; ">{{ $checklist->title}} | Checklist</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page"  href="{{ route('checklists.index', ['id' => $checklist->material->id]) }}" style="color: #333; font-size: 16px; font-weight: bold;">{{ $checklist->title}} | Statistical Report</a>
        </li>

    </ul>
</div>
<br>
<h3 class="m-0 font-weight-bold text-primary">{{ $checklist->title }}</h3><br>
<!-- Script tag for Chart.js -->
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
@foreach($chartData as $columnName => $data)
    @if (is_string($data[0]['y']) && substr($data[0]['y'], 0, 1) === '[' && substr($data[0]['y'], -1) === ']')
        <div class="col-lg-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $columnName }}</h6>
                    <a href="#" class="btn btn-primary btn-sm" onclick="downloadChart('{{ 'myPieChart_' . $columnName }}', '{{ $columnName }}')">Download Chart</a>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="{{ 'myPieChart_' . $columnName }}" style="max-height: 300px;"></canvas> <!-- Set the maximum height here -->
                    </div>
                </div>
            </div>
        </div>
        <script>
            var ctx = document.getElementById('{{ 'myPieChart_' . $columnName }}').getContext('2d');
            var chartData = {!! json_encode($data) !!};
            var labels = [];
            var data = [];
            var userNames = []; // Array to store user names for tooltips

            chartData.forEach(item => {
                if (Array.isArray(item.y)) {
                    item.y.forEach(value => {
                        if (!labels.includes(value)) {
                            labels.push(value);
                            data.push(1);
                            userNames.push(item.label); // Add user name for tooltips
                        } else {
                            var index = labels.indexOf(value);
                            data[index]++;
                        }
                    });
                } else {
                    if (!labels.includes(item.y)) {
                        labels.push(item.y);
                        data.push(1);
                        userNames.push(item.label); // Add user name for tooltips
                    } else {
                        var index = labels.indexOf(item.y);
                        data[index]++;
                    }
                }
            });

            var myPieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: ['red', 'blue', 'green'] // Add your own colors
                    }]
                },
                options: {
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                var label = data.labels[tooltipItem.index] || '';
                                var value = data.datasets[0].data[tooltipItem.index];
                                var userName = userNames[tooltipItem.index];
                                return label + ': ' + value + ' (User: ' + userName + ')';
                            }
                        }
                    },
                    // Add your other desired options here
                }
            });

            // Function to download chart
            function downloadChart(chartId, chartName) {
                var canvas = document.getElementById(chartId);
                var link = document.createElement('a');
                link.href = canvas.toDataURL('image/png');
                link.download = chartName + '.png';
                link.click();
            }
        </script>
    @else
        <!-- Render a bar chart for numerical values -->
        <div class="col-lg-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $columnName }}</h6>
                    <a href="#" class="btn btn-primary btn-sm" onclick="downloadChart('{{ 'myBarChart_' . $columnName }}', '{{ $columnName }}')">Download Chart</a>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="{{ 'myBarChart_' . $columnName }}" style="max-height: 300px;"></canvas> <!-- Set the maximum height here -->
                    </div>
                </div>
            </div>
        </div>

        <script>
            var ctx = document.getElementById('{{ 'myBarChart_' . $columnName }}').getContext('2d');
            var chartData = {!! json_encode($data) !!};
            var labels = chartData.map(item => item.label);
            var data = chartData.map(item => item.y);

            var myBarChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '{{ $columnName }}',
                        data: data,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)'
                    }]
                },
                options: {
                    // Add your desired options here
                }
            });

            // Function to download chart
            function downloadChart(chartId, chartName) {
                var canvas = document.getElementById(chartId);
                var link = document.createElement('a');
                link.href = canvas.toDataURL('image/png');
                link.download = chartName + '.png';
                link.click();
            }
        </script>
    @endif
@endforeach


 <!-- Bar Chart 
<div class="col-lg-4 mb-4">
    <div class="card shadow">
        Card Header - Dropdown 
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{ $checklist->title }}</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                    aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Dropdown Header:</div>
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
        </div>
     Card Body
        <div class="card-body">
                <div class="chart-bar pt-4 pb-2" style="width: 100%;">
                    
                </div> -->

       


            
@endsection

@section('title', $checklist->title. ' Stats Report')
