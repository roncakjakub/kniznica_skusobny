<?php

namespace App;

use App\Traits\Contentable;
use App\Traits\HasResource;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasResource, Contentable;

    public function genre() {
        return $this->belongsTo(Genre::class);
    }
}
