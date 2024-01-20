<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class ResetPasswordRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $user = Auth::user();
        return [
            'email' => 'required|email|unique:users,email,' . $user->id,
            'old_password' => 'required|min:5',
            'new_password' => 'required|min:5|confirmed',
        ];
    }

}
