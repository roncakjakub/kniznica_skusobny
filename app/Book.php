<?php

namespace App;

use App\Traits\Contentable;
use App\Traits\HasResources;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasResources, Contentable;
}
