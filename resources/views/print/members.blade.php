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
            <h1 class="page-header">Skriv ut liste</h1>
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
                            @if (Session::has('message'))
                                <div class="alert alert-success {{Session::has('message_important') ? 'alert-important' : ''}}">
                                    @if (Session::has('message_important'))
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    @endif
                                    {{ Session::get('message') }}
                                </div>
                            @endif
                            <form role="form" method="POST" action="{{ URL::to('members/print') }}" name="membersPrint" accept-charset="UTF-8">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="col-md-8">
                                    <div class="form-group">

                                        <div class="radio">
                                            <label>
                                                <input type="radio" id="list" name="list" value="U20" checked>U20 (signerte kontrakter)
                                            </label>
                                        </div>

                                        <div class="radio">
                                            <label>
                                                <input type="radio" id="list" name="list" value="GeneralAssembly">Stemmeberettigede generalforsamling
                                            </label>
                                        </div>
                                    <button type="submit" name="createList" id="createList" class="btn btn-success btn-md">Lag liste</button>
                                    </div>
                                </div>
                            </form>
                                <div class="col-md-4">
                                    <br/>
                                </div>
                        </div>
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