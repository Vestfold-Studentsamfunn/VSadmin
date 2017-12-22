@extends('layouts.master')

@section('title', 'Dashboard')

@section('description', '')

@section('header')
@endsection

@section('content')

@include('errors.errors')

<!-- Small boxes -->
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ $numberOfMembers }}</h3>

                <p>Medlemmer</p>
            </div>
            <div class="icon">
                <i class="fa fa-users"></i>
            </div>
            <a href="{{ Route('members.details') }}" class="small-box-footer">Mer info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-blue">
            <div class="inner">
                <h3>{{ $numberOfVolunteers }}</h3>

                <p>Frivillige</p>
            </div>
            <div class="icon">
                <i class="fa fa-heart"></i>
            </div>
            <a href="#" class="small-box-footer">Mer info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{ $numberOfHemsedal }}</h3>

                <p>Skitur</p>
            </div>
            <div class="icon">
                <i class="fa fa-snowflake-o"></i>
            </div>
            <a href="{{ Route('hemsedal.details') }}" class="small-box-footer">Mer info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ $numberOfCards }}</h3>

                <p>Kort</p>
            </div>
            <div class="icon">
                <i class="fa fa-id-card"></i>
            </div>
            <a href="#" class="small-box-footer">Mer info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<!-- /.row -->
<!-- /Small boxes -->

<div class="row">
    @if (Session::has('message'))
        <div class="alert alert-success {{Session::has('message_important') ? 'alert-important' : ''}}">
            @if (Session::has('message_important'))
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            @endif
            {{ Session::get('message') }}
        </div>
    @endif
    <div class="col-xs-12">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Nyeste ubetalte medlemmer</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="unpaidMembers" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th class="text-right">#</th>
                        <th>Navn</th>
                        <th>Fakultet</th>
                        <th class="text-right">Innmeldt</th>
                        <th class="text-center">Registrer betaling</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($unpaidMembers as $unpaidMember)
                        {{-- only show members who was created less than three months ago --}}
                        @if (($unpaidMember->created_at->diffInMonths() < 3))
                            <tr>
                                <td class="text-right">{{ $unpaidMember['id'] }}</td>
                                <td>{{ $unpaidMember['name'] }}</td>
                                <td>{{ $unpaidMember['department'] }}</td>
                                <td class="text-right">{{ $unpaidMember->created_at->format('d.m.Y') }}</td>
                                <td class="text-center">
                                    {!! Form::open(['route' => ['members.updatePayment', 'id' => $unpaidMember->id], 'files' => false]) !!}
                                        {!! Form::submit($unpaidMember->semesters .' semester(e)', ['name'=>'registerPayment', 'class'=>'btn btn-success btn-sm btn-flat']) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- ./box-body -->
        </div>
        <!-- ./box -->
    </div>
    <!-- ./col -->
</div>
<!-- /.row -->
@endsection

@section('footer')
@endsection


