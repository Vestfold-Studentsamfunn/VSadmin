@extends('layouts.master')

@section('title', 'Quizmaster')

@section('header')

@stop

@section('sidebar')
    @parent
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Registrer Quizmaster</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        @include('errors.errors')
                        @include('flash::message')
                        <div class="col-md-12">
                            {!! Form::model($quizmaster, array('route' => array('quiz.store'), 'files' => false)) !!}

                            {!! Form::label('name_q1', 'Navn') !!}
                            {!! Form::text('name_q1', null, ['class' => 'form-control' ]) !!}

                            {!! Form::label('phone_q1', 'Telefon') !!}
                            {!! Form::text('phone_q1', null, ['class' => 'form-control' ]) !!}

                            {!! Form::label('email_q1', 'Epost') !!}
                            {!! Form::email('email_q1', null, ['class' => 'form-control' ]) !!}
                            <hr>
                            {!! Form::label('name_q2', 'Navn') !!}
                            {!! Form::text('name_q2', null, ['class' => 'form-control' ]) !!}

                            {!! Form::label('phone_q2', 'Telefon') !!}
                            {!! Form::text('phone_q2', null, ['class' => 'form-control' ]) !!}

                            {!! Form::label('email_q2', 'Epost') !!}
                            {!! Form::email('email_q2', null, ['class' => 'form-control' ]) !!}
                            <br>
                            <br>
                            {!! Form::submit('Lagre', ['name'=>'storeQuizmaster', 'class'=>'btn btn-success btn-md']) !!}
                            {!! Form::button('Nullstill', ['type'=>'reset', 'class'=>'btn btn-default btn-md']) !!}

                            {!! Form::close() !!}
                        </div>
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

@endsection