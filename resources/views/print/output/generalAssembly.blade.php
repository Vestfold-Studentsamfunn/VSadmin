@extends('layouts.master')

@section('title')
    {{ $list->get('title') }} {{ $list->get('year') }}
@endsection

@section('description')
    Betaling registrert før {{ $list->get('limit') }}
@endsection

@section('header')
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                                <div class="table-responsive table-bordered">
                                    <table class="table print-friendly">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Navn</th>
                                            <th><div class="text-center">Stemmeseddel</div></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $member)
                                            <tr>
                                                <td>{{ $member->id }}</td>
                                                <td>{{ $member->name }}</td>
                                                <td>&nbsp;</td>
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