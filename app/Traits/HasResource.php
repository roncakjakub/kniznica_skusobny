<?php
namespace App\Traits;

use App\Resource;

trait HasResource {
    public function resource(){
        return $this->morphOne(Resource::class, 'resourcable');
    }
}

