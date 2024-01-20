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
                                    <label>Sender Name</label>
                                    <input readonly="" type="text" class="form-control" name="name" value="{{ $record->name }}">
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input readonly type="text" class="form-control" name="address" value="{{ $record->address }}">
                                </div>
                                <div class="form-group">
                                    <label>Sender Email</label>
                                    <input readonly type="text" class="form-control" name="email" value="{{ $record->email }}">
                                </div>
                               <div class="form-group">
                                    <label>Sender Phone</label>
                                    <input readonly type="text" class="form-control" name="phone" value="{{ $record->phone }}">
                                </div>
                               <div class="form-group">
                                    <label>Sender IP Address</label>
                                    <input readonly type="text" class="form-control" name="ip_address" value="{{ $record->ip_address }}">
                                </div>
                                <div class="form-group">
                                    <label>Message</label>
                                    <textarea readonly class="form-control" rows="15">{{ $record->message }}</textarea>
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