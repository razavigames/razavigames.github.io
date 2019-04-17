<?php

$images = array();


function makeThumbnails($updir, $img, $id,$MaxWe=100,$MaxHe=150){
    $arr_image_details = getimagesize($img); 
    $width = $arr_image_details[0];
    $height = $arr_image_details[1];

    $percent = 100;
    if($width > $MaxWe) $percent = floor(($MaxWe * 100) / $width);

    if(floor(($height * $percent)/100)>$MaxHe)  
    $percent = (($MaxHe * 100) / $height);

    if($width > $height) {
        $newWidth=$MaxWe;
        $newHeight=round(($height*$percent)/100);
    }else{
        $newWidth=round(($width*$percent)/100);
        $newHeight=$MaxHe;
    }

    if ($arr_image_details[2] == 1) {
        $imgt = "ImageGIF";
        $imgcreatefrom = "ImageCreateFromGIF";
    }
    if ($arr_image_details[2] == 2) {
        $imgt = "ImageJPEG";
        $imgcreatefrom = "ImageCreateFromJPEG";
    }
    if ($arr_image_details[2] == 3) {
        $imgt = "ImagePNG";
        $imgcreatefrom = "ImageCreateFromPNG";
    }


    if ($imgt) {
        $old_image = $imgcreatefrom($img);
        $new_image = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresized($new_image, $old_image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

       $imgt($new_image, $updir."/../thumbs/".$id."_t.jpg");
        return;    
    }
}

 $id = 1;
if ($handle = opendir('./images')) {

    while (false !== ($entry = readdir($handle))) {

        if ($entry != "." && $entry != "..") {

            //echo "$entry\n";
			//makeThumbnails("C:/xampp/htdocs/imagesss/images", "C:/xampp/htdocs/imagesss/images/".$entry, $id, $MaxWe=400,$MaxHe=400);
			array_push($images, array("lowsrc"=>"images/".$entry) );
			 $id++;
        }
    }

    closedir($handle);
}

$images = array_reverse($images);
echo json_encode($images);