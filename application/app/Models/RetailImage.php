<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RetailImage extends Model {

    protected $dateFormat = 'U';

    public function Retail() {
        return $this->belongsToMany('App\retail');
    }

}
