<?php
namespace App\Traits;

use App\Content;

trait Contentable {
    public function content(){
        return $this->morphOne(Content::class, 'contentable');
    }

}
