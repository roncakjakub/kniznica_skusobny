<?php

namespace App;

use App\Traits\HasResource;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $hidden = ['contentable_type', 'contentable_id'];
    public $timestamps = false;
    use HasResource;

    public function model(){
        return $this->morphTo('contentable');
    }

}
