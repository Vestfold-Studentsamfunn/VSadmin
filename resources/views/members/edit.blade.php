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
        <h1 class="page-header">Rediger medlem</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel {{ $panel_type  }}">
            <div class="panel-heading">
                {{$member->id}} - {{ $member->name }} @if ($banned) (UTESTENGT) @endif
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
                        <li><a href="#profile" data-toggle="tab">Info</a>
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
                                    @if ($banned) <h3><span style="color: #d9534f;"><u>UTESTENGT TIL {{$banned_to}}</u></span></h3> @endif
                                    <dl class="dl-horizontal">
                                        <dt>Navn</dt>
                                        <dd>{{ $member->name }}</dd>
                                        @if ($memberAge < 20)
                                            <dt>U20 kontrakt</dt>
                                            @if ($member->u20 == true)
                                                <dd>OK</dd>
                                            @else
                                                <dd>Ikke signert</dd>
                                            @endif
                                        @endif
                                        @if ($member->vipGroup != "Ingen")
                                            <dt>VIP</dt>
                                            <dd>{{ $member->vipGroup }}</dd>
                                        @endif
                                        <hr>
                                        <!--
                                        <dt>Kortnummer</dt>
                                        <dd>
                                            @if ($member->cardNumber != 0)
                                                <p>{{ $member->cardNumber }}</p>
                                            @else
                                                @if ($member->payed == -1)
                                                    <p class="text-danger">Kortnummer er ikke registrert!</p>
                                                @else
                                                    <p class="text-warning">Kortet er ikke skrevet ut!</p>
                                                @endif
                                            @endif
                                        </dd>
                                        -->
                                        <dt>Innmeldt</dt>
                                        <dd>{{ $member->created_at->format('d.m.Y') }}</dd>
                                        <dt>Betalt</dt>
                                        <dd>
                                            @if ($member->payed == -1 OR $member->payed == 1)
                                                {{ $member->payedDate->format('d.m.Y') }}
                                            @else
                                                Betaling er ikke registrert!
                                            @endif
                                        </dd>
                                    </dl>
                                    <div class="form-group text-center">
                                        <form role="form" method="POST" action="{{ URL::to('members/update/payment') }}/{{ $member->id }}" name="memberPaymentAndCard" accept-charset="UTF-8">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        @if ($member->payed == 0 OR $member->payed == 2)
                                                <!--(at)if ($member->payed == 0 OR $member->payed == 2) TODO endre til sjekk på U20, om U20, legg til sjekk på vist studiebevis før godta betaling-->
                                            <input name='registerPayment' type='hidden' value='1'>
                                            <button type="submit" name="register" class="btn btn-success btn-lg btn-block">Registrer betaling for {{$member->semesters}} semestere</button>
                                        @elseif ($member->payed == -1)
                                            <input name='printNewCard' type='hidden' value='1'>
                                            <button type="submit" name="print" class="btn btn-warning btn-lg btn-block">Skriv ut nytt kort</button>
                                        @endif
                                        </form>
                                    </div>
                                    <div class="panel-footer">
                                        Sist endret: {{ $member->updated_at->format('H:i:s d.m.Y') }} // TODO Hvem gjorde redigeringen. Logg.
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <br/>
                                    <div class="text-left"><img src='{{ URL::to('members/picture/show') }}/{{ $member->id }}' align='center' border='0' width='200'></div>
                                </div>
                            </div>


                            <div class="tab-pane fade" id="profile">
                                {!! Form::model($member, array('route' => array('members.update', 'id' => $member->id), 'files' => true)) !!}
                                <div class="col-lg-8">
                                    <br/>
                                    <div class="form-group">
                                        {!! Form::label('name', 'Navn') !!}
                                        {!! Form::text('name', null, ['class' => 'form-control' ]) !!}

                                        {!! Form::label('address', 'Adresse') !!}
                                        {!! Form::text('address', null, ['class' => 'form-control' ]) !!}

                                        {!! Form::label('postalCode', 'Postnummer') !!}
                                        {!! Form::number('postalCode', null, ['class' => 'form-control' ]) !!}

                                        {!! Form::label('postalArea', 'Poststed') !!}
                                        {!! Form::text('postalArea', null, ['class' => 'form-control' ]) !!}

                                        {!! Form::label('phone', 'Telefon') !!}
                                        {!! Form::text('phone', null, ['class' => 'form-control' ]) !!}

                                        {!! Form::label('email', 'E-post') !!}
                                        {!! Form::email('email', null, ['class' => 'form-control' ]) !!}

                                        {!! Form::label('birthDate', 'Født') !!}
                                        <input class="form-control" name="birthDate" placeholder="dd.mm.yyyy" value="{{ $member->birthDate->format('d.m.Y') }}" id="birthDate">

                                        {!! Form::label('department', 'Fakultet') !!}
                                        {!! Form::select('department', $selectDepartment, null, ['class' => 'form-control']) !!}

                                        {!! Form::label('semesters', 'Semestere') !!}
                                        {!! Form::select('semesters', array('1' => '1', '2' => '2'), null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <br/>
                                    <div class="text-left"><img src='{{ URL::to('members/picture/show') }}/{{ $member->id }}' align='center' border='0' width='200'></div>
                                    <button type="submit" name="rotateLeft" value="-90" class="btn btn-default btn-circle">
                                        <i class="fa fa-rotate-left"></i>
                                    </button> Roter bilde
                                    <button type="submit" name="rotateRight" value="90" class="btn btn-default btn-circle">
                                        <i class="fa fa-rotate-right"></i>
                                    </button>
                                    <br/>
                                        {!! Form::label('picture','Nytt bilde') !!}
                                        {!! Form::file('picture', null, ['class' => 'form-control']) !!}
                                    <br>
                                    <button type="submit" name="updateMemberProfile" class="btn btn-success btn-md">Lagre</button>
                                    <button type="reset" class="btn btn-default btn-md">Nullstill</button>
                                </div>
                                {!! Form::close() !!}
                            </div>

                            <div class="tab-pane fade" id="sms">
								<div class="col-lg-8">
									<div class="form-group">
										{!! Form::model($member, array('route' => array('sms.send'), 'method' => 'post', 'id' => 'form-send-sms')) !!}

										{!! Form::label('name', 'Til') !!}
										{!! Form::text('name', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
										{!! Form::number('phone', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}

										{!! Form::hidden('phone[]', null, ['id' => 'number']) !!}

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
							</div>


                            <div class="tab-pane fade" id="settings">
                                <div class="col-lg-8">
                                    <br/>
                                    <form role="form" method="POST" action="{{ URL::to('members/update/settings') }}/{{ $member->id }}" id="memberSettings" accept-charset="UTF-8">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="form-group">
                                            <!--
                                            <label>Kortnummer</label>
                                            <input class="form-control" name="cardNumber" value="{{ $member->cardNumber }}">
                                            -->
                                            <label>VIP-gruppe</label>
                                                {!! Form::select('vipGroup', $selectVipGroup, $member->vipGroup, ['class' => 'form-control']) !!}
                                            <br/>
                                            <dl class="dl-horizontal">
                                                <dt>U20 kontrakt:</dt>
                                                <dd>
                                                    <input name='u20' type='hidden' value='0'>
                                                    {!! Form::checkbox('u20', '1', $member->u20) !!} Signert
                                                </dd>
                                                <br />
                                                <dt>Ønsker ikke:</dt>
                                                <dd>
                                                    <label class="checkbox-inline">
                                                        <input name='noEmail' type='hidden' value='0'>
                                                        {!! Form::checkbox('noEmail', '1', $member->noEmail) !!} Epost
                                                    </label>
                                                    <label class="checkbox-inline">
                                                        <input name='noPhone' type='hidden' value='0'>
                                                        {!! Form::checkbox('noPhone', '1', $member->noPhone) !!} SMS
                                                    </label>
                                                </dd>
												<br/>
												<dt>Utestengt: </dt>
												<dd>
                                                    <input name='banned' type='hidden' value='0'>
                                                    {!! Form::checkbox('banned', '1', $banned, ['id' => 'banned']) !!}
													<br/>
                                                    {!! Form::label('banned_from', 'Fra') !!}
                                                    {!! Form::text('banned_from', $banned_from, ['class' => 'form-control', 'placeholder' => 'dd.mm.yyyy']) !!}
                                                    {!! Form::label('banned_to', 'Til') !!}
                                                    {!! Form::text('banned_to', $banned_to, ['class' => 'form-control', 'placeholder' => 'dd.mm.yyyy']) !!}
                                                </dd>
											</dl>										
                                        </div>
                                        <br/>
                                        <button type="submit" class="btn btn-success btn-md">Lagre</button>
                                        <button type="reset" class="btn btn-default btn-md">Nullstill</button>
                                    </form>
                                    <br/>
                                    <!-- Button trigger modal -->
                                    <button class="btn btn-danger btn-md" data-toggle="modal" data-target="#myModal">
                                        Slett medlem
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title" id="myModalLabel">Slett medlem?</h4>
                                                </div>
                                                <div class="modal-body">
                                                    Er du sikker på at du vil slette medlemmet? Dette kan ikke gjøres om på!
                                                </div>
                                                <div class="modal-footer">
                                                    <form role="form" method="POST" action="{{ URL::to('members/delete') }}/{{ $member->id }}" id="memberDelete" accept-charset="UTF-8">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Avbryt</button>
                                                        <button type="submit" class="btn btn-danger">Slett medlem!</button>
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->
                                </div>
                                <div class="col-lg-4">
                                    <br/>
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
<script>
$(document).ready(function() {
    @if ($banned == 1)
        $('#banned_from').prop('disabled', false);
        $('#banned_to').prop('disabled', false);
    @elseif ($banned == 0)
        $('#banned_from').prop('disabled', true);
        $('#banned_to').prop('disabled', true);
    @endif
	
    $('#banned').change(function(){        
        if(this.checked){
            $('#banned_from').prop("disabled", false);
            $('#banned_to').prop("disabled", false);
        } else {
            $('#banned_from').prop("disabled", true);
            $('#banned_to').prop("disabled", true);			
        }
    });
});
</script>
        <!-- SMS -->
{!! HTML::script('js/sms/single_sms.js') !!}
        <!-- SMS character counting -->
{!! HTML::script('js/sms/char_count.js') !!}


@endsection