<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suit extends Model {

    protected $dateFormat = 'U';
    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'long_description',
        'total_climbs',
        'suit_image',
        'email',
        'website',
        'phone',
        'mobile',
        'address',
        'featured',
        'c_ordering',
        'status',
        'created_by',
        'updated_by'
    ];

    public function images() {
        return $this->hasMany('App\Models\SuitImage', 'cid');
    }

    function form_builder_array($values = array(), $template_data = array()) {
        $view = \View::make('backend.suit.suit_images', [
                    'data' => isset($template_data['images']) ? $template_data['images'] : []
        ]);
        $html = $view->render();
        $data = array(
            'group1' => array(
                'width' => '6',
                'field' => array(
                    array('label' => 'Suit Name',
                        'name' => 'name',
                        'type' => 'text',
                        'value' => $values['name'],
                        'class' => 'form-control',
                    ),
                    array('label' => 'Total Climbs',
                        'name' => 'total_climbs',
                        'type' => 'text',
                        'value' => $values['total_climbs'],
                        'class' => 'form-control',
                    ),
                    array('label' => 'Suit Image',
                        'name' => 'suit_image',
                        'type' => 'image', //# image byb!
                        'value' => $values['suit_image'],
                        'class' => 'form-control',
                        'onclick' => 'BrowseServer(this)',
                        'data-resource-type' => 'image',
                        'data-multiple' => "false",
                        'id' => "climer_image",
                        'placeholder' => "Suit Image"
                    ),
                    array('label' => 'Email',
                        'name' => 'email',
                        'type' => 'text',
                        'value' => $values['email'],
                        'class' => 'form-control',
                    ),
                    array('label' => 'Web site',
                        'name' => 'website',
                        'type' => 'text',
                        'value' => $values['website'],
                        'class' => 'form-control',
                        'instruction' => 'URL must start with http:// or https://',
                    ),
                    array('label' => 'Phone',
                        'name' => 'phone',
                        'type' => 'text',
                        'value' => $values['phone'],
                        'class' => 'form-control',
                    ),
                    array('label' => 'Mobile',
                        'name' => 'mobile',
                        'type' => 'text',
                        'value' => $values['mobile'],
                        'class' => 'form-control',
                    ),
                    array('label' => 'Address',
                        'name' => 'address',
                        'type' => 'textarea',
                        'value' => $values['address'],
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
                    array('label' => 'Short description',
                        'name' => 'short_description',
                        'type' => 'textarea',
                        'value' => $values['short_description'],
                        'class' => 'form-control',
                    ),
                    array('label' => 'Long Description',
                        'name' => 'long_description',
                        'type' => 'textarea',
                        'value' => $values['long_description'],
                        'class' => 'form-control',
                        'id' => 'ckeditor',
                    ),
                    array('label' => 'Ordering',
                        'name' => 'c_ordering',
                        'type' => 'text',
                        'instruction' => '(Only Integers.)',
                        'value' => $values['c_ordering'],
                        'class' => 'form-control',
                    ),
                ),
            ),
            'group3' => array(
                'width' => '12',
                'field' => array(
                    array('name' => $html,
                        'type' => 'template',
                    ),
                )
            ),
        );
        return $data;
    }

}
