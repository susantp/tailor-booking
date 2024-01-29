@extends('frontend.layouts.master')
@section('content')
<div class="main-wrapper">
    <div class="main">
        <div class="main-inner">
            <div class="content">
                <div class="content-title">
                    <div class="container">
                        <h1>{{ucwords($climber->name)}}</h1>
                        {!! display_breadcrumb_front($breadcrumb, url('')) !!}
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-lg-9">
                            <div class="push-top-bottom">
                                <div class="listing-detail">
                                     <div class="gallery">
                                        @forelse ($climber->images as $value)
                                        <div class="gallery-item" style="background-image: url({{asset('assets/')}}/{{$value->image}});"> 
                                            <div class="gallery-item-description">
                                                {{$value->title}}
                                            </div>
                                        </div>
                                        @empty
                                        
                                        @endforelse     
                                    </div>
                                    <h2>About</h2>
                                    {!!$climber->long_description!!}
                                    <div class="fb-comments" data-href="{{url('climbers')}}/{{$climber->slug}}" data-numposts="5"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <div class="sidebar">
                                <div class="widget profile">
                                    <img src="{{asset('assets/')}}/{{$climber->climber_image}}" alt="{{$climber->name}}">
                                </div>
                                <div class="widget">
                                    <h2 class="widgettitle">Contact Information</h2>
                                    <ul class="contact">
                                        @if ($climber->email != '')<li><i class="md-icon">email</i> <a href="mailto:{{$climber->email}}">{{$climber->email}}</a></li>@endif
                                        @if ($climber->website != '')<li><i class="md-icon">link</i> <a href="{{$climber->website}}">{{$climber->website}}</a></li>@endif
                                        @if ($climber->phone != '')<li><i class="md-icon">phone</i> {{$climber->phone}}</li>@endif
                                        @if ($climber->mobile != '')<li><i class="md-icon">phone</i> {{$climber->mobile}}</li>@endif
                                        @if ($climber->address != '')<li><i class="md-icon">location_on</i>{{$climber->address}}</li>@endif
                                    </ul>
                                </div>
                                @include('frontend.partials.inquiry_form')
                                @include('frontend.partials.recent_listing')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<div id="fb-root"></div>
<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0&appId=131012340421186&autoLogAppEvents=1';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
@endpush

@push('links')
@endpush
