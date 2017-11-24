@extends('layouts.master')

@section('title', 'Rediger Quizmaster')

@section('header')

@stop

@section('sidebar')
    @parent
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Rediger Quizmaster</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ $quizmaster->name_q1 }} @if ($quizmaster->name_q1 != '') & {{ $quizmaster->name_q2 }} @endif
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                    @include('errors.errors')
                    @include('flash::message')
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab">Rediger info</a>
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
                                        {!! Form::model($quizmaster, array('route' => array('volunteer.quiz.update', 'id' => $quizmaster->id), 'files' => false)) !!}
                                        {!! Form::label('name_q1', 'Navn') !!}
                                        {!! Form::text('name_q1', null, ['class' => 'form-control' ]) !!}

                                        {!! Form::label('phone_q1', 'Telefon') !!}
                                        {!! Form::text('phone_q1', null, ['class' => 'form-control' ]) !!}

                                        {!! Form::label('email_q1', 'E-post') !!}
                                        {!! Form::email('email_q1', null, ['class' => 'form-control' ]) !!}
                                        <hr>
                                        {!! Form::label('name_q2', 'Navn') !!}
                                        {!! Form::text('name_q2', null, ['class' => 'form-control' ]) !!}

                                        {!! Form::label('phone_q2', 'Telefon') !!}
                                        {!! Form::text('phone_q2', null, ['class' => 'form-control' ]) !!}

                                        {!! Form::label('email_q2', 'E-post') !!}
                                        {!! Form::email('email_q2', null, ['class' => 'form-control' ]) !!}
                                        <br>
                                        <br>
                                        <button type="submit" name="updateQuizmasterProfile" class="btn btn-success btn-md">Lagre</button>
                                        <button type="reset" class="btn btn-default btn-md">Nullstill</button>

                                        {!! Form::close() !!}
                                    </dl>
                                </div>
                            </div>


                            <div class="tab-pane fade" id="settings">
                                <div class="col-lg-8">
                                <br/>
                                    <!-- Button trigger modal -->
                                    <button class="btn btn-danger btn-md" data-toggle="modal" data-target="#myModal">
                                        Fjern quizmaster
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title" id="myModalLabel">Fjern quizmaster?</h4>
                                                </div>
                                                <div class="modal-body">
                                                    Er du sikker på at du vil fjerne quizmasteren? Dette kan ikke gjøres om på!
                                                </div>
                                                <div class="modal-footer">
                                                    <form role="form" method="POST" action="{{ URL::to('volunteers/quiz/delete') }}/{{ $quizmaster->id }}" id="volunteerQuizDelete" accept-charset="UTF-8">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Avbryt</button>
                                                        <button type="submit" class="btn btn-danger">Fjern quizmaster!</button>
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