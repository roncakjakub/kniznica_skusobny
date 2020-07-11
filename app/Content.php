<?php

namespace App;

use App\Traits\HasResources;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $hidden = ['contentable_type', 'contentable_id'];
    public $timestamps = false;
    use HasResources;

    public function model(){
        return $this->morphTo('contentable');
    }

}
