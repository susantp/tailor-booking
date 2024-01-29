<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    public $img_folder = '';
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'customer_code',
        'country',
        'address',
        'contact',
    ];

    function role() {
        return $this->belongsTo('App\Models\Role');
    }

    function suffle($result) {
        $new_arr = array();
        if ($result) {
            foreach ($result as $k => $v) {
                //# create new array with necessary items only
                $new['id'] = $v->id;
                $new['name'] = $v->name;
                $new['role'] = $v->role->name;
                $new['status'] = $v->status;
                $new_arr[] = collect($new);
            }
        }
        return collect($new_arr);
    }

    function form_builder_array($values = array()) {
        $data = array(
            'group1' => array(
                'width' => '6',
                'field' => array(
                    array('label' => 'Name',
                        'name' => 'name',
                        'type' => 'text',
                        'value' => isset($values['name']) ? $values['name'] : '',
                        'class' => 'form-control',
                    ),
                    array('label' => 'Email',
                        'name' => 'email',
                        'type' => 'text',
                        'value' => isset($values['email']) ? $values['email'] : '',
                        'class' => 'form-control',
                    ),
                    array('label' => 'Role ID',
                        'name' => 'role_id',
                        'type' => 'dropdown',
                        'option' => get_select(Role::orderBy('ordering')->select('id', 'name')->where('id','<>','1')->get(), 'Select Role'),
                        'selected' => isset($values['role_id']) ? $values['role_id'] : '',
                        'attributes' => array('class' => "selectpicker form-control"),
                    ),
//                    array('label' => 'Country',
//                        'name' => 'country',
//                        'type' => 'text',
//                        'value' => isset($values['country']) ? $values['country'] : '',
//                        'class' => 'form-control',
//                    ),
                    array('label' => 'Address',
                        'name' => 'address',
                        'type' => 'text',
                        'value' => isset($values['address']) ? $values['address'] : '',
                        'class' => 'form-control',
                    ),
                    array('label' => 'Contact',
                        'name' => 'contact',
                        'type' => 'text',
                        'value' => isset($values['contact']) ? $values['contact'] : '',
                        'class' => 'form-control',
                    ),
                    array('label' => '',
                        'mode' => 'edit',
                        'type' => 'checkbox',
//                        'selected' => json_decode($values['cp']),
                        'selected' => [],
                        array(
                            array('name' => 'cp',
                                'label' => 'Change Password?',
                                'value' => '1',
                                'id' => 'cp'
                            ),
                        ),
                    ),
                    array('label' => 'New Password',
                        'mode' => 'edit',
                        'name' => 'new_password',
                        'type' => 'password',
                        'value' => '',
                        'class' => 'form-control',
                    ),
                    array('label' => 'Re-enter Password',
                        'mode' => 'edit',
                        'name' => 'new_password_confirmation',
                        'type' => 'password',
                        'value' => '',
                        'class' => 'form-control',
                    ),
                )
            )
        );
        return $data;
    }

}
