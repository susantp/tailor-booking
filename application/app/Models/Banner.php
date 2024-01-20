<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model {

    protected $dateFormat = 'U';
    protected $fillable = [
        'id',
        'title',
        'content',
        'image',
        'url',
        'button_text',
        'target',
        'ordering',
        'status',
    ];

    function form_builder_array($values = array()) {
        $data = array(
            'group1' => array(
                'width' => '6',
                'field' => array(
                    array('label' => 'Banner  Title',
                        'name' => 'title',
                        'type' => 'text',
                        'value' => $values['title'],
                        'class' => 'form-control',
                    ),
                    array('label' => 'Description',
                        'name' => 'content',
                        'type' => 'textarea',
                        'value' => $values['content'],
                        'class' => 'form-control',
                    ),
                ),
            ),
            'group2' => array(
                'width' => '6',
                'field' => array(
                    array('label' => 'Button Text',
                        'name' => 'button_text',
                        'type' => 'text',
                        'value' => $values['button_text'],
                        'class' => 'form-control',
                    ),
                    array('label' => 'URL',
                        'name' => 'url',
                        'type' => 'text',
                        'value' => $values['url'],
                        'class' => 'form-control',
                        'instruction' => 'URL must start with http:// or https://',
                    ),
                    array('label' => 'URL Target',
                        'name' => 'target',
                        'type' => 'dropdown',
                        'option' => ['_self' => 'Same Window', '_blank' => 'New window'],
                        'selected' => $values['target'],
                        'attributes' => array('class' => "selectpicker form-control")
                    ),
                    array('label' => 'Ordering',
                        'name' => 'ordering',
                        'type' => 'text',
                        'instruction' => '(Only Integers.)',
                        'value' => $values['ordering'],
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
                        'id' => "menu_icon",
                        'placeholder' => "Banner Image"
                    ),
                ),
            )
        );
        return $data;
    }

}
