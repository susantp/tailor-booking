<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Affiliates extends Model {

    protected $dateFormat = 'U';
    protected $fillable = [
        'id',
        'name',
        'url',
        'image',
        'ordering',
        'status',
    ];

    function form_builder_array($values = array()) {
        $data = array(
            'group1' => array(
                'width' => '6',
                'field' => array(
                    array('label' => 'Affiliates  Name',
                        'name' => 'name',
                        'type' => 'text',
                        'value' => $values['name'],
                        'class' => 'form-control',
                    ),
                    
                    array('label' => 'URL',
                        'name' => 'url',
                        'type' => 'text',
                        'value' => $values['url'],
                        'class' => 'form-control',
                        'instruction' => 'URL must start with http:// or https://',
                    ),
                    array('label' => 'Ordering',
                        'name' => 'ordering',
                        'type' => 'text',
                        'instruction' => '(Only Integers.)',
                        'value' => $values['ordering'],
                        'class' => 'form-control',
                    ),
                    array('label' => 'Logo',
                        'name' => 'image',
                        'type' => 'image', //# image byb!
                        'value' => $values['image'],
                        'class' => 'form-control',
                        'onclick' => 'BrowseServer(this)',
                        'data-resource-type' => 'image',
                        'data-multiple' => "false",
                        'id' => "menu_icon",
                        'placeholder' => "Logo"
                    ),
                ),
            ),
        );
        return $data;
    }

}
