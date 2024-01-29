<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Module;
use App\Models\RoleModule;

class RoleModuleController extends Controller {

    protected $fields = [
        'name' => '',
        'description' => '',
        'ordering' => '1',
    ];
    protected $table = '';
    protected $module = 'roleModule';
    protected $page_title = 'Role Module Manager';
    protected $item = 'Role';
    protected $img_folder = 'role';
    protected $page_icon = 'fa-user-camera';
    protected $nav = 'role';
    protected $parent_nav = '';
    protected $field_id = 'id';

    function __construct() {
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data = $this->essentials();
        $data['panel_title'] = $this->page_title;
        $data['roles'] = Role::orderBy('id')->where('id', '!=', 1)->get();
//        pr($data['roles']);
        $data['modules'] = Module::orderBy('ordering')->where('parent_id', 0)->where('show_in_navigation', 1)->get();
        $temp_saved_modules = false;
        $temp_saved_module_permissions = false;
        foreach ($data['roles'] as $role) {
            $saved_modules = RoleModule::where('role_id', $role->id)->get();
            if ($saved_modules) {
                foreach ($saved_modules as $saved_module) {
                    $temp_saved_module_permissions[$role->id][$saved_module->module_id] = $saved_module->permission;
                    $temp_saved_modules[$role->id][] = $saved_module->module_id;
                }
            }
        }
        $data['saved_modules'] = $temp_saved_modules;
        $data['saved_module_permissions'] = $temp_saved_module_permissions;
        $child_modules = array();
        foreach ($data['modules'] as $module) {
            $child_modules[$module->id] = Module::orderBy('ordering')->where('parent_id', $module->id)->where('show_in_navigation', 1)->get();
        }
        $data['child_modules'] = $child_modules;
        return view('backend.role_module.role_module', $data);
    }

    function manage(Request $request) {
        $post = $request->all();
        $role_id = $post['role_id'];
        RoleModule::where('role_id', $role_id)->delete();
        foreach ($post['modules'] as $module) {
            $viewPermission = (isset($post['view-' . $module])) ? '1' : '0';
            $addPermission = (isset($post['add-' . $module])) ? '1' : '0';
            $editPermission = (isset($post['edit-' . $module])) ? '1' : '0';
            $deletePermission = (isset($post['delete-' . $module])) ? '1' : '0';
            $permissionString = $viewPermission . $addPermission . $editPermission . $deletePermission;
            $record = new RoleModule;
            $record->role_id = $role_id;
            $record->module_id = $module;
            $record->permission = $permissionString;
            $record->save();
        }
        $msg = view('backend.role_module.response')->render();
        return response()->json(['msg' => $msg, 'role_id' => $role_id], 200);
    }

}
