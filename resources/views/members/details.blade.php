@extends('layouts.master')

@section('title', 'Medlemsdetaljer')

@section('description', '')

@section('header')
@endsection

@section('content')

@include('errors.errors')
<div class="row">
    <div class="col-md-6">

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Medlemmer</h3>
            </div>
            <div class="box-body">
                <dl class="dl-horizontal">
                    <dt>Årsmedlem</dt>
                    <dd>{{ $numberOfMembers - $halfYear }}</dd>
                    <dt>Halvårsmedlem</dt>
                    <dd>{{ $halfYear }}</dd>
                    <dt>&nbsp;</dt>
                    <dd><hr></dd>
                    <dt>U20 kontrakter</dt>
                    <dd>{{ $u20Contract }}</dd>
                    <dt>&nbsp;</dt>
                    <dd><hr></dd>
                    <dt>Utestengte</dt>
                    <dd><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#bannedModal">
                            Vis info
                        </button>
                    </dd>
                </dl>
                    <div class="modal modal-warning fade" id="bannedModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Utestengte medlemmer</h4>
                                </div>
                                <div class="modal-body">
                                    <dl class="dl-horizontal">
                                        @foreach($banned as $bannedMember)
                                        <dt>{{ $bannedMember->name }}</dt>
                                        <dd>Utestengt til {{ Carbon\Carbon::parse($bannedMember->banned_to)->format('d.m.Y') }}</dd>
                                        @endforeach
                                    </dl>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Lukk</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col (left) -->

    <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">VIP Medlemmer</h3>
            </div>
            <div class="box-body">
                <dl class="dl-horizontal">
                    @foreach ($vipCount as $key => $value)
                        <dt>{{ $key }} :</dt>
                        <dd>{{ $value }}</dd>
                    @endforeach
                </dl>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col (right) -->
</div>
<!-- /.row -->

<div class="row">
    <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Alder</h3>
            </div>
            <div class="box-body">
                <div class="chart">
                    <canvas id="age-groups" style="height:250px"></canvas>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col (left) -->

    <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Fakultet</h3>
            </div>
            <div class="box-body">
                <canvas id="departments" style="height:250px"></canvas>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col (right) -->
</div>
<!-- /.row -->
@endsection

@section('footer')
<!-- Chart.js -->
<script src="{{ asset("/plugins/Chart.js/Chart.min.js") }}"></script>
<script>
$(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#departments').get(0).getContext('2d');
    var pieChart       = new Chart(pieChartCanvas);
    var PieData        = [
        @foreach($numberOfDepartments as $data)
        {
            value: '{{ $data->amount }}',
            label: "{{ $data->department }}",
            color    : '#f56954',
            highlight: '#f56954'
        },
        @endforeach
        ];

    var pieOptions     = {
        //Boolean - Whether we should show a stroke on each segment
        segmentShowStroke    : true,
        //String - The colour of each segment stroke
        segmentStrokeColor   : '#fff',
        //Number - The width of each segment stroke
        segmentStrokeWidth   : 2,
        //Number - The percentage of the chart that we cut out of the middle
        percentageInnerCutout: 50, // This is 0 for Pie charts
        //Number - Amount of animation steps
        animationSteps       : 100,
        //String - Animation easing effect
        animationEasing      : 'easeOutBounce',
        //Boolean - Whether we animate the rotation of the Doughnut
        animateRotate        : true,
        //Boolean - Whether we animate scaling the Doughnut from the centre
        animateScale         : true,
        //Boolean - whether to make the chart responsive to window resizing
        responsive           : true,
        // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
        maintainAspectRatio  : true
    };
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions);

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#age-groups').get(0).getContext('2d');
    var barChart       = new Chart(barChartCanvas);
    var barChartData   = {
        labels: [
                @foreach($ageGroups as $key => $data)
                    '{{ $key }}',
                @endforeach],
        datasets: [
            {
                data: [
                    @foreach($ageGroups as $key => $data)
                        '{{ $ageGroups[$key] }}',
                    @endforeach
                ]
            }
        ]
    };
    barChartData.datasets[0].fillColor   = '#00a65a';
    barChartData.datasets[0].strokeColor = '#00a65a';
    barChartData.datasets[0].pointColor  = '#00a65a';
    var barChartOptions                  = {
        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
        scaleBeginAtZero        : true,
        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines      : true,
        //String - Colour of the grid lines
        scaleGridLineColor      : 'rgba(0,0,0,.05)',
        //Number - Width of the grid lines
        scaleGridLineWidth      : 1,
        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,
        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines  : true,
        //Boolean - If there is a stroke on each bar
        barShowStroke           : true,
        //Number - Pixel width of the bar stroke
        barStrokeWidth          : 2,
        //Number - Spacing between each of the X value sets
        barValueSpacing         : 5,
        //Number - Spacing between data sets within X values
        barDatasetSpacing       : 1,
        //Boolean - whether to make the chart responsive
        responsive              : true,
        maintainAspectRatio     : true
    };

    barChartOptions.datasetFill = false;
    barChart.Bar(barChartData, barChartOptions)
})
</script>

@endsection
