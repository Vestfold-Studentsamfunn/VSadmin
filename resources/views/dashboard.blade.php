@extends('layouts.master')

@section('title', 'Dashboard')

@section('header')
<!-- Timeline CSS -->
{!! HTML::style('dist/css/timeline.css') !!}

<!-- Morris Charts CSS -->
{!! HTML::style('bower_components/morrisjs/morris.css') !!}
@endsection

@section('sidebar')
    @parent
@endsection

@section('content')

@include('errors.errors')

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            @include('layouts.infoboxes')

            <div class="row">
                @if (Session::has('message'))
                    <div class="alert alert-success {{Session::has('message_important') ? 'alert-important' : ''}}">
                        @if (Session::has('message_important'))
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        @endif
                        {{ Session::get('message') }}
                    </div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Nyeste ubetalte medlemmer
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Navn</th>
                                    <th>Fakultet</th>
                                    <th class="text-center">Innmeldt</th>
                                    <th class="text-center">Registrer betaling</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($unpaidMembers as $unpaidMember)
                                    {{-- show only members who was created less than three months ago --}}
                                    @if (($unpaidMember->created_at->diffInMonths() < 3))
                                        <tr>
                                            <td class="text-center">{{ $unpaidMember['id'] }}</td>
                                            <td>{{ $unpaidMember['name'] }}</td>
                                            <td>{{ $unpaidMember['department'] }}</td>
                                            <td class="text-center">{{ $unpaidMember->created_at->format('d.m.Y') }}</td>
                                            <td class="text-center">
                                                <form role="form" method="POST" action="{{ URL::to('members/update/payment') }}/{{ $unpaidMember->id }}" name="memberPaymentAndCard" accept-charset="UTF-8">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    @if ($unpaidMember->payed == 0 OR $unpaidMember->payed == 2)
                                                        <input name='registerPayment' type='hidden' value='1'>
                                                        <button type="submit" name="register" class="btn btn-success btn-sm">{{$unpaidMember->semesters}} semester(e)</button>
                                                    @endif
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                    {{-- show only members who was created less than one month ago --}}
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.row -->
@endsection

@section('footer')

@endsection


