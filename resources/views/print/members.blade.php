@extends('layouts.master')

@section('title', 'Skriv ut medlemslister')

@section('description', '')

@section('header')
@endsection

@section('content')
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
                        <form role="form" method="POST" action="{{ Route('members.print') }}" name="membersPrint" accept-charset="UTF-8">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="typeOfList" value="members">
                            <div class="col-md-8">
                                <div class="form-group">

                                    <div class="radio">
                                        <label>
                                            <input type="radio" id="list" name="nameOfList" value="U20">U20 (signerte kontrakter)
                                        </label>
                                    </div>

                                    <div class="radio">
                                        <label>
                                            <input type="radio" id="list" name="nameOfList" value="GeneralAssembly">Stemmeberettigede generalforsamling
                                        </label>
                                    </div>
                                <button type="submit" name="createList" id="nameOfList" class="btn btn-success btn-md">Lag liste</button>
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