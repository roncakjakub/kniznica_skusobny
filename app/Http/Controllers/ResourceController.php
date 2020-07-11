<?php

namespace App\Http\Controllers;

use App\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ResourceController extends Controller
{
    private function generateAddress($file):String{
        $folderHash = md5(/*auth()->user()->id.*/date('D H:m'));

        $adr = "";
        $adr .= str_split($folderHash, 4)[0].'/';
        $adr .= str_split($folderHash, 4)[1].'/';
        $adr .= str_split($folderHash, 4)[2].'/';
        $adr .= str_split($folderHash, 4)[3].'/';
        $adr .= str_split($folderHash, 4)[4].'/';
        $adr .= str_split($folderHash, 4)[5];


        return $adr;
    }
    //ukladá obrázky obsahu
    public function StoreImage(Request $request, $width = 800){

        $data = $request->all();
        $ret = ["status" => 400,"data"=>[]];
        $validator = Validator::make(
            $request->all(), [
                'image' => 'required|image',
            ]
        );
        if ($validator->fails()) {

            $ret['status'] = 422;

        } else {
            $file = $data['image'];

            $fileName = $file->getClientOriginalName();
            $address  =$this->generateAddress($file);
            $extension = pathinfo($fileName, PATHINFO_EXTENSION);
            $name = round(microtime(true) * 1000).substr(md5_file($file), 0,6);
            $url = "";
            if ($extension != "svg") {
                $imageToupload = Image::make($file)->resize($width, null, function ($constraint) {
                    $constraint->aspectRatio();
                })/*->encode('jpg',80)*/->save('my-image.jpg', 80);
                $extension = "jpg";
                if(Storage::disk('public_uploads')->put('images/'.$address."/".$name.".jpg",$imageToupload)) {
                    $url = 'uploads/images/'.$address."/".$name.".jpg";
                    $ret["data"]["url"] = $url;
                    $ret["status"] = 200;
                }

            } else {
                if($fullurl = $file->store('images/'.$address."/", ['disk' => 'public_uploads'])) {
                    $url = 'uploads/'.$fullurl;
                    $ret["data"]["url"] = $url;
                    $ret["status"] = 200;
                }
            }
        }

        return response()->json($ret["data"], $ret["status"]);
    }
    public function StoreFile(Request $request){

        $data = $request->all();
        $ret = ["status" => 400,"data"=>[]];
        $validator = Validator::make(
            $request->all(), [
                'file' => 'required|file',
            ]
        );
        if ($validator->fails()) {

            $ret['status'] = 422;

        } else {
            $file = $data['file'];

            $fileName = $file->getClientOriginalName();
            $address  =$this->generateAddress($file);
            $extension = pathinfo($fileName, PATHINFO_EXTENSION);
            $name = round(microtime(true) * 1000).substr(md5_file($file), 0,6);
            $url = "";
            if($fullurl = $file->store('files/'.$address."/", ['disk' => 'public_uploads'])) {
                $url = 'uploads/'.$fullurl;
                $ret["data"]["url"] = $url;
                $ret["status"] = 200;
            }
        }

        return response()->json($ret["data"], $ret["status"]);
    }

    public function destroy(Resource $resource) {

        if ($resource->url) {

            if(!Storage::disk('public_uploads')->delete(substr($resource->url,strlen('uploads/')))) {
                abort(500);
            }
            deleteEmptyFolders(generateTopPath($resource->url));
        }
        if ($resource->minified_url) {
            if(!Storage::disk('public_uploads')->delete(substr($resource->minified_url,strlen('uploads/')))) {
                abort(500);
            }
            deleteEmptyFolders(generateTopPath($resource->minified_url));
        }
        if ($resource->content()->exists()) {

            if(!$resource->content()->delete()) {
                abort(500);
            }
        }
        if (!$resource->delete()) {
            abort(500);
        }
        return response()->json([], 200);

    }
}
