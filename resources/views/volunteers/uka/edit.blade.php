@extends('layouts.master')

@section('title', 'Rediger UKA Frivillig')

@section('header')

@stop

@section('sidebar')
    @parent
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Rediger UKA Frivillig</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ $volunteerUka->name }}
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
                                        {!! Form::model($volunteerUka, array('route' => array('uka.update', 'id' => $volunteerUka->id), 'files' => false)) !!}

                                        {!! Form::label('name', 'Navn') !!}
                                        {!! Form::text('name', null, ['class' => 'form-control' ]) !!}

                                        {!! Form::label('phone', 'Telefon') !!}
                                        {!! Form::text('phone', null, ['class' => 'form-control' ]) !!}

                                        {!! Form::label('email', 'E-post') !!}
                                        {!! Form::email('email', null, ['class' => 'form-control' ]) !!}

                                        {!! Form::label('jobs', 'Jobb') !!}
                                        {!! Form::text('jobs', null, ['class' => 'form-control' ]) !!}
                                        <br>
                                        <br>
                                        {!! Form::submit('Lagre', ['name'=>'updateUkaVolunteer', 'class'=>'btn btn-success btn-md']) !!}
                                        {!! Form::button('Nullstill', ['type'=>'reset', 'class'=>'btn btn-default btn-md']) !!}

                                        {!! Form::close() !!}
                                    </dl>
                                </div>
                            </div>


                            <div class="tab-pane fade" id="settings">
                                <div class="col-lg-8">
                                <br/>
                                    <!-- Button trigger modal -->
                                    <button class="btn btn-danger btn-md" data-toggle="modal" data-target="#myModal">
                                        Fjern UKA Frivillig
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
                                                    {!! Form::open(array('route' => array('uka.delete', 'id' => $volunteerUka->id), 'files' => false)) !!}

                                                    {!! Form::button('Avbryt', ['name'=>'updateUkaVolunteer', 'class'=>'btn btn-default', 'data-dismiss'=>'modal']) !!}
                                                    {!! Form::submit('Fjern frivillig!', ['type'=>'reset', 'class'=>'btn btn-danger']) !!}

                                                    {!! Form::close() !!}
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
            <div class="panel-footer">
                Lagt til: {!! $volunteerUka->created_at->format('d.m.Y') !!}
            </div>
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
@endsection

@section('footer')
@endsection