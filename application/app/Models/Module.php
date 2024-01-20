<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model {

    public $img_folder = '';
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'ordering',
        'icon_class',
        'social',
        'show_in_navigation',
    ];

    function form_builder_array($values = array(), $isEdit = false) {
        $data = array(
            'group1' => array(
                'width' => '6',
                'field' => array(
                    array('label' => 'Module Name',
                        'name' => 'name',
                        'type' => 'text',
                        'value' => isset($values['name']) ? $values['name'] : '',
                        'class' => 'form-control title',
                    ),
                    array('label' => 'Module Slug',
                        'name' => 'slug',
                        'type' => 'text',
                        'value' => isset($values['slug']) ? $values['slug'] : '',
                        'class' => 'form-control alias',
                    ),
                    array('label' => 'Parent Module',
                        'name' => 'parent_id',
                        'type' => 'dropdown',
                        'option' => get_select(Module::orderBy('ordering')->select('id', 'name')->where('parent_id', 0)->get(), 'Select Parent Module'),
                        'selected' => isset($values['parent_id']) ? $values['parent_id'] : '',
                        'attributes' => array('class' => "selectpicker form-control"),
                    ),
                    array('label' => 'Icon Class',
                        'name' => 'icon_class',
                        'type' => 'text',
                        'value' => isset($values['icon_class']) ? $values['icon_class'] : '',
                        'class' => 'form-control',
                    ),
                    array('label' => 'Show in Navigation',
                        'type' => 'radio',
                        'selected' => isset($values['show_in_navigation']) ? $values['show_in_navigation'] : '',
                        array(
                            array('type' => 'radio',
                                'name' => 'show_in_navigation',
                                'label' => 'Yes',
                                'value' => '1',
                                'attributes' => array('class' => "required"),
                            ),
                            array('type' => 'radio',
                                'name' => 'show_in_navigation',
                                'label' => 'No',
                                'value' => '0',
                                'attributes' => array('class' => ""),
                            ),
                        ),
                    ),
                    array('label' => 'Social Integration',
                        'type' => 'radio',
                        'selected' => isset($values['social']) ? $values['social'] : '',
                        array(
                            array('type' => 'radio',
                                'name' => 'social',
                                'label' => 'On',
                                'value' => 'On',
                                'attributes' => array('class' => "required"),
                            ),
                            array('type' => 'radio',
                                'name' => 'social',
                                'label' => 'Off',
                                'value' => 'Off',
                                'attributes' => array('class' => ""),
                            ),
                        ),
                    ),
                    array('label' => 'Module Ordering',
                        'name' => 'ordering',
                        'type' => 'text',
                        'value' => isset($values['ordering']) ? $values['ordering'] : '',
                        'class' => 'form-control',
                    ),
                )
            )
        );
        if ($isEdit) {
//            $data['group1']['field'][1]['disabled'] = 'disabled';
        }
        return $data;
    }

}
