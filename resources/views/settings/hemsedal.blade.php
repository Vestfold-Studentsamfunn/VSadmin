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
        <h1 class="page-header">Innstillinger</h1>
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
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#reset" data-toggle="tab">Nullstill</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="reset">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <h4>Nullstill</h4>
                                        <div class="row">
                                            <form role="form" method="POST" action="{{ URL::to('settings/hemsedal/updateTrip') }}" name="updateMemberStatus" accept-charset="UTF-8">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="_form" value="updateTrip">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="selection" value="removeUnpaid">Fjern {{ $unpaidParticipants }} ubetalte påmeldinger
                                                            </label>
                                                        </div>
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="selection" value="newTrip">Fjern alle {{ $participants }} påmeldte (Ny tur)
                                                            </label>
                                                        </div>
                                                        <button type="submit" name="submit" id="submit" class="btn btn-danger btn-md">Nullstill</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Tab panes -->
                    </div>
                    <!-- /.col-lg-6 -->
                </div>
                <!-- /.row -->
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
    <script>
    $(function() {
        $('#updateVolunteerJob').click(function () {
            var jobName = $("#updateVolunteerJob").children("option").filter(":selected").text();
            $('#jobName').val(jobName);
        });
    });
    </script>
@endsection