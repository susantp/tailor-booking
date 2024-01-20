<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{

    protected $dateFormat = 'U';
    protected $acc_type = ['h' => 'Hotel', 'l' => 'Lodges', 'r' => 'Restaurant', 'hs' => 'Home Stay'];
    protected $fillable = [
        'name',
        'slug',
        'type',
        'category_id',
        'short_description',
        'long_description',
        'price',
        'pinterest',
        'twitter',
        'facebook',
        'cover_image',
        'banner_image',
        'acc_ordering',
        'featured',
        'popular',
        'status',
        'html_keyword',
        'html_description',
        'created_by',
        'updated_by'
    ];

    function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    function suffle($result)
    {
        $new_arr = array();
        if ($result) {
            foreach ($result as $k => $v) {
//        dd($v);
                //# create new array with necessary items only
                $new['id'] = $v->id;
                $new['name'] = $v->name;
                $new['price'] = $v->price;
                $new['category'] = $v->category->category_name;
//                $new['featured'] = $v->featured == 0 ? '<span style="color:red">No</span>' : '<span style="color:green">Yes</span>';
//                $new['popular'] = $v->popular == 0 ? '<span style="color:red">No</span>' : '<span style="color:green">Yes</span>';
                $new['ordering'] = $v->acc_ordering;
                $new['status'] = $v->status;
                $new_arr[] = collect($new);
            }
        }
        return collect($new_arr);
    }

    public function images()
    {
        return $this->hasMany('App\Models\BrandImage', 'aid');
    }

    function form_builder_array($values = array(), $template_data = array())
    {
        $view = \View::make('backend.brand.brand_images', [
            'data' => isset($template_data['images']) ? $template_data['images'] : []
        ]);
        $html = $view->render();
        $data = array(
            'group1' => array(
                'width' => '6',
                'field' => array(
                    array('label' => 'Name',
                        'name' => 'name',
                        'type' => 'text',
                        'value' => $values['name'],
                        'class' => 'form-control required',
                    ),
                    array('label' => 'Page Banner Image',
                        'name' => 'banner_image',
                        'type' => 'image', //# image byb!
                        'value' => $values['banner_image'],
                        'class' => 'form-control',
                        'onclick' => 'BrowseServer(this)',
                        'data-resource-type' => 'image',
                        'data-multiple' => "false",
                        'id' => "image_gallery_page",
                        'placeholder' => "Page Banner Image",
                        'instruction' => 'Recommended Image size: 1500 X 450px',
                    ),
                    array('label' => 'Cover Image',
                        'name' => 'cover_image',
                        'type' => 'image', //# image byb!
                        'value' => $values['cover_image'],
                        'class' => 'form-control required',
                        'onclick' => 'BrowseServer(this)',
                        'data-resource-type' => 'image',
                        'data-multiple' => "false",
                        'id' => "gallery_cover_image",
                        'placeholder' => "Brand Cover Image",
                        'instruction' => 'Recommended Image size: ' . config('site.image.w') . ' X ' . config('site.image.h') . ' px',
                    ),
                    array('label' => 'Category',
                        'name' => 'category_id',
                        'type' => 'dropdown',
                        'option' => $this->get_category_for_dropdown(8),
                        'selected' => $values['category_id'],
                        'attributes' => array('class' => "selectpicker form-control  required"),
                    ),
                    array('label' => 'Price',
                        'name' => 'price',
                        'type' => 'text',
                        'value' => $values['price'],
                        'class' => 'form-control',
                    ),
                    array('label' => 'Facebook',
                        'name' => 'facebook',
                        'type' => 'text',
                        'value' => $values['facebook'],
                        'class' => 'form-control',
                        'instruction' => 'URL must start with http:// or https://',
                    ),
                    array('label' => 'Twitter',
                        'name' => 'twitter',
                        'type' => 'text',
                        'value' => $values['twitter'],
                        'class' => 'form-control',
                        'instruction' => 'URL must start with http:// or https://',
                    ),
                    array('label' => 'Pinterest',
                        'name' => 'pinterest',
                        'type' => 'text',
                        'value' => $values['pinterest'],
                        'class' => 'form-control',
                        'instruction' => 'URL must start with http:// or https://',
                    ),
                ),
            ),
            'group2' => array(
                'width' => '6',
                'field' => array(
                    array('label' => 'HTML Keyword',
                        'name' => 'html_keyword',
                        'type' => 'text',
                        'value' => $values['html_keyword'],
                        'class' => 'form-control',
                    ),
                    array('label' => 'HML Description',
                        'name' => 'html_description',
                        'type' => 'textarea',
                        'value' => $values['html_description'],
                        'class' => 'form-control',
                    ),
                    array('label' => 'Description',
                        'name' => 'long_description',
                        'type' => 'textarea',
                        'value' => $values['long_description'],
                        'class' => 'form-control',
                        'id' => 'ckeditor',
                    ),
//                    array('label' => 'Is Featured?',
//                        'type' => 'radio',
//                        'instruction' => '(Show in homepage?)',
//                        'selected' => isset($values['featured']) ? $values['featured'] : '0',
//                        array(
//                            array('type' => 'radio',
//                                'name' => 'featured',
//                                'label' => 'Yes',
//                                'value' => '1',
//                                'id' => 'yesh'
//                            ),
//                            array('type' => 'radio',
//                                'name' => 'featured',
//                                'label' => 'No',
//                                'value' => '0',
//                                'id' => 'noh'
//                            ),
//                        ),
//                    ),
//                    array('label' => 'Is Popular?',
//                        'type' => 'radio',
//                        'instruction' => '(Show in homepage?)',
//                        'selected' => isset($values['popular']) ? $values['popular'] : '0',
//                        array(
//                            array('type' => 'radio',
//                                'name' => 'popular',
//                                'label' => 'Yes',
//                                'value' => '1',
//                                'id' => 'yesh'
//                            ),
//                            array('type' => 'radio',
//                                'name' => 'popular',
//                                'label' => 'No',
//                                'value' => '0',
//                                'id' => 'noh'
//                            ),
//                        ),
//                    ),
                    array('label' => 'Ordering',
                        'name' => 'acc_ordering',
                        'type' => 'text',
                        'instruction' => '(Only Integers.)',
                        'value' => $values['acc_ordering'],
                        'class' => 'form-control required number',
                    ),
                )
            ),
//            'group3' => array(
//                'width' => '12',
//                'field' => array(
//                    array('name' => $opening_hours_html,
//                        'type' => 'template',
//                    ),
//                )
//            ),
            'group5' => array(
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

    function get_category_for_dropdown($type_id = 2)
    {
        $record = [];
        $data = Category::where(['type' => $type_id, 'status' => 1])->where(function ($q) {
            $q->where('parent_id', 0)->orWhere('parent_id', NULL);
        })->orderBy('ordering', 'asc')->get();
        if ($data) {
            $record = make_select_option_tree($data, 'id', 'category_name', 'Category', FALSE);
        }
        return $record;
    }
}
