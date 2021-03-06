@extends('layouts.master')

@section('title', 'Quizmastere')

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
                    <h1 class="page-header">Quizmastere</h1>
                    @include('errors.errors')
                    @include('flash::message')
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <a href="{{route('quiz.create')}}" class="btn btn-success"><i class="glyphicon glyphicon-user fa-fw"></i> Registrer ny Quizmaster</a>
                    <a href="{{route('quiz.emails')}}" class="btn btn-info"><i class="glyphicon glyphicon-envelope fa-fw"></i> E-postliste</a>
                    <a href="{{route('quiz.phones')}}" class="btn btn-info"><i class="glyphicon glyphicon-phone fa-fw"></i> Telefonliste</a>
                    <br><br>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Viser alle registrerte quizmastere.
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-hover" id="quizmasterTable">
                                    <thead>
                                        <tr>
                                            <th>&nbsp;</th>
                                            <th>Navn</th>
                                            <th>Telefon</th>
                                            <th>Epost</th>
                                            <th>Medhjelper</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($quizmasters as $quizmaster)
                                        <tr>
                                            <td>
                                                <a href="{{route('quiz.edit', ['id' => $quizmaster->id])}}" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i> Vis info</a>
                                            </td>
                                            <td>{{ $quizmaster->name_q1 }}</td>
                                            <td>{{ $quizmaster->phone_q1 }}</td>
                                            <td>{{ $quizmaster->email_q1 }}</td>
                                            <td>{{ $quizmaster->name_q2 }}</td>
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

    <!-- Page-Level Scripts - quizmasterTable -->
    <script>
    $(document).ready(function() {
        $('#quizmasterTable').DataTable({
            responsive: true,
            order: [[ 1, "asc" ]],
            pageLength: 25,
            "columnDefs": [
                { "orderable": false, "targets": 0 }
            ]
        });
    });
    </script>

@endsection