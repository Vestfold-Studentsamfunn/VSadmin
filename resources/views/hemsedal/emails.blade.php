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
                    <h1 class="page-header">Eposter</h1>
                    @include('errors.errors')
                    @include('flash::message')
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            {{ $participants->count() }} eposter funnet.
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            @foreach ($participants as $participant)
                                {{ $participant->email }};
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