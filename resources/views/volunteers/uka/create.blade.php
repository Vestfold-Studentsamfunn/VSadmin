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
        <h1 class="page-header">Registrer frivillig til UKA</h1>
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
                            {!! Form::model($ukaVolunteer, array('route' => array('uka.store'), 'files' => false)) !!}

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