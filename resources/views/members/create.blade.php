@extends('layouts.master')

@section('title', 'Registrer medlem')

@section('description', '')

@section('header')

@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <!-- form start -->
            {!! Form::model($member, ['route' => ['members.store'], 'files' => true, 'class' => 'form-horizontal']) !!}
                <div class="box-body">
                    <div class="col-lg-8">
                        @include('errors.errors')
                        @include('flash::message')
                        <div class="box-body">
                            <div class="form-group">
                                {!! Form::label('name', 'Navn') !!}
                                {!! Form::text('name', null, ['class' => 'form-control' ]) !!}

                                {!! Form::label('address', 'Adresse') !!}
                                {!! Form::text('address', null, ['class' => 'form-control' ]) !!}
                                <div class="row">
                                    <div class="col-xs-2">
                                        {!! Form::label('postalCode', 'Postnummer') !!}
                                        {!! Form::text('postalCode', null, ['class' => 'form-control', 'onkeyup' => 'getPostalArea(this)']) !!}
                                    </div>
                                    <div class="col-xs-10">
                                        {!! Form::label('postalArea', 'Poststed') !!}
                                        {!! Form::text('postalArea', null, ['class' => 'form-control' ]) !!}
                                    </div>
                                </div>
                                {!! Form::label('phone', 'Telefon') !!}
                                {!! Form::text('phone', null, ['class' => 'form-control' ]) !!}

                                {!! Form::label('email', 'E-post') !!}
                                {!! Form::email('email', null, ['class' => 'form-control' ]) !!}

                                {!! Form::label('birthDate', 'Født') !!}
                                <input class="form-control" name="birthDate" placeholder="dd.mm.yyyy" id="birthDate" data-inputmask="'alias': 'dd.mm.yyyy'" data-mask>

                                {!! Form::label('department', 'Fakultet') !!}
                                {!! Form::select('department', $selectDepartment, null, ['class' => 'form-control']) !!}

                                {!! Form::label('semesters', 'Semestere') !!}
                                {!! Form::select('semesters', array('1' => '1', '2' => '2'), 2, ['class' => 'form-control']) !!}

                                {!! Form::label('picture','Nytt bilde') !!}
                                {!! Form::file('picture') !!}
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            {!! Form::submit('Lagre', ['name'=>'storeMember', 'class'=>'btn btn-success btn-md']) !!}
                            {!! Form::button('Nullstill', ['type'=>'reset', 'class'=>'btn btn-default btn-md']) !!}
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!-- /.col-lg-8 (nested) -->
                </div>
                <!-- /.box-body -->
            {!! Form::close() !!}
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
@endsection

@section('footer')
<!-- InputMask -->
<script src="{{ asset("/plugins/input-mask/jquery.inputmask.js") }}"></script>
<script src="{{ asset("/plugins/input-mask/jquery.inputmask.date.extensions.js") }}"></script>
<script src="{{ asset("/plugins/input-mask/jquery.inputmask.extensions.js") }}"></script>
<script type="text/javascript">
    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd.mm.yyyy', { 'placeholder': 'dd.mm.yyyy' });
    //Money Euro
    $('[data-mask]').inputmask();

    function getPostalArea(e) {
        var zipCode = e.value;
        $.ajax({
            url: 'https://api.bring.com/shippingguide/api/postalCode.json?clientUrl=https://hovedstyret.studentsamfunnet.no&pnr=' + zipCode,
            dataType: 'JSON',

            success: function (data) {
                $('#postalArea').val(data.result);
            }
        });
    }
</script>

@endsection