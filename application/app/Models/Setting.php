<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    public $img_folder = '';
    protected $fillable = [];
    protected $guarded = ['_method', '_token'];

    function form_builder_array($values = array())
    {
        $data = array(
            'group1' => array(
                'width' => '6',
                'field' => array(
                    array('label' => 'Site Name',
                        'name' => 'site_name',
                        'type' => 'text',
                        'value' => html_entity_decode($values->site_name),
                        'class' => 'form-control',
                        'parsley-required' => "true",
                        'parsley-trigger' => "keyup",
                        'parsley-validation-minlength' => "1"
                    ),
                    array('label' => 'Site Slogan',
                        'name' => 'site_slogan',
                        'type' => 'text',
                        'value' => html_entity_decode($values->site_slogan),
                        'class' => 'form-control',
                    ),
//                    array('label' => 'Google Tracking Code',
//                        'name' => 'google_tracking_code',
//                        'type' => 'textarea',
//                        'value' => html_entity_decode($values->google_tracking_code),
//                        'class' => 'form-control',
//                    ),
                    array('label' => 'E-mail',
                        'name' => 'email',
                        'type' => 'text',
                        'value' => $values->email,
                        'class' => 'form-control',
                        'parsley-type' => "email",
                        'parsley-required' => "true",
                        'parsley-trigger' => "keyup",
                        'parsley-validation-minlength' => "1"
                    ),
                    array('label' => 'E-mail -2',
                        'name' => 'email2',
                        'type' => 'text',
                        'value' => $values->email2,
                        'class' => 'form-control',
                        'parsley-type' => "email",
                        'parsley-trigger' => "keyup",
                        'parsley-validation-minlength' => "1"
                    ),
                    array('label' => 'Phone Number',
                        'name' => 'phone',
                        'type' => 'text',
                        'value' => $values->phone,
                        'class' => 'form-control',
                    ),
                    array('label' => 'Mobile Number',
                        'name' => 'mobile',
                        'type' => 'text',
                        'value' => $values->mobile,
                        'class' => 'form-control',
                    ),
                    array('label' => 'Facebook URL',
                        'name' => 'facebook',
                        'type' => 'text',
                        'value' => $values->facebook,
                        'class' => 'form-control',
                        'placeholder' => "http://www.facebook.com/",
                        'parsley-type' => "urlstrict",
                        'parsley-trigger' => "keyup",
                        'parsley-validation-minlength' => "1"
                    ),
                    array('label' => 'Pinterest URL',
                        'name' => 'pinterest',
                        'type' => 'text',
                        'value' => $values->pinterest,
                        'class' => 'form-control',
                        'placeholder' => "http://www.pinterest.com/",
                        'parsley-type' => "urlstrict",
                        'parsley-trigger' => "keyup",
                        'parsley-validation-minlength' => "1"
                    ),
                    array('label' => 'Instagram URL',
                        'name' => 'instagram',
                        'type' => 'text',
                        'value' => $values->instagram,
                        'class' => 'form-control',
                        'placeholder' => "http://www.instagram.com",
                        'parsley-type' => "urlstrict",
                        'parsley-trigger' => "keyup",
                        'parsley-validation-minlength' => "1"
                    ),
                    array('label' => 'Youtube URL',
                        'name' => 'youtube',
                        'type' => 'text',
                        'value' => $values->youtube,
                        'class' => 'form-control',
                        'placeholder' => "http://www.youtube.com/",
                        'parsley-type' => "urlstrict",
                        'parsley-trigger' => "keyup",
                        'parsley-validation-minlength' => "1"
                    ),
                    array('label' => 'Twitter URL',
                        'name' => 'twitter',
                        'type' => 'text',
                        'value' => $values->twitter,
                        'class' => 'form-control',
                        'placeholder' => "http://www.twitter.com",
                        'parsley-type' => "urlstrict",
                        'parsley-trigger' => "keyup",
                        'parsley-validation-minlength' => "1"
                    ),
                )
            ),
            'group2' => array(
                'width' => '6',
                'field' => array(
                    array('label' => 'Opening Hours',
                        'name' => 'opening_hours',
                        'type' => 'textarea',
                        'value' => html_entity_decode($values->opening_hours),
                        'class' => 'form-control',
                    ),
                    array('label' => 'Address',
                        'name' => 'address',
                        'type' => 'textarea',
                        'value' => html_entity_decode($values->address),
                        'class' => 'form-control',
                    ),
                    array('label' => 'Meta Title',
                        'name' => 'meta_title',
                        'type' => 'text',
                        'value' => isset($values->meta_title) ? html_entity_decode($values->meta_title) : '',
                        'class' => 'form-control'
                    ),
                    array('label' => 'Meta Keyword',
                        'name' => 'meta_keyword',
                        'type' => 'text',
                        'value' => isset($values->meta_keyword) ? html_entity_decode($values->meta_keyword) : '',
                        'class' => 'form-control'
                    ),
                    array('label' => 'Meta Description',
                        'name' => 'meta_desc',
                        'type' => 'textarea',
                        'value' => isset($values->meta_desc) ? html_entity_decode($values->meta_desc) : '',
                        'class' => 'form-control'
                    ),
                )
            ),
        );
        return $data;
    }

}
