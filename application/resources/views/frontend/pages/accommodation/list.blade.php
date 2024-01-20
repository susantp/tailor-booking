@extends('frontend.layouts.master')
@section('content')
<div class="main-wrapper">
    <div class="main">
        <div class="main-inner">
            <div class="content-title">
                <div class="container">
                    <h1>Listings</h1>
                    {!! display_breadcrumb_front($breadcrumb, url('')) !!}
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-lg-9">
                        <div class="content">
                            <div class="push-top-bottom">
                                <div class="row">
                                    @forelse ($listings as $value)
                                    <?php $acc_url = get_accommodation_url($value->name,$value->id, $value->type); ?>
                                    <div class="col-md-4">
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
                                                <?php $acc_url = get_accommodation_url($value->name,$value->id, $value->type); ?>
                                                <h2><a href="{{url($acc_url)}}">{{$value->name}}</a></h2>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <p>No Listings found.</p>
                                    @endforelse
                                </div>

                                <nav class="pagination-wrapper">
                                    @include('frontend.pagination.limit_links', ['paginator' => $listings])
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="sidebar">
                            @include('frontend.partials.filter_listing')                       
                            @include('frontend.partials.recent_listing')
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
