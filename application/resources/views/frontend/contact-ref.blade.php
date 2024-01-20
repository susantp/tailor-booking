<p>Bread Crumbs byb.</p>
{!! display_breadcrumb_front($breadcrumb, url('')) !!}
<h1>Contact Us Byb!</h1>

<ul>
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</ul>

{!! Form::open(array('route' => 'home', 'class' => "form-horizontal form-bordered user_form",'id' => "formID")) !!}

<div class="form-group">
    {!! Form::label('Your Name') !!}
    {!! Form::text('name', 'bkesh', 
    array('required', 
    'class'=>'form-control', 
    'placeholder'=>'Your name')) !!}
</div>
<div class="form-group">
    {!! Form::label('Your image') !!}
    {!! Form::file('bkeshss', Request::old('image'), ['class'=>'this si aldj', 'required'])!!}
</div>

<div class="form-group">
    {!! Form::label('Your E-mail Address') !!}
    {!! Form::text('email', 'test@test.com', 
    array('required', 
    'class'=>'form-control', 
    'placeholder'=>'Your e-mail address')) !!}
</div>

<div class="form-group">
    {!! Form::label('Your Message') !!}
    {!! Form::textarea('message', 'hello boss', 
    array('required', 
    'class'=>'form-control', 
    'placeholder'=>'Your message')) !!}
</div>

<div class="form-group">
    {!! Form::submit('Contact Us!', 
    array('class'=>'btn btn-primary')) !!}
</div>
{!! Form::close() !!}