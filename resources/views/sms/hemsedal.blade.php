@extends('layouts.master')

@section('title', 'Medlemmer')

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
            <h1 class="page-header">Send SMS til påmeldte</h1>
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
                    Placeholder Title
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="col-lg-8">

                    {!! Form::open(array('route' => array('sms.send'))) !!}
                        <dl class="dl-horizontal">
                            <dt>Betalingsstatus</dt>
                            <dd>
                                <label class="checkbox-inline">
                                {!! Form::checkbox('paymentStatus[]', 'unpaid', false, ['class' => 'paymentStatus']) !!} Ubetalte
                                </label>
                                <label class="checkbox-inline">
                                    {!! Form::checkbox('paymentStatus[]', 'depositum', false, ['class' => 'paymentStatus']) !!} Kun depositum
                                </label>
                                <label class="checkbox-inline">
                                    {!! Form::checkbox('paymentStatus[]', 'allPayed', false, ['class' => 'paymentStatus']) !!} Alt betalt
                                </label>
                            </dd>
                            <br/>
                        </dl>
                        <div id="workers"></div>
                    <div class="form-group">
                        {!! Form::label('sms_to', 'Til') !!}
                        {!! Form::text('sms_to', null , ['class' => 'form-control', 'disabled' => 'disabled']) !!}

                        {!! Form::label('sms_from', 'Fra') !!}
                        {!! Form::text('sms_from', 'Samfunnet', ['class' => 'form-control', 'disabled' => 'disabled']) !!}

                        {!! Form::label('message', 'Melding') !!}<br/>
                        {!! Form::textarea('message', null, ['class' => 'form-control', 'maxlength' => '305']) !!}
                        <strong><em class="text-info">Gyldige tegn: A-Å, a-å, 0-9 , . : ; ? ! ' " - _ @ ( ) \ /</em></strong>
                        <div><span id="total">0</span> tegn / <span id="messages">0</span> melding<span class="mplural">er</span> (maks 305 tegn / 2 meldinger)</div>
                        <br/>
                        <div id="showresults">
                        {!! Form::button('Send', ['class' => 'btn btn-primary', 'id' => 'btn-send-sms']) !!}
                        {!! Form::reset('Reset', ['class' => 'btn btn-default']) !!}
                        </div>
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
                                            <div class="progress-bar progress-bar-striped active" id="progressBar" role="progressbar" style="width:0%">
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

            <!-- SMS character counting -->
    {!! HTML::script('js/sms/char_count.js') !!}

            <!-- Page-Level Scripts - Members SMS -->
    <script>
        $(document).ready(function(){

            var numbers = [];
            var paymentStatus = [];

            updateNumbersArray();

            $("input[name='paymentStatus[]']").change(function () {
                paymentStatus.length = 0;
                $.each($("input[name='paymentStatus[]']:checked"), function() {
                    paymentStatus.push($(this).val());
                });

                updateNumbersArray();
            });

            function updateNumbersArray(){
                //.....
                //show some spinner etc to indicate operation in progress
                //.....
                $('#progressBar').css('width', '100%');

                $(document).on({
                    ajaxStart: function() { $('#pleaseWaitDialog').modal('show'); },
                    ajaxStop: function() { $('#pleaseWaitDialog').modal('hide'); }
                });

                numbers.length = 0;

                $.ajax({
                    url: "/sms/hemsedal",
                    type: "POST",
                    data: {
                        _token: $('input[name=_token]').val(),
                        paymentStatus: paymentStatus
                    },
                    dataType : 'json',
                    cache: false,
                    success: function(records){
                        $.each(records, function() {
                            $.each(this, function(name, value) {
                                numbers.push(value);
                            });
                        });
                        $('#sms_to').val(''+numbers.length+' påmeldte');
                    }
                });
            }

            $('#btn-send-sms').click(function(){
                //.....
                //show some spinner etc to indicate operation in progress
                //.....
                $(document).on({
                    ajaxStart: function() { $('#pleaseWaitDialog').modal('show'); },
                    ajaxStop: function() {
                        $('#pleaseWaitDialog').modal('hide');
                        notification = '<div class="text-success">&nbsp;&nbsp;<i class="fa fa-check fa-lg"></i>&nbsp;';
                        notification += "Sendt!";
                        notification += '</div>';
                        $('#showresults').html(notification);
                    }
                });

                var message = $('#message').val();
                var recipients = numbers.length;
                var numbersDone = 0;
                var notification, errors;

                numbers.forEach(function(number) {
                    $.ajax({
                        url: "/sms/send",
                        type: "POST",
                        data: {
                            'number': number,
                            'message': message
                        },

                        success: function (data) {
                            if (data.status === 'success') {
                                numbersDone++;
                                updateProgress((numbersDone / recipients) * 100);
                            }
                            else if (data.status === 'error') {
                                numbersDone++;
                                updateProgress((numbersDone / recipients) * 100);
                            }
                            else {
                                numbersDone++;
                                updateProgress((numbersDone / recipients) * 100);
                            }
                        },
                        error: function (data) {
                            if (data.status === 422) {
                                var errorsJSON = data.responseJSON;
                                errors = '<div class="alert alert-danger"><i class="fa fa-warning fa-2x"></i>&nbsp;';

                                $.each(errorsJSON, function (key, value) {
                                    errors += value[0]; //showing only the first error.
                                });
                                errors += '</div>';

                                $('#showresults').html(errors);
                            }
                        },
                        complete: function () {
                        }
                    });
                });

                //.....
                //do anything else you might want to do
                //.....
                function updateProgress(percentage){
                    if(percentage > 100) percentage = 100;
                    $('#progressBar').css('width', percentage+'%');
                    $('#progressBar').html(numbersDone+' av '+recipients);
                }
            });
        });
    </script>
@endsection