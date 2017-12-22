@extends('layouts.master')

@section('title', 'E-postliste')

@section('description', 'Alle betalende medlemmer som ikke har reservert seg')

@section('header')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ $members->count() }} eposter funnet.
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                @foreach ($members as $member)
                    {{ $member->email }};
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