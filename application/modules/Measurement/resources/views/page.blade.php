@extends('frontend.layouts.master')
@section('content')
    <div class="site-content">
        <div class="section section-hero">
            <div class="hero__inner">
                <div class="hero-item">
                    <span class="overlay"></span>
                    <img class="img-100" src="{{asset('assets/')}}/{{$page_banner}}" alt="">
                    <div class="container">
                        <div class="hero-wrapper">
                            <div class="hero-inner">
                                <h2>{{$page_title}}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- hero section ends -->
        <div class="section section-contact">
            <div class="container">
                @if(session()->has('success'))
                    <div class="p-2 m-auto bg-success font-weight-bold rounded-sm text-white">
                        {{session()->get('success')}}
                    </div>
                @endif
                <div class="row mt-3">
                    <h3>{{$form_data['title']}}</h3>
                </div>
                <form action="{{url('send-email')}}" method="post">
                    {{csrf_field()}}
                    @foreach($form_data['sections'] as $section)
                        <div class="row mb-2">
                            <h6>{{$section['title']}}</h6>
                        </div>
                        <div class="row">
                            @if($section['title'] == 'Measurement Details')
                                <div class="col-md-6 col-sm-12">
                                    @foreach($section['inputs'] as $input)
                                        <div class='form-group col-sm-12 {{$input["class"]}}'>
                                            <input minlength="1" value="{{old($input['name'])}}" type='{{$input['type']}}'
                                                   name="{{$input['name']}}"
                                                   placeholder="{{$input['label']}}"
                                                   class="form-control"
                                                   required/>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    image
                                </div>
                            @else
                                @foreach($section['inputs'] as $input)
                                    @if(! $input['type'] == 'datetime')
                                        <div class='form-group col-sm-12 {{$input["class"]}}'>
                                            <input type="{{$input['type']}}"
                                                   value="{{old($input['name'])}}"
                                                   name="{{$input['name']}}"
                                                   placeholder="{{$input['label']}}"
                                                   class="form-control"
                                                   minlength="3"
                                                   required/>
                                        </div>
                                    @else
                                        <div class='form-group col-sm-12 {{$input["class"]}}'>
                                            <input type="{{$input['type']}}"
                                                   id="datepicker"
                                                   value="{{old($input['name'])}}"
                                                   name="{{$input['name']}}"
                                                   placeholder="{{$input['label']}}"
                                                   class="form-control"
                                                   minlength="3"
                                                   required/>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    @endforeach
                    <button type="submit" class="btn btn-primary rounded-pill">Send Booking</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <script>

        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4'
        });
    </script>
@endpush

@push('links')
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css"/>
@endpush
