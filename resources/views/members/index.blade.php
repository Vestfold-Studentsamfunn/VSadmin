@extends('layouts.master')

@section('title', 'Medlemmer')

@section('header')
<!-- DataTables CSS -->
{!! HTML::style('https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css') !!}
{!! HTML::style('https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css') !!}
@stop

@section('sidebar')
    @parent
@endsection

@section('content')
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Medlemmer</h1>
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
                            Alle medlemmer i Vestfold Studentsamfunn
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-hover" id="membersTable">
                                    <thead>
                                        <tr>
                                            <th colspan="7">
                                                {!! Form::button('Betaling OK', ['class' => 'btn btn-success ', 'disabled' => 'disabled']) !!}
                                                {!! Form::button('Ikke betalt', ['class' => 'btn btn-danger ', 'disabled' => 'disabled']) !!}
                                                {!! Form::button('Kort ikke skrevet ut', ['class' => 'btn btn-warning ', 'disabled' => 'disabled']) !!}
                                                {!! Form::button('Ikke betalt, har kort', ['class' => 'btn btn-info ', 'disabled' => 'disabled']) !!}
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>&nbsp;</th>
                                            <th>Medlemsnr</th>
                                            <th>Navn</th>
                                            <th>Telefon</th>
                                            <th>Epost</th>
                                            <th>Fakulktet</th>
                                            <th>VIP</th>
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

<!-- Page-Level Scripts - membersTable -->
<script>
    $(function() {
        $('#membersTable').DataTable({
            responsive: true,
            order: [[ 1, "asc" ]],
            pageLength: 25,
            processing: true,
            serverSide: true,
            ajax: '{!! route('members.getIndex') !!}',
            columns: [
                {data: 'action', name: 'action', orderable: false, searchable: false},
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'phone', name: 'phone' },
                { data: 'email', name: 'email' },
                { data: 'department', name: 'department' },
                { data: 'vipGroup', name: 'vipGroup' }
            ]
        });
    });
</script>
@endsection