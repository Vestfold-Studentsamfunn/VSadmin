@extends('layouts.master')

@section('title', 'U20 Liste')

@section('description', 'Medlemmer under 20 år med signert U20 kontrakt')

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
                                            <th><div class="text-center">Fødselsdato</div></th>
                                            <th><div class="text-center">Utestengt til</div></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $member)
                                            <tr @if($member->isMemberBanned()) bgcolor="#d3d3d3" @endif>
                                                <td>{{ $member->id }}</td>
                                                <td>{{ $member->name }}</td>
                                                <td><div class="text-center">{{ $member->birthDate->format('d.m.Y') }}</div></td>
                                                    <td>
                                                        @if($member->isMemberBanned())
                                                            <div class="text-center"><strong>{{ $member->banned_to->format('d.m.Y') }}</strong></div>
                                                        @endif
                                                    </td>
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