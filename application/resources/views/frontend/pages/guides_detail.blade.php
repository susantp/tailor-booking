@extends('frontend.layouts.master')
@section('content')
<div class="main-wrapper">
    <div class="main">
        <div class="main-inner">
            <div class="content">
                <div class="content-title">
                    <div class="container">
                        <h1>{{ucwords($guide->name)}}</h1>
                        {!! display_breadcrumb_front($breadcrumb, url('')) !!}
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-lg-3">
                            <div class="sidebar">								
                                <div class="widget">
                                    <h2 class="widgettitle">Travel Guide</h2>
                                    <ul class="menu nav nav-stacked">
                                        @forelse ($tg as $value)
                                        <?php $menu_data = check_menu_links($value); ?>
                                        <li class="nav-item"> 
                                            <a {{ $menu_data['target'] }} href="{{ $menu_data['page_url'] }}"  class="nav-link">
                                                {{ $value->name }}
                                            </a>
                                        </li>
                                        @empty
                                        <p>No Menu found.</p>
                                        @endforelse
                                    </ul>
                                </div>
                                @include('frontend.partials.recent_listing')
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-9">
                            <div class="content">
                                <div class="container push-top-bottom">
                                    <div class="post-detail">
                                        {!!$guide->long_description!!}</div>
                                </div>
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
@endpush
