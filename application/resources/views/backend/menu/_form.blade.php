@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php echo $panel_title ?>
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
                        <?php
                        $method = isset($form['method']) ? $form['method'] : 'POST';
                        $attributes = array('url' => $form['action'], 'method' => $method, 'files' => true, 'id' => "menu_form", 'class' => "form-bordered ");
                        ?>
                        {{Form::open($attributes)}} 

                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>Menu Title</label>
                                            <input   old_id="<?php echo $value['id'] ?>"  id="menu_name" name="name" type="text" class="form-control" placeholder="Enter Menu Name" value="<?php echo $value['name'] ?>" >
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>Menu Alias</label>
                                            <input id="slug" name="slug" type="text" class="form-control" placeholder="Menu Alias" value="<?php echo $value['slug'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label>Parent Menu</label>
                                            {{Form::select('parent_id', $menu_parents, $value['parent_id'], ['class' => "selectpicker form-control"])}}
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>Menu Banner</label>
                                            <div class="img-append">
                                                <?php if (!empty($value['image'])): ?>
                                                    <input type="text" onclick="BrowseServer(this)" data-resource-type="image" data-multiple="false" name="image" value="<?php echo $value['image']; ?>"  class="form-control" id="image" placeholder="Menu Banner">
                                                    <div class="image-wrapper">
                                                        <img class="img-responsive" src="<?php echo asset('assets/') . '/' . $value['image'] ?>" />
                                                        <a href="javascript:void(0);" class="delete">
                                                            Delete
                                                        </a>
                                                    </div>
                                                <?php else: ?>
                                                    <input type="text" onclick="BrowseServer(this)" data-resource-type="image" data-multiple="false" name="image"  class="form-control" id="image" placeholder="Banner Image">
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group hidden">
                                            <label for="icons">Menu Icon</label>
                                            <div class="img-append">
                                                <?php if (!empty($value['menu_icon'])): ?>
                                                    <input type="text" onclick="BrowseServer(this)" data-resource-type="image" data-multiple="false" name="menu_icon" value="<?php echo @$value['menu_icon']; ?>"  class="form-control" id="menu_icon" placeholder="Menu Icon">
                                                    <div class="image-wrapper">
                                                        <img class="img-responsive" src="<?php echo asset('assets/') . '/' . $value['menu_icon'] ?>" />
                                                        <a href="javascript:void(0);" class="delete">
                                                            Delete
                                                        </a>
                                                    </div>
                                                <?php else: ?>
                                                    <input type="text" onclick="BrowseServer(this)" data-resource-type="image" data-multiple="false" name="menu_icon"  class="form-control" id="menu_icon" placeholder="Menu Icon">
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </div>           
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label>Menu Link Type</label>
                                            {{Form::select('menu_link_type', $menu_link_types, $value['menu_link_type'], ['class' => "form-control",'id'=>"menu-link-type" ])}}
                                        </div>

                                        <div class="form-group category_div">
                                            <label>Select Content Category</label>
                                            <select class="form-control" name="category_id" id="category_id" data-old="<?php echo $value['category_id'] ?>">
                                                <option value="">Select Category</option>

                                            </select>
                                        </div>
                                        <div class="form-group content_div">
                                            <label>Select Content</label>
                                            <select class="form-control" name="content_id" id="content_id" data-old="<?php echo $value['content_id'] ?>">
                                                <option value="">Select Content</option>
                                            </select>
                                        </div>
                                        <div class="form-group url_div">
                                            <label>URL</label>
                                            <input name="url" type="text" class="form-control" placeholder="URL" value="<?php echo $value['url'] ?>">
                                        </div>
                                        <div class="form-group file_div">
                                            <label>File</label>
                                            <input type="text" onclick="BrowseServer(this)" data-resource-type="all" data-multiple="false" name="file" value="<?php echo $value['file']; ?>"  class="form-control" placeholder="File" id="file">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>Menu Type</label>
                                            {{Form::select('menu_type', $menu_types, $value['menu_type'], ['class' => "form-control" ])}}
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            {{Form::select('status', ['1'=>'Active','0'=>'Inactive'], $value['status'], ['class' => "form-control" ])}}
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>Menu Ordering</label>
                                            <input   old_id="<?php echo $value['ordering'] ?>"  id="ordering" name="ordering" type="text" class="form-control" placeholder="Display Order" value="<?php echo $value['ordering'] ?>" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box box-danger" style="box-shadow: none; margin-top: 30px;">
                            <div class="box-header with-border" style="padding: 10px 0px;">
                                <h3 class="box-title">Menu Meta</h3>
                                <div class="box-tools pull-right">
                                </div>
                            </div>
                            <div class="box-body" style="padding: 10px 0px;">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>Meta:</label>
                                            <input id="meta_title" name="meta_title" type="text" class="form-control" placeholder="Enter Meta Title" value="<?php echo $value['meta_title'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>Description:</label>
                                            <input id="description" name="meta_description" type="text" class="form-control" placeholder="Enter Meta Description" value="<?php echo @$value['meta_description'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! form_save_options($module)!!}
                        {{Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@include('backend.partials.elfinder_config')