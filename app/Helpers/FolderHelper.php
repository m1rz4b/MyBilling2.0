<?php

namespace App\Helpers;
use Illuminate\Support\Facades\File;


function createClientFolders($path)
{
    if (!File::isDirectory($path)) {
        File::makeDirectory($path, 0777, true, true);
    }
    foreach(range('A', 'Z') as $elements) {
        if (!File::isDirectory($path+$elements)) {
            File::makeDirectory($path+$elements, 0777, true, true);
        }
    }
}
function createFolders($path)
{
    if (!File::isDirectory($path)) {
        File::makeDirectory($path, 0777, true, true);
    }
}