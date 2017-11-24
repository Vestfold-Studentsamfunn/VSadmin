@extends('layouts.master')

@section('title', 'Enkeltperson')

@section('header')
    <!-- Timeline CSS -->
    {!! HTML::style('bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css') !!}

    <!-- Morris Charts CSS -->
    {!! HTML::style('bower_components/datatables-responsive/css/dataTables.responsive.css') !!}
@stop

@section('sidebar')
    @parent
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Send enkelt SMS</h1>
            @include('errors.errors')
            @include('flash::message')
            <div id="showresults"></div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="col-lg-8">
        {!! Form::model(array('route' => array('sms.send'), 'method' => 'post', 'id' => 'form-send-sms')) !!}

        {!! Form::label('name', 'Til') !!}
        {!! Form::number('phone[]', null, ['id' => 'number', 'class' => 'form-control']) !!}

        {!! Form::label('sms_from', 'Fra') !!}
        {!! Form::text('sms_from', 'Samfunnet', ['class' => 'form-control', 'disabled' => 'disabled']) !!}

        {!! Form::label('message', 'Melding') !!}<br/>
        {!! Form::textarea('message', null, ['class' => 'form-control', 'maxlength' => '305']) !!}
        <strong><em class="text-info">Gyldige tegn: A-Å, a-å, 0-9 , . : ; ? ! ' " - _ @ ( ) \ /</em></strong>
        <div><span id="total">0</span> tegn / <span id="messages">0</span> melding<span class="mplural">er</span> (maks 305 tegn)</div>
        <br/>
    {!! Form::button('Send', ['class' => 'btn btn-primary', 'id' => 'btn-send-sms']) !!}
    {!! Form::reset('Reset', ['class' => 'btn btn-default']) !!}

    {!! Form::close() !!}
    <!-- Modal -->
        <div class="modal fade" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Vennligst vent....</h4>
                    </div>
                    <div class="modal-body">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped active" role="progressbar" style="width:100%">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
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

    <!-- SMS -->
    {!! HTML::script('js/sms/multiple_sms.js') !!}
    <!-- SMS character counting -->
    {!! HTML::script('js/sms/char_count.js') !!}

    <!-- Page-Level Scripts - Voluneers SMS -->
    <script>
        $(document).ready(function() {
            $('#smsTable').DataTable({
                responsive: true,
                order: [[ 1, "asc" ]],
                "columnDefs": [
                    { "orderable": false, "targets": 0 }
                ]
            });

            var table = $('#smsTable').DataTable();

            $('#checkAll').click(function () {
                $(':checkbox', table.rows({search:'applied'}).nodes()).prop('checked', this.checked);
                if ($(this).is(':checked')) {
                    $('#name').val('Alle merkede');
                } else {
                    $('#name').val('');
                }
            });

            var checks = $(':checkbox', table.rows().nodes());
            checks.on('click', function() {
                $("#checkAll").prop("checked", false);
                var string = checks.filter(":checked").map(function(){
                    return this.id;
                }).get().join("; ");
                $('#name').val(string);
            });
        });
    </script>
@endsection