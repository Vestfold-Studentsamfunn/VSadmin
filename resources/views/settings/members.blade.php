@extends('layouts.master')

@section('title', 'Medlemmer')

@section('header')
    <link href="/css/bootstrap-colorpicker.css" rel="stylesheet">
    {!! HTML::script('//code.jquery.com/jquery-1.10.2.min.js') !!}
    {!! HTML::script('//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js') !!}

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
                        @include('flash::message')

                                <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#faculties" data-toggle="tab">Fakulteter</a>
                                </li>
                                <li><a href="#vip" data-toggle="tab">VIP grupper</a>
                                </li>
                                <li><a href="#reset" data-toggle="tab">Nullstill</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="faculties">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <h4>Oppdater</h4>
                                            <div class="row">
                                                <form role="form" method="POST" action="{{ URL::to('settings/members/update') }}" name="updateMemberFaculty" accept-charset="UTF-8">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="_form" value="updateFaculty">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Fakultet</label>
                                                            {!! Form::select('selectedDepartment', $selectDepartment, null, ['class' => 'form-control', 'id' => 'department']) !!}
                                                        </div>
                                                        <button type="submit" name="updateMembesSettings" class="btn btn-success btn-md">Oppdater</button>
                                                        <button type="reset" class="btn btn-default btn-md">Angre</button>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label>Fullt navn</label>
                                                        <input class="form-control" id="full_name" name="updateDepartmentFullName" value="">
                                                        <label>Forkortelse</label>
                                                        <input class="form-control" id="short_name" name="updateDepartmentShortName" value="">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <h4>Legg til</h4>
                                            <div class="row">
                                                <form role="form" method="POST" action="{{ URL::to('settings/members/add') }}" name="addMemberFaculty" accept-charset="UTF-8">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="_form" value="addFaculty">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label>Fullt navn</label>
                                                            <input class="form-control" id="full_name" name="addDepartmentFullName" value="">
                                                            <label>Forkortelse</label>
                                                            <input class="form-control" id="short_name" name="addDepartmentShortName" value="">
                                                        </div>
                                                        <button type="submit" name="updateMembesSettings" class="btn btn-success btn-md">Legg til</button>
                                                        <button type="reset" class="btn btn-default btn-md">Angre</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <h4>Slett</h4>
                                            <div class="row">
                                                <form role="form" method="POST" action="{{ URL::to('settings/members/delete') }}" name="deleteMemberFaculty" accept-charset="UTF-8">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="_form" value="deleteFaculty">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label>Fakultet</label>
                                                            {!! Form::select('deleteDepartment', $selectDepartment, null, ['class' => 'form-control', 'id' => 'department']) !!}
                                                        </div>
                                                        <button type="submit" class="btn btn-danger">Slett</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="tab-pane fade" id="vip">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <h4>Oppdater</h4>
                                            <div class="row">
                                                <form role="form" method="POST" action="{{ URL::to('settings/member/update') }}" name="updateMemberVipGroup" accept-charset="UTF-8">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="_form" value="updateVipGroup">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label>VIP gruppe</label>
                                                            {!! Form::select('selectedVipGroup', $selectVipGroup, null, ['class' => 'form-control', 'id' => 'selectedVipGroup']) !!}
                                                            <label>Navn</label>
                                                            <input class="form-control" id="vipGroup" name="updateVipGroup" value="">
                                                            <label>Farge</label>
                                                            <div id="demo_endis" class="input-group demo demo-auto colorpicker-component">
                                                                    <input type="text" value="" class="form-control" />
                                                                    <span class="input-group-addon"><i></i></span>
                                                            </div>

                                                        </div>
                                                        <button type="submit" name="updateMemberVipGroup" class="btn btn-success btn-md">Oppdater</button>
                                                        <button type="reset" class="btn btn-default btn-md">Angre</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <h4>Legg til</h4>
                                            <div class="row">
                                                <form role="form" method="POST" action="{{ URL::to('settings/members/add') }}" name="addMemberVipGroup" accept-charset="UTF-8">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="_form" value="addVipGroup">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label>Navn</label>
                                                            <input class="form-control" name="addVipGroup" value="">
                                                        </div>
                                                        <button type="submit" name="addMemberVipGroup" class="btn btn-success btn-md">Legg til</button>
                                                        <button type="reset" class="btn btn-default btn-md">Angre</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <h4>Slett</h4>
                                            <div class="row">
                                                <form role="form" method="POST" action="{{ URL::to('settings/members/delete') }}" name="deleteMemberVipGroup" accept-charset="UTF-8">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="_form" value="deleteVipGroup">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label>VIP gruppe</label>
                                                            {!! Form::select('deleteVipGroup', $selectVipGroup, null, ['class' => 'form-control', 'id' => 'deleteVipGroup']) !!}
                                                        </div>
                                                        <button type="submit" name="deleteMemberVipGroup" id="deleteMemberVipGroup" class="btn btn-danger btn-md">Slett</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="tab-pane fade" id="reset">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <h4>Nullstill</h4>
                                            <div class="row">
                                                <form role="form" method="POST" action="{{ URL::to('settings/members/update') }}" name="updateMemberStatus" accept-charset="UTF-8">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="_form" value="updateStatus">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" name="memberType" value="vip">VIP-statusen til {{ $vip }} medlemmer registrert som VIP
                                                                </label>
                                                            </div>
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" name="memberType" value="allMembers">Betalingen til alle {{ $members }} medlemmer (gjøres senest 01. juli)
                                                                </label>
                                                            </div>
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" name="memberType" value="halfYear">Betalingen til {{ $halfYear }} halvtårsmedlemmer (gjøres senest 31. desember)
                                                                </label>
                                                            </div>
                                                            <button type="submit" name="createList" id="createList" class="btn btn-danger btn-md">Nullstill</button>
                                                            <button type="reset" class="btn btn-default btn-md">Angre</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                <!-- /.row (nested) -->
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
        {!! HTML::script('//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js') !!}
    <script>
    $(function() {

        $('#vipGroup').prop('disabled', true);
        $('#deleteMemberVipGroup').prop('disabled', true);

        $('#department').click(function () {
            var full_name = $("#department").children("option").filter(":selected").text();
            $('#full_name').val(full_name);
            $('#short_name').val(this.value);
        });

        $('#selectedVipGroup').click(function () {
            if ($('#selectedVipGroup').val() == 'Ingen')  {
                $('#vipGroup').val(null).prop('disabled', true);
            } else {
                $('#vipGroup').val(this.value).prop('disabled', false);
            }
        });

        $('#deleteVipGroup').click(function () {
            if ($('#deleteVipGroup').val() == 'Ingen')  {
                $('#deleteMemberVipGroup').prop('disabled', true);
            } else {
                $('#deleteMemberVipGroup').prop('disabled', false);
            }
        });
    });
</script>
        {!! HTML::script('public/js/bootstrap-colorpicker.js') !!}
@endsection