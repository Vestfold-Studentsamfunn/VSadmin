@extends('layouts.master')

@section('title') Logg @stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-list"></i> Aktivitet</h1>
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
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <ul>
                            @foreach ($latestActivities as $activity)
                                <li>
                                    <code>
                                    {{ $activity->created_at->format('d.m.Y H:i:s') }} -
                                    {{ $activity->text }} -
                                    {{ $activity->ip_address }}
                                    </code>
                                </li>
                            @endforeach
                            </ul>
                        </div>

                        {!! Form::open(array('url' => '/settings/activity', 'method' => 'DELETE')) !!}
                        {!! Form::submit('Slett loggføringer eldre enn 3 mnd', ['class' => 'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop