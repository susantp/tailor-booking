@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php echo 'Inquiry' ?>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"> <?php echo $panel_title ?></h3>
                    </div>
                    <div class="box-body">
                        @include('backend.partials.flash')
                        <form>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Person Name</label>
                                    <input readonly="" type="text" class="form-control" name="person_name" value="{{ $record->person_name }}">
                                </div>
                                <div class="form-group">
                                    <label>Accommodation Name</label>
                                    <input readonly type="text" class="form-control" name="accommodation_name" value="{{ $record->accommodation_name }}">
                                </div>

                                <div class="form-group">
                                    <label>type</label>
                                    <input readonly type="text" class="form-control" name="type" value="{{ $record->type }}">
                                </div>
                                <div class="form-group">
                                    <label>location</label>
                                    <input readonly type="text" class="form-control" name="location" value="{{ $record->location }}">
                                </div>
                                <div class="form-group">
                                    <label>address</label>
                                    <input readonly type="text" class="form-control" name="address" value="{{ $record->address }}">
                                </div>
                                <div class="form-group">
                                    <label>email</label>
                                    <input readonly type="text" class="form-control" name="email" value="{{ $record->email }}">
                                </div>
                                <div class="form-group">
                                    <label>contact_nos</label>
                                    <input readonly type="text" class="form-control" name="contact_nos" value="{{ $record->contact_nos }}">
                                </div>
                                <div class="form-group">
                                    <label>website</label>
                                    <input readonly type="text" class="form-control" name="website" value="{{ $record->website }}">
                                </div>
                                <div class="form-group">
                                    <label>facebook_url</label>
                                    <input readonly type="text" class="form-control" name="facebook_url" value="{{ $record->facebook_url }}">
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea readonly class="form-control" rows="15">{{ $record->description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>logo</label>
                                    <?php $logos = json_decode($record->logo, true); ?>
                                    <a href="{{asset('assets/uploads/client_data') }}/{{$logos[0]}}" target="_blank" ><img src ="{{asset('assets/uploads/client_data/thumbs/') }}/{{$logos[0]}}"></a>
                                </div>
                            </div>    
                            <div class="col-sm-12">
                                
                                <div class="form-group">
                                    <label>attachments</label>
                                    <br>

                                    <?php
                                    $attachments = json_decode($record->attachments, true);
                                    foreach ($attachments as $att) {
                                        ?>
                                        <a href="{{asset('assets/uploads/client_data') }}/{{$att}}" target="_blank" >
                                            <img style="float:left;padding:0 10px 10px 0" src ="{{asset('assets/uploads/client_data/thumbs')}}/{{$att}}">
                                        </a>
                                    <?php }
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 ">
                                    <div class="form-group"> 
                                        <a class="btn btn-warning" href="{{config('site.admin') . $module}}"><span>Go Back</span></a> 
                                    </div>
                                </div>    
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection