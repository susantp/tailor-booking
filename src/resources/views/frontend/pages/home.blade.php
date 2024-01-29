@extends('frontend.layouts.master')
@section('content')
<div class="site-content">
      <div class="section section-hero">
         <div class="hero__slider slider">
         @forelse ($banners as $banner)
            <div class="hero-item">
               <span class="overlay"></span>
               <img class="img-100" src="{{asset('assets/')}}/{{$banner->image}}" alt="">
               <div class="container">
                  <div class="hero-wrapper">
                     <div class="hero-inner">

                        <h2>{!!nl2br($banner->content)!!}</h2>
                        @if($banner->button_text)
                           <a href="{{$banner->url}}" target="_blank" class="btn btn-hero">{{$banner->button_text}}</a>
                        @endif
                     </div>
                  </div>
               </div>
            </div>
            
            @empty
            <p>No Banners found.</p>
            @endforelse
         </div>
      </div>
      <!-- hero section ends -->
      <div class="section-welcome">
         <div class="container">
            <div class="title-wrap text-center">
               <h2>{{ucwords($content->name)}}</h2>
            </div>
            <?php echo str_replace('../../../assets',url('/').'/assets',$content->description)?>
         </div>
      </div>

      <div class="section-products">
         <div class="container">
            <div class="slider product-slider">
               @forelse ($products as $value)
               <div class="product-item">
                  <div class="product-wrap">
                      <a href="{{url('/product/')}}/{{$value->slug}}">
                     <span class="overlay"></span>
                     <div class="product-image">
                        <img src="{{asset('assets/')}}/{{$value->cover_image}}" alt="">
{{--                        <img src="{{asset('assets/frontend/images/wedding.png')}}" alt="">--}}
                     </div>
                     </a>
                     <div class="product-title">
                        <h3><a href="{{url('/product/')}}/{{$value->slug}}">{{$value->name}}</a></h3>
                     </div>
                  </div>
               </div>
               @empty
                  <p>No Products found.</p>
               @endforelse
            </div>
         </div>
      </div>

      <div class="brands">
         <div class="container">
            <div class="title-wrap">
               <h2>Brands</h2>
            </div>
            <div class="brand-slider slider">
               @forelse ($brands as $value)
               <div class="brand-item">
                  <div class="brand-wrap"><a href="{{url('/product/')}}/{{$value->slug}}">
                     <img src="{{asset('assets/')}}/{{$value->cover_image}}" alt="{{$value->title}}">
                     </a>
                  </div>
               </div>
               @empty
                  <p>No Brands found.</p>
               @endforelse
            </div>
         </div>
      </div>
   </div>
@endsection
@push('scripts')
@endpush
@push('links')
@endpush
