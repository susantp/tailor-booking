<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model {

    protected $dateFormat = 'U';
    protected $fillable = [
        'gallery_name',
        'gallery_content',
        'cover_image',
        'gallery_ordering',
    ];

    public function images() {
        return $this->hasMany('App\Models\GalleryImage','gid');
    }

    function form_builder_array($values = array(),$template_data=array()) {
        $view = \View::make('backend.gallery.gallery_images', [
                    'data' => $template_data
        ]);
        $html = $view->render();
        $data = array(
            'group1' => array(
                'width' => '6',
                'field' => array(
                    array('label' => 'Gallery Name',
                        'name' => 'gallery_name',
                        'type' => 'text',
                        'value' => isset($values['gallery_name']) ? $values['gallery_name'] : '',
                        'class' => 'form-control',
                    ),
                    array('label' => 'Gallery Cover Image',
                        'name' => 'cover_image',
                        'type' => 'image', //# image byb!
                        'value' => $values['cover_image'],
                        'class' => 'form-control',
                        'onclick' => 'BrowseServer(this)',
                        'data-resource-type' => 'image',
                        'data-multiple' => "false",
                        'id' => "gallery_cover_image",
                        'placeholder' => "Gallery Cover Image",
                        'instruction' => 'Recommended Image size: ' . config('site.image.w') . ' X ' . config('site.image.h') . ' px',
                    ),
                    array('label' => 'Ordering',
                        'name' => 'gallery_ordering',
                        'type' => 'text',
                        'instruction' => '(Only Integers.)',
                        'value' => $values['gallery_ordering'],
                        'class' => 'form-control',
                    ),
                ),
            ),
            'group2' => array(
                'width' => '6',
                'field' => array(
                    array('label' => 'content',
                        'name' => 'gallery_content',
                        'type' => 'textarea',
                        'value' => $values['gallery_content'],
                        'class' => 'form-control',
                        'id' => 'ckeditor',
                    ),
                )
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
