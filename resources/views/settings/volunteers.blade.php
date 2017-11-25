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
                    <div class="col-lg-8">
                        @include('errors.errors')
                        @if (Session::has('message'))
                            <div class="alert alert-success {{Session::has('message_important') ? 'alert-important' : ''}}">
                                @if (Session::has('message_important'))
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                @endif
                                {{ Session::get('message') }}
                            </div>
                        @endif
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#jobs" data-toggle="tab">Jobber</a>
                            </li>
                            <li><a href="#reset" data-toggle="tab">Nullstill</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="jobs">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <h4>Oppdater</h4>
                                        <div class="col-lg-12">
                                        <div class="row">
                                            <form role="form" method="POST" action="{{ URL::to('settings/volunteers/update') }}" name="updateVolunteersJobs" accept-charset="UTF-8">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="_form" value="updateJob">
                                                    <div class="form-group">
                                                        <label>Jobb</label>
                                                        {!! Form::select('selectedVolunteerJob', $selectVolunteerJob, null, ['class' => 'form-control', 'id' => 'updateVolunteerJob']) !!}

                                                        <label>Navn</label>
                                                        <input class="form-control" id="jobName" name="updateJobName" value="">
                                                    </div>
                                                        <button type="submit" name="updateVolunteersJobs" class="btn btn-success btn-md">Oppdater</button>
                                                        <button type="reset" class="btn btn-default btn-md">Angre</button>
                                            </form>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <h4>Legg til</h4>
                                        <div class="col-lg-12">
                                        <div class="row">
                                            <form role="form" method="POST" action="{{ URL::to('settings/volunteers/add') }}" name="addVolunteerJob" accept-charset="UTF-8">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="_form" value="addJob">
                                                    <div class="form-group">
                                                        <label>Navn</label>
                                                        <input class="form-control" id="addVolunteerJobName" name="addVolunteerJobName" value="">
                                                    </div>
                                                    <button type="submit" name="addVolunteersJobs" class="btn btn-success btn-md">Legg til</button>
                                                    <button type="reset" class="btn btn-default btn-md">Angre</button>
                                            </form>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <h4>Slett</h4>
                                        <div class="col-lg-12">
                                        <div class="row">
                                            <form role="form" method="POST" action="{{ URL::to('settings/volunteers/delete') }}" name="deleteVolunteersJobs" accept-charset="UTF-8">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="_form" value="deleteJob">
                                                    <div class="form-group">
                                                        <label>Jobb</label>
                                                        {!! Form::select('deleteVolunteerJob', $selectVolunteerJob, null, ['class' => 'form-control', 'id' => 'deleteVolunteerJob']) !!}
                                                    </div>
                                                    <button type="submit" class="btn btn-danger">Slett</button>
                                            </form>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="reset">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <h4>Nullstill</h4>
                                            <div class="row">
                                                <form role="form" method="POST" action="{{ URL::to('settings/volunteers/update') }}" name="cleanVolunteers" accept-charset="UTF-8">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="_form" value="updateStatus">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" name="clean" value="volunteers">Fjern frivillige registrert før {{ $cleanDate }}
                                                                </label>
                                                            </div>
                                                            <button type="submit" name="createList" id="createList" class="btn btn-danger btn-md" disabled>Nullstill</button>
                                                            <button type="reset" class="btn btn-default btn-md">Angre</button>
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