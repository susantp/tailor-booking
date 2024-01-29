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
                                <h2>{{$displayTitle}}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- hero section ends -->
        <div class="section section-hire">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-lg-3">
                        <div class="hire-sidebar">
                            <div class="hire-menu hire-suit">
                                <h3>{{str_replace('-',' ',$type)}}</h3>
{{--                                <ul>--}}
{{--                                    @forelse ($footerCatListing as $value)--}}
{{--                                        <li><a href="{{url('/')}}{{ $value->type==2?'/hire':'/retail' }}/{{ $value->category_slug }}">{{$value->category_name}}</a></li>--}}
{{--                                    @empty--}}
{{--                                        <p>No Products found.</p>--}}
{{--                                    @endforelse--}}
{{--                                </ul> --}}
                                <ul>
                                    @forelse ($listings as $value)
                                        <li><a href="{{url('/product/')}}/{{$value->slug}}">{{$value->name}}</a></li>
                                    @empty
                                        <p>No Products found.</p>
                                    @endforelse
                                </ul>
                            </div>

                            <div class="hire-menu hire-byBrands">
                                <h3>Search by Brands</h3>
                                <ul>
                                    @forelse ($brand as $value)
                                        <li><a href="{{url('brand')}}/{{ $value->category_slug }}/{{$value->slug}}">{{$value->category_name}}</a></li>
                                    @empty
                                        <p>No Products found.</p>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-9">
                        <div class="hire-right">
                            <div class="hire-info">
                                <h2>{{ucwords($curPage->title)}} </h2>
                                <?php echo str_replace('../../../assets',url('/').'/assets',$curPage->description)?>
                            </div>
                            <div class="hire-tileBlocks">
                                <div class="row">
                                    @forelse ($listings as $value)
                                            <div class="col-md-6 col-lg-4">
                                                <div class="hire-tileWrap">
                                                    <div class="hire-image">
                                                        <a href="{{url('/product/')}}/{{$value->slug}}">
                                                            <img src="{{asset('assets/')}}/{{$value->cover_image}}" alt="{{$value->name}}">
                                                        </a>
                                                    </div>
                                                    <div class="hire-info text-center">
                                                        <h3><a href="{{url('/product/')}}/{{$value->slug}}">{{$value->name}}<br>${{$value->price}}</a></h3>
                                                    </div>
                                                </div>
                                            </div>
                                    @empty
                                        <p>No Products Found.</p>
                                    @endforelse
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

@endpush
@push('links')
<!--<link rel="stylesheet" href="{{asset('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">-->
@endpush
