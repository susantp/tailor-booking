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
                                <h2>Contact us</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- hero section ends -->
        <div class="section section-contact">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-xl-3 text-center">
                        <div class="contact__info">
                            <h2>CALL US</h2>
                            <p>Send us a text & an ambassador will respond when available.</p>
                            <ul>
                                <li><i class="fa fa-phone"></i><a href="tel:{{ $settings->phone }}">{{ $settings->phone }}</a></li>
                            </ul>
                        </div>


                    </div>

                    <div class="col-md-6 col-xl-3 text-center">
                        <div class="contact__info">
                            <h2>ADDRESS</h2>
                            <ul>
                                <li><i class="fa fa-map-marker"></i>{{ $settings->address }}</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3 text-center">
                        <div class="contact__info">
                            <h2>Mail us</h2>
                            <ul>
                                <li><i class="fa fa-envelope"></i><a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3 text-center">
                        <div class="contact__info">
                            <h2>Opening Hour</h2>
                            <p>{{ $settings->opening_hours }}</p>
                        </div>
                    </div>
                </div>
                <div class="contact__form">
                    <h2>GET IN TOUCH</h2>
                    <div id="ContactForm">
                        <div class="alertmsg">
                            <?php if (isset($_GET['msg'])) {
                                echo $_GET['msg'];
                            }
                            ?>
                        </div>
{{--                        <form method="POST" name="contactform" action="process.php">--}}

                            <form method="post" class="inquiry-form">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <?php
                            $ipi = getenv("REMOTE_ADDR");
                            $httprefi = getenv("HTTP_REFERER");
                            $httpagenti = getenv("HTTP_USER_AGENT");
                            ?>
                            <input type="hidden" name="ip" value="<?php echo $ipi ?>" />
                            <input type="hidden" name="httpref" value="<?php echo $httprefi ?>" />
                            <input type="hidden" name="httpagent" value="<?php echo $httpagenti ?>" />
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="name" name="full_name" placeholder="Full Name:" class="form-control" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="address" placeholder="Address:" class="form-control" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" name="email" placeholder="Email:" class="form-control" required />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="phone" placeholder="Phone:" class="form-control" required />
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea name="message" cols="30" rows="5" class="form-control textarea" placeholder="Message:" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
{{--                                <button type="submit" class="btn btn-default">Submit</button>--}}
                                <button type="submit" id="submit" class="btn btn-default">Submit</button>
                                <span class="msg error_message"></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="contact__map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3264.0831681458644!2d138.52602465109837!3d-35.1046340915848!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ab0d879d190e565%3A0x468b5a8236e3d0dc!2s70%20Main%20S%20Rd%2C%20Old%20Reynella%20SA%205161%2C%20Australia!5e0!3m2!1sen!2snp!4v1628410851905!5m2!1sen!2snp" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
@endsection
@push('scripts')
@endpush

@push('links')
@endpush
