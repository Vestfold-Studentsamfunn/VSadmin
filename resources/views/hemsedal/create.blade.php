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
        <h1 class="page-header">Ny påmelding</h1>
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
                                <br/>
                                <form role="form" method="POST" action="{{ URL::to('hemsedal/create') }}" name="memberSearch" accept-charset="UTF-8">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label>Medlemsnummer</label>
                                    <div class="input-group">
                                        {!! Form::number('memberID',  $participant->id, ['class' => 'form-control', 'id' => 'memberID', 'placeholder' => 'Søk opp medlem'])  !!}
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="submit"><i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <div class="col-md-12">
                                <br/>
                                {!! Form::model($participant, array('route' => array('hemsedal.store'))) !!}
                                {!! Form::hidden('id', null) !!}

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