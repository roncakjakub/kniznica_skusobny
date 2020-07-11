<?php

namespace App;

use App\Traits\Contentable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Resource extends Model
{
    use Contentable;
    protected $hidden = ['resourcable_type', 'resourcable_id', 'url', 'minified_url','content'];
    protected $appends = ['url_asset', 'minified_url_asset','name','description'];
    /*public function getFileAttribute(){
        return Storage::disk("eshop_1")->get($this->url);
    }*/
    public function getUrlAssetAttribute(){
        return $this->url ? asset($this->url) : null;
    }

    public function getMinifiedUrlAssetAttribute(){

        return $this->minified_url ? asset($this->minified_url) : null;
    }
    public function getNameAttribute(){
        return $this->content ? $this->content->header : null;
    }
    public function getDescriptionAttribute(){
        return $this->content ? $this->content->main_text : null;
    }

}
