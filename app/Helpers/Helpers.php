<?php

use \Illuminate\Support\Facades\File;

if (!function_exists('deleteEmptyFolders')) {
    function deleteEmptyFolders($topPath) {
        foreach (array_reverse(explode('/', $topPath)) as $part) {
            //public_path(). "/uploads/images/..."
            if (!empty(File::glob(public_path()."/".$topPath."/*"))){
                return true;
            }
            if (!File::deleteDirectory(public_path()."/".$topPath)){
                return false;
            }
            $topPath = substr($topPath,0, -(strlen($part)+1));
        }
        return true;
    }
}

if (!function_exists('generateTopPath')) {
    function generateTopPath($path) {
        $fileName = substr($path, strlen("uploads/"));
        $fileNameArray = explode('/', $fileName);
        return substr("uploads/".$fileName, 0, -strlen(end($fileNameArray))-1);
    }
}
