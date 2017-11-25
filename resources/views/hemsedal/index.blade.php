@extends('layouts.master')

@section('title', 'Medlemmer')

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
                    <h1 class="page-header">Hemsedal</h1>
                    @include('errors.errors')
                    @include('flash::message')
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Viser alle påmeldte.
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-hover" id="hemsedalTable">
                                    <thead>
                                        <tr>
                                            <th colspan="4">
                                                {!! Form::button('Betaling OK', ['class' => 'btn btn-success', 'disabled' => 'disabled']) !!}
                                                {!! Form::button('Kun depositum', ['class' => 'btn btn-warning ', 'disabled' => 'disabled']) !!}
                                                {!! Form::button('Ingenting betalt', ['class' => 'btn btn-danger ', 'disabled' => 'disabled']) !!}
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>&nbsp;</th>
                                            <th>Navn</th>
                                            <th>Telefon</th>
                                            <th>Epost</th>
                                        </tr>
                                    </thead>
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

        <!-- Page-Level Scripts - hemsedalTable -->
            <script>
                $(function() {
                    $('#hemsedalTable').DataTable({
                        responsive: true,
                        order: [[ 1, "asc" ]],
                        pageLength: 25,
                        processing: true,
                        serverSide: true,
                        ajax: '{!! route('hemsedal.getIndex') !!}',
                        columns: [
                            {data: 'action', name: 'action', orderable: false, searchable: false},
                            { data: 'name', name: 'name' },
                            { data: 'phone', name: 'phone' },
                            { data: 'email', name: 'email' }
                        ]
                    });
                });
            </script>
@endsection