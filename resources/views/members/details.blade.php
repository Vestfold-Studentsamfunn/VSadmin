@extends('layouts.master')

@section('title', 'Dashboard')

@section('header')
<!-- Timeline CSS -->
{!! HTML::style('dist/css/timeline.css') !!}

<!-- Morris Charts CSS -->
{!! HTML::style('bower_components/morrisjs/morris.css') !!}
@endsection

@section('sidebar')
    @parent
@endsection

@section('content')

@include('errors.errors')
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Detaljer - Medlemmer</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
 <!-- /.row -->
            <div class="row">
                <div class="col-lg-6">
                    <h4>Medlemmer</h4>
                    <dl class="dl-horizontal">
                        <dt>Årsmedlem :</dt>
                            <dd>{{ $numberOfMembers - $halfYear }}</dd>
                        <dt>Halvårsmedlem :</dt>
                            <dd>{{ $halfYear }}</dd>
                        <dt>Utestengt :</dt>
                        <dd><button class="btn btn-info btn-xs" data-toggle="modal" data-target="#bannedModal">
                                Vis info
                            </button></dd>
                        <!-- Button trigger modal -->
                        <!-- Modal -->
                        <div class="modal fade" id="bannedModal" tabindex="-1" role="dialog" aria-labelledby="bannedModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">Utestengte medlemmer</h4>
                                    </div>
                                    <div class="modal-body">
                                        @foreach($banned as $name => $value)
                                            <dt>{{ $name }}</dt>
                                            <dd>Utestengt til {{ $value }}</dd>
                                        @endforeach
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Lukk</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                    </dl>
                    <hr>
                    <h4>VIP Medlemmer</h4>
                    <dl class="dl-horizontal">
                        @foreach ($vipCount as $key => $value)
                            <dt>{{ $key }} :</dt>
                            <dd>{{ $value }}</dd>
                        @endforeach
                    </dl>
                    <hr>
                </div>

                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Alder
                        </div>
                        <div class="panel-body">
                            <div id="age-groups-chart"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Fakultet
                        </div>
                        <div class="panel-body">
                            <div id="departments-donut"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
@endsection

@section('footer')

    <!-- Morris Charts JavaScript -->
    {!! HTML::script('bower_components/raphael/raphael-min.js') !!}
    {!! HTML::script('bower_components/morrisjs/morris.min.js') !!}

    <script>
        $(function() {

            Morris.Bar({
                element: 'age-groups-chart',
                data: [
                        @foreach($ageGroups as $key => $data)
                    {
                        x: '{{ $key }}',
                        y: '{{ $ageGroups[$key] }}'
                    },
                    @endforeach
                ],
                xkey: 'x',
                ykeys: ['y'],
                labels: ['Antall'],
                hideHover: 'auto',
                xLabelMargin: 5,
                resize: true
            });

            Morris.Donut({
                element: 'departments-donut',
                data: [
                        @foreach($numberOfDepartments as $data)
                    {
                        label: "{{ $data->department }}",
                        value: '{{ $data->amount }}'
                    },
                    @endforeach
                ],
                resize: true
            });
        });
    </script>

@endsection
