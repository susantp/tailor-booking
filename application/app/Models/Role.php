<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

    public $img_folder = '';
    protected $fillable = [
        'name',
        'description',
        'ordering',
    ];

    function form_builder_array($values = array()) {
        $data = array(
            'group1' => array(
                'width' => '6',
                'field' => array(
                    array('label' => 'Role',
                        'name' => 'name',
                        'type' => 'text',
                        'value' => isset($values['name']) ? $values['name'] : '',
                        'class' => 'form-control',
                    ),
                    array('label' => 'Description',
                        'name' => 'description',
                        'type' => 'textarea',
                        'value' => isset($values['description']) ? html_entity_decode($values['description']) : '',
                        'class' => 'form-control'
                    ),
                )
            )
        );
        return $data;
    }

}
