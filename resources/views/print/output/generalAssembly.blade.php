@extends('layouts.master')

@section('title', 'Medlemmer')

@section('header')

@endsection

@section('sidebar')
    @parent
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="text-center">
                <h2 class="page-header">{{ $list->get('page-header') }} - {{ $list->get('year') }}</h2>
                {{ $data->count() }} med betaling før {{ $list->get('limit')->format('d.m.Y - H:i') }}
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
                                            <th>ID</th>
                                            <th>Navn</th>
                                            <th><div class="text-center">Innmeldt</div></th>
                                            <th><div class="text-center">Betaling registrert</div></th>
                                            <th><div class="text-center">Stemmeseddel</div></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $member)
                                            <tr>
                                                <td>{{ $member->id }}</td>
                                                <td>{{ $member->name }}</td>
                                                <td><div class="text-center">{{ $member->created_at->format('d.m.Y') }}</div></td>
                                                <td><div class="text-center">{{ $member->payedDate->format('d.m.Y - H:i') }}</div></td>
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