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

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class='fa fa-user'></i> Rediger bruker</h1>
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
                <div class="panel-body">
                    <div class="col-lg-8">
                        {!! Form::model($user, ['role' => 'form', 'url' => '/settings/users/' . $user->id, 'method' => 'PUT']) !!}
                        
						<div class='form-group'>
                            {!! Form::label('email', 'Brukernavn') !!}
                            {!! Form::email('email', null, ['placeholder' => 'Epost', 'class' => 'form-control', ]) !!}
                        </div>
						
                        <div class='form-group'>
                            {!! Form::label('first_name', 'Fornavn') !!}
                            {!! Form::text('first_name', null, ['placeholder' => 'Fornavn', 'class' => 'form-control']) !!}
                        </div>

                        <div class='form-group'>
                            {!! Form::label('last_name', 'Etternavn') !!}
                            {!! Form::text('last_name', null, ['placeholder' => 'Etternavn', 'class' => 'form-control']) !!}
                        </div>

                        <div class='form-group'>
                            {!! Form::label('password', 'Passord') !!}
                            {!! Form::password('password', ['placeholder' => 'Passord', 'class' => 'form-control']) !!}
                        </div>

                        <div class='form-group'>
                            {!! Form::label('password_confirmation', 'Bekreft Passord') !!}
                            {!! Form::password('password_confirmation', ['placeholder' => 'Bekreft Passord', 'class' => 'form-control']) !!}
                        </div>

                        <div class='form-group'>
                            {!! Form::submit('Lagre', ['class' => 'btn btn-primary']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop