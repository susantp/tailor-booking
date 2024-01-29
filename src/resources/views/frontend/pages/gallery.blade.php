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
                                <h2>Gallery</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- hero section ends -->
        <div class="section section-gallery">
            <div class="container">
                <div class="row">
                    @forelse ($images as $value)
                        <div class="col-sm-4 col-lg-4 col-xl-3">
                            <div class="gallery__wrap">
                                <figure style="background-image: url('{{asset('assets/')}}/{{$value->image}}');">
                                    <a data-fancybox="images" data-caption="{{$value->title}}" href="{{asset('assets/')}}/{{$value->image}}"></a>
                                </figure>
                            </div>
                        </div>
                    @empty
                        <p>No Images found.</p>
                    @endforelse
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
