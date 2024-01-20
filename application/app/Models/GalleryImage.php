<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model {
 
    protected $dateFormat = 'U';

    public function gallery() {
        return $this->belongsToMany('App\gallery');
    }   
}
