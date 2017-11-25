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
                            @include('flash::message')
                            <form role="form" method="POST" action="{{ URL::to('hemsedal/print') }}" name="membersPrint" accept-charset="UTF-8">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" id="list" name="list" value="allPayed" checked>Alt betalt
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" id="list" name="list" value="onlyDepositum">Kun depositum
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" id="list" name="list" value="nothing">Ingenting betalt
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" id="list" name="list" value="everyone">Alle påmeldte
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