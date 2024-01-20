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
                                <h2>{{ucwords($product->name)}}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- hero section ends -->
        <div class="section section-hireSingle">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="single-img">
                            <div class="slider slider-lg">
                                @forelse ($images as $value)
                                    <div class="img-lg">
                                        <div class="enlarge_pane_contain">
                                            <div class="enlarge_pane">
                                                <div class="enlarge">
                                                    <div class="enlarge_contain">
                                                        <img src="{{asset('assets/')}}/{{$value->image}}"
                                                             srcset="{{asset('assets/')}}/{{$value->image}} 480w, {{asset('assets/')}}/{{$value->image}} 1200w, {{asset('assets/')}}/{{$value->image}} 2000w"
                                                             sizes="100vw" alt="" id="test-img">
                                                    </div>
                                                    <a href="{{asset('assets/')}}/{{$value->image}}" class="enlarge_btn"
                                                       title="Toggle Zoom">Toggle Zoom</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p>No Images Found.</p>
                                @endforelse
                            </div>
                            <!-- THUMBNAILS -->
                            <div class="slider-thumb">
                                @forelse ($images as $value)
                                    <div class=img-thumb>
                                        <img src="{{asset('assets/')}}/{{$value->image}}" alt="{{$value->title}}">
                                    </div>
                                @empty
                                    <p>No Images Found.</p>
                                @endforelse
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="single-content">
                            <h2>{{ucwords($product->name)}}</h2>
                            {!!$product->long_description!!}
                        </div>
                        <div class="book-now-wrap">
                            <div class="button-wrap">
                                <a href="https://www.scottfergusonformalwear.com.au/booking" class="btn btn-blue">Book Now</a>
                            </div>
                            <div class="social-share">
                                <ul>
                                    <li><i class="fa fa-share-alt" aria-hidden="true"></i>Share:</li>
                                    <li><a href="{{ $settings->facebook }}"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="{{ $settings->twitter }}"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="{{ $settings->pinterest }}"><i class="fa fa-pinterest"></i></a></li>
                                </ul>
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
        }(document, 'script', 'facebook-jssdk'));
    </script>
@endpush

@push('links')
@endpush
