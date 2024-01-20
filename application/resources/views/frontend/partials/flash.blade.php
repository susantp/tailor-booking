@if (count($errors) > 0)
<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    @foreach ($errors->all() as $error)
    {{ $error }}<br/>
    @endforeach
</div>
@endif
@if (Session::has('message'))
<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>
        <i class="fa fa-times-circle fa-lg fa-fw"></i> Error,
    </strong>
    {!! Session::get('message') !!}
</div>
@endif

@if (Session::has('success'))
<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>
        <i class="fa fa-check-circle fa-lg fa-fw"></i> Success,
    </strong>
    {!! Session::get('success') !!}
</div>
@endif