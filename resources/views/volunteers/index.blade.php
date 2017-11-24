@extends('layouts.master')

@section('title', 'Frivillige')

@section('header')
<!-- Timeline CSS -->
{!! HTML::style('https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css') !!}

<!-- Morris Charts CSS -->
{!! HTML::style('https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css') !!}
@stop

@section('sidebar')
    @parent
@endsection

@section('content')
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Frivillige</h1>
                    @include('errors.errors')
                    @include('flash::message')
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <a href="{{ URL::to('volunteers/create') }}" class="btn btn-success"><i class="glyphicon glyphicon-user fa-fw"></i> Registrer ny frivillig</a>
                    <br><br>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Viser alle registrerte frivillige.
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-hover" id="volunteersTable">
                                    <thead>
                                        <tr>
                                            <th>&nbsp;</th>
                                            <th>Navn</th>
                                            <th>Telefon</th>
                                            <th>Interessert i</th>
											<th>Registrert</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($volunteers as $volunteer)
                                        <tr>
                                            <td>
                                                <a href="{{route('volunteer.edit', ['id' => $volunteer->id])}}" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i> Vis info</a>
                                            </td>
                                            <td>{{ $volunteer->name }}</td>
                                            <td>{{ $volunteer->phone }}</td>
                                            <td>
                                            @foreach ($volunteerJobs as $job)
                                                    @if ($volunteer->volunteerJobs->find($job->id))
                                                        {{ $job->name }},
                                                    @endif
                                            @endforeach
                                            </td>
											<td>
												@if ($volunteer->created_at)
													{{ $volunteer->created_at->format('Y.m.d - H:i') }}
												@else
												{{$volunteer->created_at}}
												@endif
											</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
@endsection

@section('footer')

<!-- DataTables JavaScript -->
{!! HTML::script('bower_components/datatables/media/js/jquery.dataTables.min.js') !!}
{!! HTML::script('bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js') !!}

    <!-- Page-Level Scripts - Tables -->
    <script>
    $(document).ready(function() {
        $('#volunteersTable').DataTable({
            responsive: true,
            order: [[ 1, "asc" ]],
            "columnDefs": [
                { "orderable": false, "targets": 0 }
            ]
        });
    });
    </script>

@endsection