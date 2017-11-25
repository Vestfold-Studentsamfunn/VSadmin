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
        <h1 class="page-header">Registrer medlem</h1>
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
                        <form role="form" method="POST" action="{{ URL::to('members/store') }}" name="memberAdd" accept-charset="UTF-8" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="col-lg-12">
                                <br/>
                            <div class="form-group">
                                <label>Navn</label>
                                <input class="form-control" name="name" value="{{ old('name') }}" autofocus>

                                <label>Adresse</label>
                                <input class="form-control" name="address" value="{{ old('address') }}">

                                <label>Postnummer</label>
                                <input class="form-control" name="postalCode" value="{{ old('postalCode') }}" >

                                <label>Poststed</label>
                                <input class="form-control" name="postalArea" value="{{ old('postalArea') }}" >

                                <label>Telefon</label>
                                <input class="form-control" name="phone" value="{{ old('phone') }}" >

                                <label>E-post</label>
                                <input class="form-control" name="email" type="email" value="{{ old('email') }}" >

                                <label>Født</label>
                                <input class="form-control" name="birthDate" placeholder="dd.mm.yyyy" value="{{ old('birthDate') }}"> <!- dd.mm.yyyy -!>

                                <label>Fakultet</label>
                                {!! Form::select('department', $selectDepartment, null, ['class' => 'form-control']) !!}

                                <label>Semestere</label>
                                <select name="semesters" class="form-control">
                                    <option>1</option>
                                    <option>2</option>
                                </select>
                                {!! Form::label('picture','Bilde',array('id'=>'','class'=>'')) !!}
                                {!! Form::file('picture') !!}
                            </div>
                            <button type="submit" class="btn btn-primary">Lagre</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.col-lg-6 (nested) -->
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

@endsection