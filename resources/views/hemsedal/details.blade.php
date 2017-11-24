@extends('layouts.master')

@section('title', 'Dashboard')

@section('header')

@endsection

@section('sidebar')
    @parent
@endsection

@section('content')

@include('errors.errors')
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Detaljer - Hemsedal</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
 <!-- /.row -->

            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-info">Påmeldte</h4>
                    <dl class="dl-horizontal">
                        <dt>Reserverte plasser :</dt>
                        <dd>{{ $hemsedalAllPayed + $hemsedalOnlyDep }}</dd>
                        <dt>Totalt påmeldt :</dt>
                        <dd>{{ $numberOfHemsedal }}</dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt class="text-success">Alt betalt :</dt>
                            <dd class="text-success">{{ $hemsedalAllPayed }}</dd>
                        <dt class="text-warning">Kun depositum :</dt>
                            <dd class="text-warning">{{ $hemsedalOnlyDep }}</dd>
                        <dt class="text-danger">Ingenting betalt :</dt>
                            <dd class="text-danger">{{ $hemsedalNothing }}</dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt>Medlem :</dt>
                        <dd>{{ ($hemsedalAllPayed + $hemsedalOnlyDep) - $hemsedalNonMembers }}</dd>
                        <dt>Ikke medlem :</dt>
                        <dd>{{ $hemsedalNonMembers }}</dd>
                    </dl>
                    <i>Alle påmeldte medlemer må ha medlemsnummer registrert!</i>
                </div>
                <div class="col-md-6">
                    <h4 class="text-info">Gensere (alt betalt)</h4>
                    <dl class="dl-horizontal">
                        @foreach($sweaterSizesNotDep as $sweater)
                            <dt>{{ $sweater->sweaterSize }} :</dt>
                            <dd>{{ $sweater->count }}</dd>
                        @endforeach
                    </dl>
                    <h4 class="text-info">Gensere (depositum + alt betalt)</h4>
                    <dl class="dl-horizontal">
                        @foreach($sweaterSizesAll as $sweater)
                            <dt>{{ $sweater->sweaterSize }} :</dt>
                            <dd>{{ $sweater->count }}</dd>
                        @endforeach
                    </dl>
                </div>
            </div>
            <!-- /.row -->
@endsection

@section('footer')

@endsection
