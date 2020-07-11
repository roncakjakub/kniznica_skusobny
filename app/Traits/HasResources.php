<?php
namespace App\Traits;

use App\Resource;

trait HasResources {
    public function resources(){
        return $this->morphMany(Resource::class, 'resourcable');
    }
    public function getIconAttribute(){
        return $this->resources()->where('type', 'icon')->first();
    }
    public function getImagesAttribute(){
        return $this->resources()->where('type', 'image')->orderBy('position')->orderBy('is_main')->get();
    }
    public function getAttachmentsAttribute(){
        return $this->resources()->where('type', 'attachment')->get();
    }


}
