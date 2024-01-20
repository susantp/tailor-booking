<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandImage extends Model {

    protected $dateFormat = 'U';

    public function Brand() {
        return $this->belongsToMany('App\Brand');
    }

}
