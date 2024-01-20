<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HireImage extends Model {

    protected $dateFormat = 'U';

    public function Hire() {
        return $this->belongsToMany('App\hire');
    }

}
