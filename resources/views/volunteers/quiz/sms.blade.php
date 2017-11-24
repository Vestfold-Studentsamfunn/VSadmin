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
            <h1 class="page-header">Send SMS til frivillige</h1>
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
                    Filtrer på navn, telefon eller jobb
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    {!! Form::open(array('route' => array('sms.send'))) !!}
                    <div class="dataTable_wrapper">
                        <table class="table table-hover" id="smsTable">
                            <thead>
                            <tr>
                                <th width="150px" nowrap>
                                    {!! Form::checkbox('checkAll', null, false, ['id' => 'checkAll']) !!}
                                    {!! Form::label('checkAll', 'Send SMS') !!}
                                </th>
                                <th>Navn</th>
                                <th>Telefon</th>
                                <th>Jobber</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($volunteers as $volunteer)
                                <tr>
                                    <td>
                                        <div id="response_{!! $volunteer->phone !!}">&nbsp;&nbsp;{!! Form::checkbox('phone[]', $volunteer->phone, false, ['class' => 'send_sms', 'id' => $volunteer->name]) !!}</div>
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
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                    <div class="col-lg-6">
                    <div class="form-group">
                        {!! Form::label('name', 'Til') !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}

                        {!! Form::label('sms_from', 'Fra') !!}
                        {!! Form::text('sms_from', 'Samfunnet', ['class' => 'form-control', 'disabled' => 'disabled']) !!}

                        {!! Form::label('message', 'Melding') !!}<br/>
                        {!! Form::textarea('message', null, ['class' => 'form-control', 'maxlength' => '305']) !!}
                        <strong><em class="text-info">Gyldige tegn: A-Å, a-å, 0-9 , . : ; ! ' " - _ @ ( ) \ /</em></strong>
                        <div><span id="total">0</span> tegn / <span id="messages">0</span> melding<span class="mplural">er</span> (maks 305 tegn / 2 meldinger)</div>
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