@extends('frontend.layouts.master')
@section('content')
<div class="main-wrapper">
    <div class="main">
        <div class="main-inner">
            <div class="content">
                <div class="content-title">
                    <div class="container">
                        <h1>{{ucwords($listing->name)}}</h1>
                        {!! display_breadcrumb_front($breadcrumb, url('')) !!}
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-lg-9">
                            <div class="push-top-bottom">
                                <div class="listing-detail">
                                    <div class="gallery">
                                        @forelse ($listing->images as $value)
                                        <div class="gallery-item" style="background-image: url({{asset('assets/')}}/{{$value->image}});"> 
                                            <div class="gallery-item-description">
                                                {{$value->title}}
                                            </div>
                                        </div>
                                        @empty
                                        <p>No Listings found.</p>
                                        @endforelse     
                                    </div>
                                    <h2>Property Description</h2>
                                    {!!$listing->long_description!!}
                                    <h2  style="display: none">Opening Hours</h2>
                                    <div class="opening-hours-wrapper" style="display: none">
                                        <table class="opening-hours">
                                            <thead>
                                                <tr>
                                                    <th>MONDAY</th>
                                                    <th>TUESDAY</th>
                                                    <th>WEDNESDAY</th>
                                                    <th>THURSDAY</th>
                                                    <th>FRIDAY</th>
                                                    <th>SATURDAY</th>
                                                    <th>SUNDAY</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <?php
                                                    if (!empty($listing->opening_hours)) {
                                                        $oh = json_decode($listing->opening_hours);
                                                        for ($i = 0; $i <= 6; $i++) {
                                                            if ($oh->msg[$i] != '') {
                                                                echo '<td class="other-day">' . $oh->msg[$i] . '</td>';
                                                            } else {
                                                                $hours = $oh->hrs[$i];
                                                                $hours_arr = explode('-', $oh->hrs[$i]);
                                                                echo '<td class="open"><span class="from">' . $hours_arr[0] . '</span> <span class="separator">-</span> <span class="to">' . @$hours_arr[1] . '</span></td>';
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php if($listing->lattitude !='' &&  $listing->longitude!=''){?>
                                    <h2>Location in Map</h2>
                                    <div id="listing-position"></div>
                                    <?php }?>
                                    <?php $acc_url = get_accommodation_url($listing->name,$listing->id, $listing->type); ?>
                                    <div class="fb-comments" data-href="{{url($acc_url)}}" data-numposts="5"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <div class="sidebar">
                                <?php if($listing->logo){?>
                                <div class="widget profile">
                                    <img src="{{asset('assets/')}}/{{$listing->logo}}" alt=" Business Logo">
                                </div>
                                <?php }?>
                                <div class="widget">
                                    <h2 class="widgettitle">Contact Information</h2>
                                    <ul class="contact">
                                        @if ($listing->email != '')<li><i class="md-icon">email</i> <a href="mailto:{{$listing->email}}">{{$listing->email}}</a></li>@endif
                                        @if ($listing->website != '')<li><i class="md-icon">link</i> <a href="{{$listing->website}}">{{$listing->website}}</a></li>@endif
                                        @if ($listing->phone != '')<li><i class="md-icon">phone</i> {{$listing->phone}}</li>@endif
                                        @if ($listing->mobile != '')<li><i class="md-icon">phone</i> {{$listing->mobile}}</li>@endif
                                        @if ($listing->address != '')<li><i class="md-icon">location_on</i>{!! nl2br($listing->address)!!}</li>@endif
                                    </ul>
                                </div>
                                <div class="widget social-fb">
                                    <div class="fb-page" data-href="{{$listing->facebook}}" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="{{$listing->facebook}}" class="fb-xfbml-parse-ignore"><a href="{{$listing->facebook}}">Hello Himalayan Homes</a></blockquote></div>
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
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
        integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
crossorigin=""></script>
<script>

var mymap = L.map('listing-position').setView([{{$listing->lattitude}}, {{$listing->longitude}}], 13);

L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
    maxZoom: 18,
//    zoom: 1,
    attribution: '',
    id: 'mapbox.streets'
}).addTo(mymap);

L.marker([{{$listing->lattitude}}, {{$listing->longitude}}]).addTo(mymap)
        .bindPopup("{{$listing->map_info}}").openPopup();

//L.circle([51.508, -0.11], 500, {
//    color: 'red',
//    fillColor: '#f03',
//    fillOpacity: 0.5
//}).addTo(mymap).bindPopup("I am a circle.");

//L.polygon([
//    [51.509, -0.08],
//    [51.503, -0.06],
//    [51.51, -0.047]
//]).addTo(mymap).bindPopup("I am a polygon.");


var popup = L.popup();

function onMapClick(e) {
    popup
            .setLatLng(e.latlng)
            .setContent("You clicked the map at " + e.latlng.toString())
            .openOn(mymap);
}

//mymap.on('click', onMapClick);
</script>


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

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
      integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
      crossorigin=""/>
@endpush
