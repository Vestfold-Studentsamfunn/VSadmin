@extends('layouts.master')

@section('title', 'Medlemmer')

@section('header')
<!-- Timeline CSS -->
{!! HTML::style('bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css') !!}

<!-- Morris Charts CSS -->
{!! HTML::style('bower_components/datatables-responsive/css/dataTables.responsive.css') !!}
@stop

@section('sidebar')
    @parent
@endsection

@section('content')
            <div class="row">
                <div class="col-lg-12">
                    @include('errors.errors')
                    @if (Session::has('message'))
                        <div class="alert alert-success {{Session::has('message_important') ? 'alert-important' : ''}}">
                            @if (Session::has('message_important'))
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            @endif
                            {{ Session::get('message') }}
                        </div>
                    @endif
                    <h1 class="page-header">Telefonnummer</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            {{ $volunteers->count() }} telefonnummer funnet.
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            @foreach ($volunteers as $volunteer)
                                {{ $volunteer->phone }} - {{ $volunteer->name }}<br/>
                            @endforeach
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