@if (count($errors) > 0)
<div class="alert alert-danger alert-dismissable alert-important">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="fa fa-warning fa-2x"></i>&nbsp;
     @foreach ($errors->all() as $error)
		{{ $error }}
     @endforeach
</div>
@endif