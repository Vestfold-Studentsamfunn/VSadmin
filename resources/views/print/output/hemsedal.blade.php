@extends('layouts.master')

@section('title', 'Hemsedal')

@section('header')

@endsection

@section('sidebar')
    @parent
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="text-center">
                <h2 class="page-header">{{ $list->get('page-header') }} - Hemsedal</h2>
                Totalt {{ $data->count() }} stykker.
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                                <div class="table-responsive table-bordered">
                                    <table class="table print-friendly">
                                        <thead>
                                        <tr>
                                            <th>Navn</th>
                                            <th><div class="text-center">Telefon</div></th>
                                            <th><div class="text-center">Genser</div></th>
                                            <th><div class="text-center">Romønske</div></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $participant)
                                            <tr>
                                                <td>{{ $participant->name }}</td>
                                                <td><div class="text-center">{{ $participant->phone }}</div></td>
                                                <td><div class="text-center">{{ $participant->sweaterSize }}</div></td>
                                                <td>{{ $participant->room}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
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