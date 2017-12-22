@extends('layouts.master')

@section('title', 'Rediger medlem')

@section('description', '')

@section('header')
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ asset("/plugins/daterangepicker/daterangepicker.css") }}">
<!-- iCheck -->
<link rel="stylesheet" href="{{ asset("/plugins/iCheck/all.css") }}">
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box @if ($banned) box-danger @else box-info @endif">
            <div class="box-header">
                @if ($banned)
                    <div class="callout callout-danger">
                        <h4>UTESTENGT!</h4>
                        <p>{{ $member->name }} er utestengt frem til {{$banned_to}}.</p>
                    </div>
                @endif
                <h3 class="box-title">{{$member->id}} - <b>{{ $member->name }}</b></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-8">
                        @include('errors.errors')
                        @include('flash::message')
                        <div id="showresults"></div>

                        <!-- Custom Tabs -->
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#home" data-toggle="tab">Info</a></li>
                                <li><a href="#profile" data-toggle="tab">Rediger</a></li>
                                <li><a href="#sms" data-toggle="tab">SMS</a></li>
                                <li><a href="#settings" data-toggle="tab">Innstillinger</a></li>
                            </ul>
                            <!-- Nav tabs -->

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="home">
                                    <dl class="dl-horizontal">
                                        <dt>Navn</dt>
                                        <dd>{{ $member->name }}</dd>
                                        @if ($memberAge < 20)
                                            <dt>U20 kontrakt</dt>
                                            @if ($member->u20 == true)
                                                <dd class="text-green">Signert</dd>
                                            @else
                                                <dd class="text-red">Ikke signert</dd>
                                            @endif
                                        @endif
                                        @if ($member->vipGroup != "Ingen")
                                            <dt>VIP</dt>
                                            <dd>{{ $member->vipGroup }}</dd>
                                        @endif
                                        <hr>
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
                                                <input name='registerPayment' type='hidden' value='1'>
                                                <button type="submit" name="register" class="btn btn-success btn-lg btn-block">Registrer betaling for {{$member->semesters}} semestere</button>
                                            @elseif ($member->payed == -1)
                                                <input name='printNewCard' type='hidden' value='1'>
                                                <button type="submit" name="print" class="btn btn-warning btn-lg btn-block">Skriv ut nytt kort</button>
                                            @endif
                                        </form>
                                    </div>
                                </div>


                                <div class="tab-pane fade" id="profile">
                                    {!! Form::model($member, array('route' => array('members.update', 'id' => $member->id), 'files' => true)) !!}
                                    <div class="form-group">
                                        {!! Form::label('name', 'Navn') !!}
                                        {!! Form::text('name', null, ['class' => 'form-control' ]) !!}

                                        {!! Form::label('address', 'Adresse') !!}
                                        {!! Form::text('address', null, ['class' => 'form-control' ]) !!}
                                        <div class="row">
                                            <div class="col-xs-2">
                                                {!! Form::label('postalCode', 'Postnummer') !!}
                                                {!! Form::text('postalCode', null, ['class' => 'form-control', 'onkeyup' => 'getPostalArea(this)']) !!}
                                            </div>
                                            <div class="col-xs-10">
                                                {!! Form::label('postalArea', 'Poststed') !!}
                                                {!! Form::text('postalArea', null, ['class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                        {!! Form::label('phone', 'Telefon') !!}
                                        {!! Form::text('phone', null, ['class' => 'form-control' ]) !!}

                                        {!! Form::label('email', 'E-post') !!}
                                        {!! Form::email('email', null, ['class' => 'form-control' ]) !!}

                                        {!! Form::label('birthDate', 'Født') !!}
                                        <input class="form-control" name="birthDate" placeholder="dd.mm.yyyy" value="{{ $member->birthDate->format('d.m.Y') }}" id="birthDate" data-inputmask="'alias': 'dd.mm.yyyy'" data-mask>

                                        {!! Form::label('department', 'Fakultet') !!}
                                        {!! Form::select('department', $selectDepartment, null, ['class' => 'form-control']) !!}

                                        {!! Form::label('semesters', 'Semestere') !!}
                                        {!! Form::select('semesters', array('1' => '1', '2' => '2'), null, ['class' => 'form-control']) !!}

                                        {!! Form::label('picture','Nytt bilde') !!}
                                        {!! Form::file('picture') !!}

                                        <br>

                                        {!! Form::submit('Lagre', ['name'=>'updateMemberProfile', 'class'=>'btn btn-success btn-md']) !!}
                                        {!! Form::button('Nullstill', ['type'=>'reset', 'class'=>'btn btn-default btn-md']) !!}
                                    </div>
                                    {!! Form::close() !!}
                                </div>

                                <div class="tab-pane fade" id="sms">
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
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane fade" id="settings">
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
                                                {!! Form::checkbox('u20', '1', $member->u20, ['class' => 'minimal-green']) !!} Signert
                                            </dd>

                                            <dt>&nbsp;</dt>
                                            <dd>&nbsp;</dd>

                                            <dt>Ønsker ikke:</dt>
                                            <dd>
                                                    <input name='noEmail' type='hidden' value='0'>
                                                    {!! Form::checkbox('noEmail', '1', $member->noEmail, ['class' => 'minimal-blue']) !!} Epost
                                                <br>
                                                    <input name='noPhone' type='hidden' value='0'>
                                                    {!! Form::checkbox('noPhone', '1', $member->noPhone, ['class' => 'minimal-blue']) !!} SMS
                                            </dd>

                                            <dt>&nbsp;</dt>
                                            <dd>&nbsp;</dd>

                                            <dt>Utestengt:</dt>
                                            <dd>
                                                <input name='banned' type='hidden' value='0'>
                                                {!! Form::checkbox('banned', '1', $banned, ['id' => 'banned', 'class' => 'minimal-red']) !!}
                                                <br/>
                                                <!-- Date and time range -->
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <button type="button" class="btn btn-default pull-right" id="bannedrange">
                                                        <span>
                                                            <i class="fa fa-calendar"></i> Velg varighet
                                                        </span>
                                                        <i class="fa fa-caret-down"></i>
                                                        </button>
                                                        <input name='banned_from' id='banned_from' type='hidden'>
                                                        <input name='banned_to' id='banned_to' type='hidden'>
                                                    </div>
                                                </div>
                                                <!-- /.form group -->
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
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /tab-content -->
                        </div>
                        <!-- /nav-tabs-custom -->
                    </div>
                    <!-- /.col-lg-8 (nested) -->
                    <div class="col-lg-4">
                        <div class="text-center"><img src='{{ Route('members.showImage', $member->id) }}' border='0' width='250'></div>
                    </div>
                    <!-- /.col-lg-4 (nested) -->
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- ./box-body -->
            <div class="box-footer">
                Sist endret: {{ $member->updated_at->format('H:i  d.m.Y') }}
            </div>
        </div>
        <!-- ./box -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
@endsection

@section('footer')
<!-- iCheck -->
<script src="{{ asset("/plugins/iCheck/icheck.min.js") }}"></script>
<!-- moment.js -->
<script src="{{ asset("/plugins/moment/moment.min.js") }}"></script>
<!-- Bootstrap Daterangepicker -->
<script src="{{ asset("/plugins/daterangepicker/daterangepicker.js") }}"></script>
<!-- InputMask -->
<script src="{{ asset("/plugins/input-mask/jquery.inputmask.js") }}"></script>
<script src="{{ asset("/plugins/input-mask/jquery.inputmask.date.extensions.js") }}"></script>
<script src="{{ asset("/plugins/input-mask/jquery.inputmask.extensions.js") }}"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#banned").on("ifChanged", changeDateRange);

        function changeDateRange() {
            if(document.getElementById('banned').checked){
                $('#bannedrange').prop('disabled', false);
            }
            else
            {
                $('#bannedrange').prop('disabled', true);
            }
        }

        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd.mm.yyyy', { 'placeholder': 'dd.mm.yyyy' });
        //Money Euro
        $('[data-mask]').inputmask();

        @if ($banned)
        $('#bannedrange').prop('disabled', false).find('span').html('{{ $banned_from }}' + ' - ' + '{{ $banned_to }}');
        @else
        $('#bannedrange').prop('disabled', true);
        @endif

        moment.locale('nb');         // nb

        //Date range as a button
        $('#bannedrange').daterangepicker(
            {
                @if ($banned)
                startDate: '{{ $banned_from }}',
                endDate: '{{ $banned_to }}',
                @else
                startDate: moment(),
                endDate: moment(),
                @endif

                ranges   : {
                    'Én måned' : [moment(), moment().add(1, 'month')],
                    'Tre måneder': [moment(), moment().add(3, 'month')],
                    'Seks måneder'  : [moment(), moment().add(6, 'month')],
                    'Ett år'  : [moment(), moment().add(1, 'year')]
                },
                locale : {
                    applyLabel: 'Lagre',
                    cancelLabel: 'Avbryt',
                    customRangeLabel: 'Egendefinert'
                }
            },
            function(start, end) {
                $('#bannedrange').find('span').html(start.format('L') + ' - ' + end.format('L'));
                document.getElementById("banned_from").value = start;
                document.getElementById("banned_to").value = end;
            }
        );

        //Minimal green color scheme for iCheck
        $('input[type="checkbox"].minimal-green').iCheck({
            checkboxClass: 'icheckbox_minimal-green'
        });
        //Minimal blue color scheme for iCheck
        $('input[type="checkbox"].minimal-blue').iCheck({
            checkboxClass: 'icheckbox_minimal-blue'
        });
        //Minimal red color scheme for iCheck
        $('input[type="checkbox"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red'
        });
    });

    function getPostalArea(e){
        var zipCode = e.value;
        $.ajax({
            url: 'https://api.bring.com/shippingguide/api/postalCode.json?clientUrl=https://hovedstyret.studentsamfunnet.no&pnr='+ zipCode,
            dataType: 'JSON',

            success: function (data) {
                $('#postalArea').val(data.result);
            }
        });
    }
</script>
<!-- SMS -->
{!! HTML::script('js/sms/single_sms.js') !!}
<!-- SMS character counting -->
{!! HTML::script('js/sms/char_count.js') !!}
@endsection