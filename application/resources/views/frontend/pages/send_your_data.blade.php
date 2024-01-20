@extends('frontend.layouts.master')
@section('content')
<div class="main-wrapper">
    <div class="main">
        <div class="main-inner">
            <div class="content">
                <div class="content-title">
                    <div class="container">
                        <h1>Send your Data</h1>
                        {!! display_breadcrumb_front($breadcrumb, url('')) !!}
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-lg-3">
                            <div class="sidebar">
                                <div class="widget">
                                    <h2 class="widgettitle">Contact Information</h2>
                                    <ul class="contact">
                                        <li><i class="md-icon">email</i> <a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a></li>
                                        <li><i class="md-icon">phone</i>{{ $settings->phone }}</li>
                                        <li><i class="md-icon">location_on</i> {{ $settings->address }}</li>
                                    </ul>
                                </div>
                                @include('frontend.partials.recent_listing')
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-9">
                            <div class="content push-top-bottom">
                                <div class="comment-create clearfix">
                                    <form method="post" class="send-your-data-form" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Name of Person</label>
                                                    <input type="text" class="form-control required" name="person_name">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Accommodation Name</label>
                                                        <input type="text" class="form-control required" name="accommodation_name">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Type</label>
                                                        <select class="selectpicker form-control required" name="type">
                                                            <option value="">Select Type</option>
                                                            <option value="Hotel">Hotel</option>
                                                            <option value="Lodges">Lodges</option>
                                                            <option value="Restaurant">Restaurant</option>
                                                            <option value="Home Stay">Home Stay</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Location</label>
                                                        <select class="selectpicker form-control  required" name="location">
                                                            <option value="" selected="selected">Select Location</option>
                                                            <option value="CHAURIKHARKA VDC">CHAURIKHARKA VDC</option>
                                                            <option value="KHUMJUNG VDC">KHUMJUNG VDC</option>
                                                            <option value="NAMCHE VDC">NAMCHE VDC</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Address</label>
                                                        <input type="text" class="form-control required" name="address">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>E-mail</label>
                                                        <input type="text" class="form-control email" name="email">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Contact Numbers</label>
                                                        <input type="text" class="form-control  required" name="contact_nos">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Web site URL <span class="red-label">(must start with http:// or https://)</span></label>
                                                        <input type="text" class="form-control url" name="website">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Facebook URL <span class="red-label">(must start with http:// or https://)</span></label>
                                                        <input type="text" class="form-control  url" name="facebook_url">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <textarea class="form-control required" name="description" rows="5"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Logo</label><br>
                                                    <input type="file" name="logo[]" class="required" accept="image/*">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Images Attachments</label><br>
                                                    <input type="file" name="attachments[]" multiple  accept="image/*">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group-btn">
                                            <button type="submit" id="submit" class="btn btn-primary btn-large pull-right">Send Message</button>
                                            <span class="msg error_message"></span>
                                        </div>
                                    </form>
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
