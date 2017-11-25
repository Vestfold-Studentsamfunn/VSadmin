@extends('layouts.master')

@section('title', 'Medlemmer')

@section('header')

@stop

@section('sidebar')
    @parent
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Rediger påmelding</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ $participant->name }}
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                    @include('errors.errors')
                    @include('flash::message')
                    <div id="showresults"></div>

                        <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab">Oversikt</a>
                        </li>
                        <li><a href="#info" data-toggle="tab">Info</a>
                        </li>
                        <li><a href="#e-mail" data-toggle="tab">Epost</a>
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
                                    <dt>Navn</dt>
                                    <dd>{{ $participant->name }}</dd>
                                    <hr>
                                    <dt>Romønsker</dt>
                                    <dd>
                                        {{ $participant->room }}
                                    </dd>
                                    <hr>
                                    <dt>Påmeldt</dt>
                                    <dd>
                                        {{ $participant->created_at->format('d.m.Y H:i:s') }}
                                    </dd>
                                    <dt>Depositum innbetalt</dt>
                                    <dd>
                                        @if ($participant->depPayed == 1)
                                            {{ $participant->depPayed_at->format('d.m.Y') }}
                                        @else
                                            Depositum er ikke betalt.
                                        @endif
                                    </dd>
                                    <dt>Sluttsum innbetalt</dt>
                                    <dd>
                                        @if ($participant->allPayed == 1)
                                            {{ $participant->allPayed_at->format('d.m.Y') }}
                                        @else
                                            Sluttsum er ikke betalt.
                                        @endif
                                    </dd>
                                </dl>
                                <div class="form-group text-center">
                                    <form role="form" method="POST" action="{{ URL::to('hemsedal/update/payment') }}/{{ $participant->id }}" name="hemsedalPayment" accept-charset="UTF-8">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        @if ($participant->depPayed == 0 AND $participant->allPayed == 0)
                                            <button type="submit" name="depositum_payment" value="1" class="btn btn-success btn-lg btn-block">Registrer depositum</button>
                                        @elseif ($participant->depPayed == 1 AND $participant->allPayed == 0)
                                            <button type="submit" name="final_payment" value="1" class="btn btn-success btn-lg btn-block">Registrer sluttsum</button>
                                        @endif
                                    </form>
                                </div>
                                <div class="panel-footer">
                                    Sist endret: {{ $participant->updated_at }}
                                </div>
                                    </div>
                            </div>


                            <div class="tab-pane fade" id="info">
                                <div class="form-group">
                                    <div class="col-lg-8">
                                        <br/>
                                        <div class="form-group">
                                            {!! Form::model($participant, array('route' => array('hemsedal.update', 'id' => $participant->id))) !!}

                                            {!! Form::label('member_id', 'Medlemsnummer') !!}
                                            {!! Form::number('member_id', null, ['class' => 'form-control' ]) !!}

                                            {!! Form::label('name', 'Navn') !!}
                                            {!! Form::text('name', null, ['class' => 'form-control' ]) !!}

                                            {!! Form::label('phone', 'Telefonnummer') !!}
                                            {!! Form::number('phone', null, ['class' => 'form-control' ]) !!}

                                            {!! Form::label('email', 'Epost') !!}
                                            {!! Form::email('email', null, ['class' => 'form-control' ]) !!}

                                            {!! Form::label('sweaterSize', 'Genser') !!}
                                            {!! Form::select('sweaterSize', $sweater_sizes, null, ['class' => 'form-control']) !!}

                                            {!! Form::label('busHome', 'Buss hjem') !!}
                                            {!! Form::select('busHome', $bus_home, null, ['class' => 'form-control']) !!}

                                            {!! Form::label('room', 'Romønsker') !!}
                                            {!! Form::textarea('room', null, ['class' => 'form-control' ]) !!}
                                            <br/>
                                            {!! Form::submit('Lagre', ['class' => 'btn btn-primary']) !!}
                                            {!! Form::reset('Reset', ['class' => 'btn btn-default']) !!}

                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="tab-pane fade" id="e-mail">
                                <div class="col-lg-8">
                                    <h4>Email Tab</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div>
                            </div>


                            <div class="tab-pane fade" id="sms">
                                <div class="col-lg-8">
                                <div class="form-group">
                                    {!! Form::model($participant, array('route' => array('sms.send'))) !!}

                                    {!! Form::label('name', 'Til') !!}
                                    {!! Form::text('name', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                                    {!! Form::number('phone', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}

                                    {!! Form::hidden('phone', null, ['id' => 'number']) !!}

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
                                                        <div class="progress-bar progress-bar-striped active" id="progressBar" role="progressbar" style="width:100%">
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


                            <div class="tab-pane fade" id="settings">
                                    <!--
                                    <br/>
                                    <form role="form" method="POST" action="{{ URL::to('hemsedal/update/settings') }}/{{ $participant->id }}" id="volunteerSettings" accept-charset="UTF-8">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="form-group">
                                            <br/>
                                        </div>
                                        <button type="submit" class="btn btn-success btn-md">Lagre</button>
                                        <button type="reset" class="btn btn-default btn-md">Nullstill</button>
                                    </form>
                                    -->
                                    <br/>
                                    <!-- Button trigger modal -->
                                    <button class="btn btn-danger btn-md" data-toggle="modal" data-target="#myModal">
                                        Fjern påmeldt
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title" id="myModalLabel">Fjern påmeldt?</h4>
                                                </div>
                                                <div class="modal-body">
                                                    Er du sikker på at du vil slette den påmeldte? Dette kan ikke gjøres om på!
                                                </div>
                                                <div class="modal-footer">
                                                    <form role="form" method="POST" action="{{ URL::to('hemsedal/delete') }}/{{ $participant->id }}" id="participantDelete" accept-charset="UTF-8">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Avbryt</button>
                                                        <button type="submit" class="btn btn-danger">Slett påmeldt!</button>
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