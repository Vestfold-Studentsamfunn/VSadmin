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
                                    <th>Brukernavn</th>
                                    <th>Roller</th>
                                    <th>Lagt til</th>
                                    <th>Siste innlogging</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->getFullName() }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @foreach ($user->getRoles() as $role)
                                                {{ $role }}
                                            @endforeach
                                        </td>
                                        <td>{{ $user->created_at->format('d. F, Y H:i') }}</td>
                                        <td></td>
                                        <td>
                                            <a href="/settings/users/{{ $user->id }}/edit" class="btn btn-info pull-left btn-sm" style="margin-right: 3px;">Rediger</a>
                                            {!! Form::open(array('url' => '/settings/users/' . $user->id, 'method' => 'DELETE')) !!}
                                            {!! Form::submit('Slett', ['class' => 'btn btn-danger btn-sm']) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <a href="/settings/users/create" class="btn btn-success">Ny bruker</a>
                        <a href="/settings/users/roles" class="btn btn-success">Administrer roller</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop