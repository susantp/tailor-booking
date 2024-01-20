<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuitImage extends Model {

    protected $dateFormat = 'U';

    public function Climber() {
        return $this->belongsToMany('App\suit');
    }

}
