<?php

namespace App\Http\Controllers\CustomAuthentication;

use App\User;
use Illuminate\Http\Request;
use Mail;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Activity;

class CustomAuthenticationController extends Controller {

    public $alertMessage = null;
    public $alertType = 'success';

    public function loginPage() {
        // pr(345345);
        return view('custom-auth.login');
    }

    public function checkLogin(Request $request) {
        $email = $request->input('email');
        $password = $request->input('password');
        //return(Auth::attempt(['email' => $email, 'password' => $password, 'status' => 1]));
        if (Auth::attempt(['email' => $email, 'password' => $password, 'status' => 1])) {
            
            // Authentication passed...
            $this->alertMessage = 'Successfully Logged In.';
            Activity::log(['action' => 'Login', 'module' => 'Login', 'module_id' => 0]);
            return redirect()->route('BACKEND-DASHBOARD')->with(['alertMessage' => $this->alertMessage, 'alertType' => $this->alertType]);
        } else {
            return redirect()->back()->withErrors('Incorrect Username or Password.');
        }
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->flush();
//        Activity::log(['action' => 'Logout', 'module' => 'Logout', 'module_id' => 0]);
        return redirect()->route('BACKEND-LOGIN');
    }

    public function postForgotPasswordRequest(Request $request) {
        $email = $request->input('email');
        $user = User::where('email', '=', $email)->first();

        if (!($user)) {
            return redirect()->back()->withErrors('Sorry, Invalid Email');
            $this->alertMessage = "Sorry, Invalid Email";
            $this->alertType = 'danger';
            return redirect()->back()->with(['alertMessage' => $this->alertMessage, 'alertType' => $this->alertType]);
        }

        $passwordToken = str_random(40);

        $checkForPreviousRequest = DB::table('password_resets')->where('email', '=', $email)->first();
        try {
            if (!($checkForPreviousRequest) ) {
                logger('here');
                DB::table('password_resets')->insert(['email' => $email, 'token' => $passwordToken]);
            } else {
                logger('here baby');
                DB::table('password_resets')->where('email', '=', $email)->update(['token' => $passwordToken]);
            }
        } catch (QueryException $qE) {
            //return $qE->getMessage();
            $this->alertMessage = 'Something Went Wrong. Please Try Again.';
            $this->alertType = 'danger';
            return redirect()->back()->with(['alertMessage' => $this->alertMessage, 'alertType' => $this->alertType]);
        }

        $data = [
            'myemail' => $user->email,
            'myname' => $user->name,
            'passwordToken' => $passwordToken
        ];

        Mail::send('emails.forgot_password', $data, function ($m) use ($data) {
            $m->from('noreply@scottfergusonformalwear.com.au', 'Septemeber Shell');

            $m->to($data['myemail'], $data['myname'])->subject('Septemeber Shell Forgot Password!');
        });
        /* $job = new SendWebForgotPasswordRequestSuccessEmail($userEmail, $userName, $passwordToken, $pinNo);
          $this->dispatch($job); */

        $this->alertMessage = 'Please Check Your Email For Password Reset Instructions.';
        return redirect()->back()->with(['alertMessage' => $this->alertMessage, 'alertType' => $this->alertType]);
    }

    public function processForgotPasswordForm($passwordToken) {
        $data['passwordToken'] = $passwordToken;

        return view('custom-auth.forgot-password-reset', $data);
    }

    public function postProcessForgotPassword(Request $request, $passwordToken) {
        if ($request->input('password') != $request->input('confirmPassword')) {
            $this->alertMessage = "Password and confirm password didn't match. Try Again";
            $this->alertType = 'danger';
            return redirect()->back()->with(['alertMessage' => $this->alertMessage, 'alertType' => $this->alertType]);
        }

        $passwordResetRequestedUser = DB::table('password_resets')->where('token', '=', $passwordToken)->first();

        if (!($passwordResetRequestedUser)) {
            $this->alertMessage = "Password Token Expired. Try Again Doing Forgot Password.";
            $this->alertType = 'danger';
            return redirect()->back()->with(['alertMessage' => $this->alertMessage, 'alertType' => $this->alertType]);
        }

        $newPassword = $request->input('password');

        $user = User::where('email', '=', $passwordResetRequestedUser->email)->first();
        $user->password = bcrypt($newPassword);
        $user->save();

        DB::table('password_resets')->where('token', '=', $passwordToken)->delete();

        $this->alertMessage = "Password Successully Changed. Login With Your New Password.";

        return redirect()->route('BACKEND-LOGIN')->with(['alertMessage' => $this->alertMessage, 'alertType' => $this->alertType]);
    }

}
