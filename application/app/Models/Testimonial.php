<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model {

    protected $dateFormat = 'U';
    protected $fillable = [
        'name',
        'content',
        'image',
        'ordering',
        'status',
        'created_by',
        'updated_by'
    ];

    function form_builder_array($values = array()) {
        $data = array(
            'group1' => array(
                'width' => '6',
                'field' => array(
                    array('label' => 'Name of Person',
                        'name' => 'name',
                        'type' => 'text',
                        'value' => $values['name'],
                        'class' => 'form-control',
                    ),
                    array('label' => 'Image',
                        'name' => 'image',
                        'type' => 'image', //# image byb!
                        'value' => $values['image'],
                        'class' => 'form-control',
                        'onclick' => 'BrowseServer(this)',
                        'data-resource-type' => 'image',
                        'data-multiple' => "false",
                        'id' => "climer_image",
                        'placeholder' => "Testimonial Image"
                    ),
                    array('label' => 'Ordering',
                        'name' => 'ordering',
                        'type' => 'text',
                        'instruction' => '(Only Integers.)',
                        'value' => $values['ordering'],
                        'class' => 'form-control',
                    ),
                ),
            ),
            'group2' => array(
                'width' => '6',
                'field' => array(
                    array('label' => 'Content',
                        'name' => 'content',
                        'type' => 'textarea',
                        'value' => $values['content'],
                        'class' => 'form-control',
                        'id' => 'ckeditor',
                    ),
                ),
            )
        );
        return $data;
    }

}
