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

                                <h2>{{ucwords($content->name)}}</h2>
                                <!-- <a href="#" class="btn btn-hero" >Book Bow</a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- hero section ends -->
        <div class="section section-about">
            <div class="container">
                <?php echo str_replace('../../../assets',url('/').'/assets',$content->description)?>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
@endpush

@push('links')
@endpush
