@extends('backend.layouts.master')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $panel_title ?>
        </h1>
    </section>

    <?php foreach ($roles as $role) { ?>
        <?php if (Auth::user()->role_id == 1) { ?>
            <section class="content" style="min-height: 0px">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary collapsed-box">
                            <div class="box-header with-border">
                                <h3 class="box-title"><?php echo $role->name ?></h3>

                                <div class="box-tools pull-right">
                                    <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="message-<?php echo $role->id ?>"></div>
                                <div class="tree-structure">
                                    <div>
                                        <form action="" class="role-form" method="post">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="role_id" value="<?php echo $role->id ?>"/>
                                            <?php foreach ($modules as $module) { ?>
                                                <div class="form-group col-lg-3">
                                                    <div class="role-parent">
                                                        <label><input <?php echo (isset($saved_modules[$role->id]) && in_array($module->id, $saved_modules[$role->id])) ? 'checked' : ''
                                                ?>
                                                                type="checkbox" value="<?php echo $module->id ?>"
                                                                class="parent-check"
                                                                data-role-type="<?php echo $role->id ?>"
                                                                name="modules[]"/> <?php echo $module->name ?></label>
                                                            <?php if (!empty($child_modules[$module->id])) { ?>
                                                            <ul>
                                                                <?php foreach ($child_modules[$module->id] as $child_module) { ?>
                                                                    <li style="border: 1px solid #ccc; padding: 10px 20px; background-color: #f9f9f9; width: 100%; margin-bottom: 10px">
                                                                        <label>
                                                                            <input <?php echo (isset($saved_modules[$role->id]) && in_array($child_module->id, $saved_modules[$role->id])) ? 'checked' : ''
                                                                    ?>
                                                                                class="<?php echo $role->id . '-' . $module->id ?> child-check"
                                                                                type="checkbox"
                                                                                value="<?php echo $child_module->id ?>"
                                                                                data-role-type="<?php echo $role->id ?>"
                                                                                name="modules[]"/> <?php echo $child_module->name ?>
                                                                        </label>

                                                                        <div id="permission-<?php echo $role->id . '-' . $child_module->id ?>">
                                                                            <?php
                                                                            $viewPermission = $addPermission = $editPermission = $deletePermission = '';
                                                                            $permissionCheck = (isset($saved_module_permissions[$role->id][$child_module->id])) ? $saved_module_permissions[$role->id][$child_module->id] : false;
                                                                            ?>
                                                                            <input type="checkbox" value="1"
                                                                                   class="<?php echo $role->id . '-' . $module->id ?>"
                                                                                   <?php echo (substr($permissionCheck, 0, 1)) ? 'checked' : '' ?>
                                                                                   name="view-<?php echo $child_module->id ?>"/>
                                                                            View
                                                                            <input type="checkbox" value="1"
                                                                                   class="<?php echo $role->id . '-' . $module->id ?>"
                                                                                   <?php echo (substr($permissionCheck, 1, 1)) ? 'checked' : '' ?>
                                                                                   name="add-<?php echo $child_module->id ?>"/>
                                                                            Add
                                                                            <input type="checkbox" value="1"
                                                                                   class="<?php echo $role->id . '-' . $module->id ?>"
                                                                                   <?php echo (substr($permissionCheck, 2, 1)) ? 'checked' : '' ?>
                                                                                   name="edit-<?php echo $child_module->id ?>"/>
                                                                            Edit
                                                                            <input type="checkbox" value="1"
                                                                                   class="<?php echo $role->id . '-' . $module->id ?>"
                                                                                   <?php echo (substr($permissionCheck, 3, 1)) ? 'checked' : '' ?>
                                                                                   name="delete-<?php echo $child_module->id ?>"/>
                                                                            Delete
                                                                        </div>
                                                                    </li>
                                                                <?php } ?>
                                                            </ul>
                                                        <?php } else { ?>
                                                            <div>

                                                                <?php
                                                                $viewPermission = $addPermission = $editPermission = $deletePermission = '';
                                                                $permissionCheck = (isset($saved_module_permissions[$role->id][$module->id])) ? $saved_module_permissions[$role->id][$module->id] : false;
                                                                ?>
                                                                <input type="checkbox" value="1"
                                                                       class="<?php echo $role->id . '-' . $module->id ?>"
                                                                       <?php echo (substr($permissionCheck, 0, 1)) ? 'checked' : '' ?>
                                                                       name="view-<?php echo $module->id ?>"/>
                                                                View
                                                                <input type="checkbox" value="1"
                                                                       class="<?php echo $role->id . '-' . $module->id ?>"
                                                                       <?php echo (substr($permissionCheck, 1, 1)) ? 'checked' : '' ?>
                                                                       name="add-<?php echo $module->id ?>"/>
                                                                Add
                                                                <input type="checkbox" value="1"
                                                                       class="<?php echo $role->id . '-' . $module->id ?>"
                                                                       <?php echo (substr($permissionCheck, 2, 1)) ? 'checked' : '' ?>
                                                                       name="edit-<?php echo $module->id ?>"/>
                                                                Edit
                                                                <input type="checkbox" value="1"
                                                                       class="<?php echo $role->id . '-' . $module->id ?>"
                                                                       <?php echo (substr($permissionCheck, 3, 1)) ? 'checked' : '' ?>
                                                                       name="delete-<?php echo $module->id ?>"/>
                                                                Delete
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="clearfix"></div>
                                            <div class="form-group text-right">
                                                <input type="submit" value="Save" class="btn btn-lg btn-primary submit-form">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php } ?>
    <?php } ?>
</div>
@endsection
@push('links')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/backend.css') }}">
@endpush
@push('scripts')
<script src="{{ asset('assets/backend/js/private/rolemodule.js') }}"></script>
@endpush