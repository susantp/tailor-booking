<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Module;

class CheckPermission {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
//        $route_name_arr = (explode('.', $request->route()->getName()));
//            $route_name = pr(end($route_name_arr));
        if (!Auth::check()) {
            return redirect(route('BACKEND-LOGIN'));
        }
        $info = $this->module_info();
//        pr($info);
        //# check permission
        $exception_uris = array(
            'login',
            'logout',
            'forgot-password',
            'resetPassword',
            'resetPasswordAction',
//            'dashboard',
            'social'
        );
        if (!$info['segment']) {
            return redirect(route('BACKEND-DASHBOARD'));
        }
        if (!in_array($info['segment'], $exception_uris)) {
            if (!in_array($info['segment'], $info['allowed_module_slugs']) && $info['segment'] != 'dashboard') {
//                pr($info['allowed_module_slugs']);
//                pr($info['segment'] );
                return redirect(route('BACKEND-DASHBOARD'))->with('message', 'Sorry, you don\'t have the necessary permission.');
            }
            //# Code to restrict url access to unauthorised users >>
            $exception_modules = array('login', 'logout', 'resetPassword', 'resetPasswordAction', 'dashboard');
            $route_name_arr = (explode('.', $request->route()->getName()));
            $route_name = (end($route_name_arr));
//              $action_id = segment(3);
//              //$controller = $this->router->fetch_class();
//              $action = $this->router->fetch_method();
            if (!in_array($info['segment'], $exception_modules) && $info['segment'] != 'dashboard') {
                if ($route_name == 'edit') {
                    //# check edit condition
                    if ($info['activeModulePermission']['edit'] == false) {
                        return redirect(route('BACKEND-DASHBOARD'))->with('message', 'Sorry, you don\'t have the necessary permission to edit.');
                    }
                } elseif ($route_name == 'create') {
                    //# check add condition
                    if ($info['activeModulePermission']['add'] == false) {
                        return redirect(route('BACKEND-DASHBOARD'))->with('message', 'Sorry, you don\'t have the necessary permission to add.');
                    }
                    /*  } elseif ($action == 'delete') {
                      //check delete condition
                      if ($this->data['activeModulePermission']['delete'] == false) {
                      set_flash('error', 'You don\'t have permission');
                      redirect('dashboard');
                      }
                      } elseif ($action == '') {
                      //check view condition
                      if ($this->data['activeModulePermission']['view'] == false) {
                      set_flash('error', 'You don\'t have permission');
                      redirect('dashboard');
                      } */
                }
            }
            //# Code to restrict url access to unauthorised users <<
        } else {
            //#this is for social login like facebook google login 
//            if ($info['segment'] != 'social') {
//                if (Auth::check() && $info['segment'] != 'logout') {
//                    return redirect(route('BACKEND-DASHBOARD'));
//                }
//            }
        }
        return $next($request);
    }

    function module_info() {
        if (Auth::check()) {
            $segment = \Request::segment(2);
            $current_user_role = \Auth::user()->role_id;
            $parent_modules = [];
            $child_modules = [];
            $active_module_name = [];
            if ($current_user_role && $current_user_role != 1) {
                $current_user_modules = Module::whereRaw("id IN(SELECT module_id FROM `role_modules` rm WHERE rm.role_id = {$current_user_role})")->orderBy('ordering', 'asc')->get();
            } else {
                $current_user_modules = Module::orderBy('ordering', 'asc')->get();
            }
            $active_module_id = 0;
            foreach ($current_user_modules as $parent_module) {
                if ($parent_module->parent_id == 0) {
                    if ($segment == $parent_module->slug) {
                        $active_module_id = $parent_module->id;
                        $active_module_name = $parent_module->slug;
                    }
                    $allowed_module_slugs[] = $parent_module->slug;
                    $parent_modules[] = $parent_module;
                }
                foreach ($current_user_modules as $child_module) {
                    if ($parent_module->id == $child_module->parent_id) {
                        if ($segment == $child_module->slug) {
                            $active_module_id = $child_module->id;
                            $active_module_name = $child_module->slug;
                        }
                        $allowed_module_slugs[] = $child_module->slug;
                        $child_modules[$parent_module->id][] = $child_module;
                    }
                }
            }
            $err = \Request::get('err');
            return [
                'active_module_id' => $active_module_id,
                'active_module_name' => $active_module_name,
                'all_parent_modules' => $parent_modules,
                'all_child_modules' => $child_modules,
                'allowed_module_slugs' => $allowed_module_slugs,
                'current_user_role' => $current_user_role,
//                'segment' => $err != 'err' && $segment == '' ? 'dashboard' : $segment,
                'segment' => $segment,
                'activeModulePermission' => $this->checkModulePermission($active_module_id, $current_user_role)
            ];
        }else{
            return [
                'active_module_id' => '',
                'active_module_name' => '',
                'all_parent_modules' => '',
                'all_child_modules' => '',
                'allowed_module_slugs' => '',
                'current_user_role' => '',
                'segment' => '',
                'activeModulePermission' => ''
            ];
        }
    }

    public function checkModulePermission($module, $role_id) {
        // all access to superadmin
        if ($role_id == '1') {
            $permission = [
                'add' => true,
                'edit' => true,
                'view' => true,
                'delete' => true
            ];
            return $permission;
        }
        $permission = [
            'add' => false,
            'edit' => false,
            'view' => false,
            'delete' => false
        ];
        $permissions = \App\Models\RoleModule::where(['module_id' => $module, 'role_id' => $role_id])->first();
        if ($permissions) {
            $permission = [
                'view' => substr($permissions->permission, 0, 1) ? true : false,
                'add' => substr($permissions->permission, 1, 1) ? true : false,
                'edit' => substr($permissions->permission, 2, 1) ? true : false,
                'delete' => substr($permissions->permission, 3, 1) ? true : false,
            ];
        }
        return $permission;
    }

}
