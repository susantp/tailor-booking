<footer class="site-footer">
    <div class="container">
        <div class="footer-top">
            <div class="row">
                <div class="col-sm-6 col-xl-2">
                    <div class="footer-wrap">
                        <h3 class="footer-title">Products</h3>
                        <ul class="footer-menu">
                            @forelse ($footerCatListing as $value)
                                <li><a href="{{url('/')}}{{ $value->type==2?'/hire':'/retail' }}/{{ $value->category_slug }}">{{$value->category_name}}</a></li>
                            @empty
                                <p>No Products found.</p>
                            @endforelse
                        </ul>
                        
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="footer-wrap">
                        <h3 class="footer-title">{{ucwords($openingTime->name)}} </h3>
                        <?php echo str_replace('../../../assets',url('/').'/assets',$openingTime->description)?>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="footer-wrap">
                        <h3 class="footer-title">Find us on Facebook</h3>
                        <!-- <a href="#" target="_blank"><img src="assets/images/follow-facebook.png" alt=""></a> -->
                        <div class="fb-page"
                            data-href="{{ $settings->facebook }}"
                            data-width="340"
                            data-hide-cover="false"
                            data-show-facepile="true">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-4">
                    <div class="footer-wrap">
                        <h3 class="footer-title">Scott Ferguson Formal Wear</h3>
                        <ul class="footer-contact">
                            <li class="phone"><a href="tel:{{ $settings->phone }}">{{ $settings->phone }}</a></li>
                            <li class="email"><a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a></li>
                            <li class="location">{{ $settings->address }}</li>
                        </ul>
                        <ul class="footer-social">
                            <li><a href="{{ $settings->facebook }}"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="{{ $settings->pinterest }}"><i class="fa fa-pinterest"></i></a></li>
                            <li><a href="{{ $settings->instagram }}"><i class="fa fa-instagram"></i></a></li>
                            <li><a href="{{ $settings->youtube }}"><i class="fa fa-youtube"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-copyright text-center">
            &copy; Scott Ferguson Formalwear 2021. Powered by <a href="https://maxwebsurf.com.au" target="_blank">MaxWebSurf</a>.
        </div>
    </div>
</footer>