@extends('layouts.master')

@section('title', 'Dashboard')

@section('header')
        <!-- Timeline CSS -->
{!! HTML::style('dist/css/timeline.css') !!}

        <!-- Morris Charts CSS -->
{!! HTML::style('bower_components/morrisjs/morris.css') !!}
@endsection

@section('sidebar')
    @parent
@endsection

@section('content')

    @include('errors.errors')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</h1>
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
                    Rediger informasjon
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="col-lg-8">
                        {!! Form::Model($user, array('route' => array('auth.profile'))) !!}
                        <div class="form-group">
                            {!! Form::label('first_name', 'Fornavn') !!}
                            {!! Form::text('first_name', null , ['class' => 'form-control']) !!}

                            {!! Form::label('last_name', 'Etternavn') !!}
                            {!! Form::text('last_name', null , ['class' => 'form-control']) !!}

                            {!! Form::label('email', 'Epost') !!}
                            {!! Form::text('email', null , ['class' => 'form-control']) !!}

                            <label for="password">Passord</label>
                            <input type="password" class="form-control" name="password">

                            <label for="password_confirmation">Bekreft passordet</label>
                            <input type="password" class="form-control" name="password_confirmation">

                            <br>

                            <button type="submit" class="btn btn-primary">Oppdater</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection