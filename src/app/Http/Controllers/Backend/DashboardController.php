<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use Auth;
use Hash;
use Redirect;
//use App\User;

class DashboardController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data['title'] = 'Dashboard';
        $data['page_header'] = 'Dashboard';
        $data['page_icon'] = 'fa-home';
        $data['parent_nav'] = '';
        $data['nav'] = 'dashboard';
        return view('backend.dashboard.dashboard', $data);
    }

    /**
     * Displays Reset password page 
     */
    function resetPassword() {
        $data['email'] = Auth::user()->email;
        $data['title'] = 'Change Password';
        $data['page_header'] = 'Change Password';
        $data['page_icon'] = 'fa-pencil';
        $data['parent_nav'] = '';
        $data['nav'] = 'dashboard';
        $data['panel_title'] = 'Dashboard Password Change';
        return view('backend.dashboard.reset_password', $data);
    }

    /**
     * changing old password with new password by checking validation
     */
    function resetPasswordAction(ResetPasswordRequest $request) {
        $email = $request->get('email');
        $old_pass = $request->get('old_password');
        $new_pass = $request->get('new_password');
        if (Hash::check($old_pass, Auth::user()->password)) {
            $user = Auth::user();
            $user->password = Hash::make($new_pass);
            $user->email = ($email);
            $user->save();
//            return back()->with('success', 'The Password has been successfully changed');  //this is also correct !!
            return back()->withSuccess('The Password has been successfully changed');
        } else {
            return back()->withErrors(['The current password does not match with our records.']);
        }
    }

}
