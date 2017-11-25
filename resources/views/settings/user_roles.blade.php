@extends('layouts.master')

@section('title') Users @stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-users"></i> Brukere</h1>
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
                            <table class="table table-bordered table-striped">

                                <thead>
                                <tr>
                                    <th>Navn</th>
                                    <th>Beskrivelse</th>
                                    <th>Antall brukere</th>
                                    <th>Lagt til</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->description }}</td>
                                        <td>{{ $role->users->count() }}</td>
                                        <td>{{ $role->created_at->format('d. F, Y H:i') }}</td>
                                        <td>
                                            <a href="/settings/users/roles/{{ $role->id }}/edit" class="btn btn-info pull-left btn-sm" style="margin-right: 3px;">Rediger</a>
                                            {!! Form::open(array('url' => '/settings/users/roles/' . $role->id, 'method' => 'DELETE')) !!}
                                            {!! Form::submit('Slett', ['class' => 'btn btn-danger btn-sm']) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <a href="/settings/users/create" class="btn btn-success">Ny rolle</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop