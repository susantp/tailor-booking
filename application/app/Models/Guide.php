<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guide extends Model {

    protected $dateFormat = 'U';
    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'long_description',
        'image',
        'featured',
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
                    array('label' => 'Guide Name',
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
                        'placeholder' => "Guide Image"
                    ),
                    array('label' => 'Short description',
                        'name' => 'short_description',
                        'type' => 'textarea',
                        'value' => $values['short_description'],
                        'class' => 'form-control',
                    ),
                    array('label' => 'Is Featured?',
                        'type' => 'radio',
                        'instruction' => '(Show in homepage?)',
                        'selected' => isset($values['featured']) ? $values['featured'] : '0',
                        array(
                            array('type' => 'radio',
                                'name' => 'featured',
                                'label' => 'Yes',
                                'value' => '1',
                                'id' => 'yesh'
                            ),
                            array('type' => 'radio',
                                'name' => 'featured',
                                'label' => 'No',
                                'value' => '0',
                                'id' => 'noh'
                            ),
                        ),
                    ),
                ),
            ),
            'group2' => array(
                'width' => '6',
                'field' => array(
                    array('label' => 'Long Description',
                        'name' => 'long_description',
                        'type' => 'textarea',
                        'value' => $values['long_description'],
                        'class' => 'form-control',
                        'id' => 'ckeditor',
                    ),
                    array('label' => 'Ordering',
                        'name' => 'ordering',
                        'type' => 'text',
                        'instruction' => '(Only Integers.)',
                        'value' => $values['ordering'],
                        'class' => 'form-control',
                    ),
                ),
            )
        );
        return $data;
    }

}
