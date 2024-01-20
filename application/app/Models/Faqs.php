<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faqs extends Model {

    protected $dateFormat = 'U';
    protected $fillable = [
        'faq_question',
        'faq_answer',
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
                    array('label' => 'FAQ Question',
                        'name' => 'faq_question',
                        'type' => 'text',
                        'value' => $values['faq_question'],
                        'class' => 'form-control',
                    ),
                    array('label' => 'FAQ Answer',
                        'name' => 'faq_answer',
                        'type' => 'textarea',
                        'value' => $values['faq_answer'],
                        'class' => 'form-control',
                        'id' => 'ckeditor',
                    ),
                    array('label' => 'Ordering',
                        'name' => 'ordering',
                        'type' => 'text',
                        'instruction' => '(Only Integers.)',
                        'value' => $values['ordering'],
                        'class' => 'form-control ',
                    ),
                ),
            )
        );
        return $data;
    }

}
