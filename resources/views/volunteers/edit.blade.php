@extends('layouts.master')

@section('title', 'Frivillige')

@section('header')

@stop

@section('sidebar')
    @parent
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Rediger frivillig</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ $volunteer->name }}
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                    @include('errors.errors')
                    @include('flash::message')
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab">Oversikt</a>
                        </li>
                        <li><a href="#jobs" data-toggle="tab">Interesser</a>
                        </li>
                        <li><a href="#email" data-toggle="tab">Epost</a>
                        </li>
                        <li><a href="#sms" data-toggle="tab">SMS</a>
                        </li>
                        <li><a href="#settings" data-toggle="tab">Innstillinger</a>
                        </li>
                    </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="home">
                                <div class="col-lg-8">
                                    <br/>
                                    <dl class="dl-horizontal">
                                        <dt>Navn:</dt>
                                        <dd>{{ $volunteer->name }}</dd>
                                        <dt>Epost:</dt>
                                        <dd>{{ $volunteer->email }}</dd>
                                        <dt>Telefon:</dt>
                                        <dd>{{ $volunteer->phone }}</dd>
                                        <hr>
                                        <dt>Interessert i:</dt>
                                        <dd>
                                            @foreach ($volunteerJobs as $job)
                                                @if ($volunteer->volunteerJobs->find($job->id))
                                                    {{ $job->name }},
                                                @endif
                                            @endforeach
                                        </dd>
                                    </dl>
                                    <div class="panel-footer">

                                    </div>
                                </div>
                            </div>


                            <div class="tab-pane fade" id="jobs">
                                <div class="col-lg-8">

                                <form role="form" method="POST" action="{{ URL::to('volunteers/update') }}/{{ $volunteer->id }}" name="volunteerEdit" accept-charset="UTF-8" enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <br/>
                                    <div class="form-group">
                                        @foreach ($volunteerJobs->chunk(4) as $chunk)
                                            <div class="row">
                                                @foreach ($chunk as $availableJob)
                                                    <div class="col-lg-3">
                                                        <label class="checkbox-inline">
                                                            @if ($volunteer->volunteerJobs->find($availableJob->id))
                                                                {!! Form::checkbox('jobs[]', $availableJob->id, true) !!} {{ $availableJob->name }}
                                                            @else
                                                                {!! Form::checkbox('jobs[]', $availableJob->id, false) !!} {{ $availableJob->name }}
                                                            @endif
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                        <br>
                                        <button type="submit" name="updateVolunteerProfile" class="btn btn-success btn-md">Lagre</button>
                                        <button type="reset" class="btn btn-default btn-md">Nullstill</button>
                                    </div>
                                </form>
                                </div>
                            </div>


                            <div class="tab-pane fade" id="email">
                                <div class="col-lg-8">
                                    <h4>Email Tab</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div>
                            </div>


                            <div class="tab-pane fade" id="sms">
                                <div class="col-lg-8">
                                <div class="form-group">
                                    {!! Form::model($volunteer, array('route' => array('sms.send'))) !!}

                                    {!! Form::label('name', 'Til') !!}
                                    {!! Form::text('name', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                                    {!! Form::number('phone', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}

                                    {!! Form::hidden('phone[]', null) !!}

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

                                </div>
                                </div>
                            </div>


                            <div class="tab-pane fade" id="settings">
                                <div class="col-lg-8">
                                <br/>
                                    <form role="form" method="POST" action="{{ URL::to('volunteers/update/settings') }}/{{ $volunteer->id }}" id="volunteerSettings" accept-charset="UTF-8">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="form-group">
                                            <br/>
                                        </div>
                                        <button type="submit" class="btn btn-success btn-md">Lagre</button>
                                        <button type="reset" class="btn btn-default btn-md">Nullstill</button>
                                    </form>
                                    <br/>
                                    <!-- Button trigger modal -->
                                    <button class="btn btn-danger btn-md" data-toggle="modal" data-target="#myModal">
                                        Fjern frivillig
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title" id="myModalLabel">Fjern frivillig?</h4>
                                                </div>
                                                <div class="modal-body">
                                                    Er du sikker på at du vil fjerne den frivillige? Dette kan ikke gjøres om på!
                                                </div>
                                                <div class="modal-footer">
                                                    <form role="form" method="POST" action="{{ URL::to('volunteers/delete') }}/{{ $volunteer->id }}" id="volunteerDelete" accept-charset="UTF-8">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Avbryt</button>
                                                        <button type="submit" class="btn btn-danger">Fjern frivillig!</button>
                                                    </form>
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
                        <!-- /tab-content -->
                    </div>
                    <!-- /.col-lg-6 (nested) -->
                    <div class="col-lg-6">
                    </div>
                    <!-- /.col-lg-6 (nested) -->
                </div>
                <!-- /.row (nested) -->
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
        <!-- SMS -->
{!! HTML::script('js/sms/single_sms.js') !!}
        <!-- SMS character counting -->
{!! HTML::script('js/sms/char_count.js') !!}
@endsection