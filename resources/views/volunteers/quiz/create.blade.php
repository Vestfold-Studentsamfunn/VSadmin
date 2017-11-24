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
        <h1 class="page-header">Registrer frivillig</h1>
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
                                <form role="form" method="POST" action="{{ URL::to('volunteers/create') }}" name="volunteerSearch" accept-charset="UTF-8"">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label>Medlemsnummer</label>
                                    <div class="input-group">
                                        {!! Form::number('memberID',  $member->id, ['class' => 'form-control', 'id' => 'memberID', 'placeholder' => 'Søk opp medlem'])  !!}
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
                                <form role="form" method="POST" action="{{ URL::to('volunteers/store') }}" name="volunteerStore" accept-charset="UTF-8"">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="memberID" value="{{ $member->id }}">

                                <div class="form-group">
                                    <label>Navn</label>
                                    <input class="form-control" id="name" name="name" value="{{ $member->name }}">
                                    <label>Telefonnummer</label>
                                    <input class="form-control" id="phone" name="phone" value="{{ $member->phone }}">
                                    <label>Epost</label>
                                    <input class="form-control" id="email" name="email" value="{{ $member->email }}">
                                    <br/>
                                    <label>Interessert i:</label>
                                        @foreach ($volunteerJobs->chunk(5) as $chunk)
                                            <div class="row">
                                                @foreach ($chunk as $availableJob)
                                                    <div class="col-sm-3">
                                                        <label class="checkbox-inline">
                                                            {!! Form::checkbox('jobs[]', $availableJob->id, false) !!} {{ $availableJob->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                </div>
                                <button type="submit" class="btn btn-primary">Lagre</button>
                                <button type="reset" class="btn btn-default">Reset</button>
                                </form>
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