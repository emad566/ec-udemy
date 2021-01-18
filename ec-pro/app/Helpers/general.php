<?php

define('PAGINATION_COUNT', 10);
function delete_img($img_path){
    if (file_exists($img_path)) {
        unlink($img_path);
    }
}

// function getFolder()
// {

//     return app()->getLocale() == 'ar' ? 'css-rtl' : 'css';
// }


// function uploadImage($folder,$image){
//     $image->store('/', $folder);
//     $filename = $image->hashName();
//     return  $filename;
//  }
