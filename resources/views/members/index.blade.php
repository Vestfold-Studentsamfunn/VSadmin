@extends('layouts.master')

@section('title', 'Medlemsoversikt')

@section('description', 'Alle medlemmer i Vestfold Studentsamfunn')

@section('header')
    <link rel="stylesheet" href="{{ asset("/plugins/datatables/css/dataTables.bootstrap.css") }}">
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <table id="membersTable" class="table table-bordered table-hover" >
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
                        </tr>
                    </thead>
                </table>
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
    <script src="{{ asset("/plugins/datatables/js/jquery.dataTables.js") }}"></script>
    <script src="{{ asset("/plugins/datatables/js/dataTables.bootstrap.js") }}"></script>

<!-- Page-Level Scripts - membersTable -->
<script>
    $(function() {
        $('#membersTable').DataTable({
            responsive: true,
            order: [[ 1, "asc" ]],
            pageLength: 25,
            processing: true,
            serverSide: true,
            ajax: '{!! route('members.indexAjax') !!}',
            columns: [
                {data: 'action', name: 'action', orderable: false, searchable: false},
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'phone', name: 'phone' },
                { data: 'email', name: 'email' },
                { data: 'department', name: 'department' }
            ]
        });
    });
</script>
@endsection