@extends('frontend.layouts.master')
@section('content')
<div class="main-wrapper">
    <div class="main">
        <div class="main-inner">
            <div class="content">
                <div id="hero-slider">
                    <div class="hero">	
                        <div class="hero-carousel">
                            @forelse ($banners as $banner)
                            <div class="hero-carousel-item">
                                <div class="hero-image" style="background-image: url({{asset('assets/')}}/{{$banner->image}})"></div>
                                <div class="hero-carousel-title">
                                    <div class="container">
                                        <div class="hero-carousel-title-inner">
                                            <h1>{{$banner->title}}</h1>
                                            <h2{{$banner->content}}</h2>
                                            @if($banner->button_text)
                                                <a href="{{$banner->url}}" target="_blank" class="btn btn-primary map-link-bkesh">{{$banner->button_text}}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>	
                            </div>
                            @empty
                            <p>No Banners found.</p>
                            @endforelse
                        </div>
                        <div class="hero-form dark">
                            <div class="container">
                                <form method="get" action="{{url('/listing/search')}}">
                                    <div class="input-group first col-sm-12 col-md-10">
                                        <div class="input-group-addon">
                                            <i class="md-icon">my_location</i>
                                        </div>
                                        <input id="keywords" autofocusx type="text" name="key" class="form-control" placeholder="e.g. Khumbu">
                                    </div>
                                    <div class="form-group last col-sm-12 col-md-2">
                                        <button type="submit" class="btn btn-primary btn-block">Search</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="page-title">
                        <h2><a href="{{url('/listing')}}">Featured Listings</a></h2>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-xl-10">
                            <div class="cards-wrapper">
                                <div class="row">
                                    @forelse ($listings as $value)
                                    <?php $acc_url = get_accommodation_url($value->name,$value->id, $value->type); ?>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="card">
                                            <div class="card-image" style="background-image: url({{asset('assets/')}}/{{$value->cover_image}});">
                                                <a href="{{url($acc_url)}}"></a> 
                                                <div class="card-image-rating">
                                                    <i class="md-icon" title="Bed">hotel</i>
                                                    <i class="md-icon">restaurant_menu</i>
                                                    <i class="md-icon">home</i>
                                                </div>
                                            </div>
                                            <div class="card-content">
                                                <h2><a href="{{url($acc_url)}}">{{$value->name}}</a></h2>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <p>No Listings found.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 hidden-lg-down">
                            <div class="your-space">
                                <?php
                                if ($advertisement) {
                                    echo show_image($advertisement->image, $advertisement->title, '', 160);
                                } else {
                                    ?>
                                    <p>Do you want to be here?</p>
                                    <a href="javascript:void(0)" class="btn btn-primary btn-block">{{ $settings->phone }}</a>
                                    <a href="{{url('contact-us')}}" class="btn btn-secondary btn-block">Contact Us</a>

                                <?php } ?>
                            </div>
                        </div>	
                    </div>
                </div>
                <div class="container">
                    <div class="page-title background-white">
                        <h2><a href="{{url('/climbers')}}">Featured Climbers</a></h2>
                    </div>
                    <div class="cards-wrapper">
                        <div class="row">
                            @forelse ($climbers as $value)
                            <div class="col-xs-12 col-sm-6 col-lg-3">
                                <div class="card">
                                    <div class="card-image small no-line" style="background-image: url({{asset('assets/')}}/{{$value->climber_image}});">
                                        <a href="{{url('/climbers/')}}/{{$value->slug}}"></a>
                                        <div class="card-image-count">
                                            <strong>{{$value->total_climbs}}</strong>
                                            <span>Climbs</span>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <h2><a href="{{url('/climbers/')}}/{{$value->slug}}">{{$value->name}}</a></h2>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p>No Listings found.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="push-bottom">
                    <div class="container">
                        <div class="page-title">
                            <h2><a href="{{url('/news')}}">Recent News & Events</a></h2>
                        </div>
                        <div class="row">
                            @forelse ($news as $value)
                            <div class="col-sm-12 col-md-4">
                                <div class="card">
                                    <div class="card-image" style="background-image: url({{asset('assets/')}}/{{$value->image}});">
                                        <a href="{{url('/news')}}/{{$value->slug}}"></a>
                                    </div>
                                    <div class="card-content">
                                        <h2><a href="{{url('/news')}}/{{$value->slug}}">{{$value->title}}</a></h2>
                                    </div>
                                    <div class="card-actions">
                                        <a href="#" class="card-action-icon"><i class="md-icon">access_time</i><span> {{date('d. M',strtotime($value->created_at))}}</span></a>
                                        <a href="{{url('/news')}}/{{$value->slug}}" class="card-action-btn btn btn-transparent">Read More</a>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p>No Listings found.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="partners">
                    <div class="container">
                        @forelse ($affiliates as $value)
                        <a href="{{$value->url}}" target="_blank">
                            <img src="{{asset('assets/')}}/{{$value->image}}" alt="" height="74">
                        </a>
                        @empty
                        <p>No Banners found.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')

@endpush
@push('links')
<!--<link rel="stylesheet" href="{{asset('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">-->
@endpush
