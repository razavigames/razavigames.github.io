
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

       $imgt($new_image, "C:/xampp/htdocs/razavigames.github.io/thumbs/".$id."_t.jpg");
        return;    
    }
}





echo '<div id="photos">';
$id = 1;
if ($handle = opendir('./images/tall')) {

    while (false !== ($entry = readdir($handle))) {

        if ($entry != "." && $entry != "..") {

            //echo "$entry\n";
			makeThumbnails("C:/xampp/htdocs/razavigames.github.io/images/tall", "C:/xampp/htdocs/razavigames.github.io/images/tall/".$entry, $id, $MaxWe=800,$MaxHe=800);
			array_push($images, array("lowsrc"=>"thumbs/".$id."_t.jpg", "fullsrc"=>"images/tall/".$entry) );
			 
			echo '<img src="thumbs/'.$id.'_t.jpg">';
			 //echo '<img src="images/tall/'.$entry.'">';
			 $id++;
        }
    }

    closedir($handle);
}

echo "
</div>
";
echo '<div id="photosWide">';
$wideImages = array();

if ($handle = opendir('./images/billiard-android')) {

    while (false !== ($entry = readdir($handle))) {

        if ($entry != "." && $entry != "..") {

            //echo "$entry\n";
			makeThumbnails("C:/xampp/htdocs/razavigames.github.io/images/billiard-android", "C:/xampp/htdocs/razavigames.github.io/images/billiard-android/".$entry, $id, $MaxWe=800,$MaxHe=800);
			array_push($wideImages, array("lowsrc"=>"thumbs/".$id."_t.jpg", "fullsrc"=>"images/billiard-android/".$entry) );
			 echo '<img src="thumbs/'.$id.'_t.jpg">';
			 //echo '<img src="images/billiard-android/'.$entry.'">';
			 $id++;
        }
    }

    closedir($handle);
}

echo "
</div>
";
echo '<div id="photosWide">';
$wideImages = array();

if ($handle = opendir('./images/wide')) {

    while (false !== ($entry = readdir($handle))) {

        if ($entry != "." && $entry != "..") {

            //echo "$entry\n";
			makeThumbnails("C:/xampp/htdocs/razavigames.github.io/images/wide", "C:/xampp/htdocs/razavigames.github.io/images/wide/".$entry, $id, $MaxWe=800,$MaxHe=800);
			array_push($wideImages, array("lowsrc"=>"thumbs/".$id."_t.jpg", "fullsrc"=>"images/wide/".$entry) );
			 echo '<img src="thumbs/'.$id.'_t.jpg">';
			 //echo '<img src="images/wide/'.$entry.'">';
			 $id++;
        }
    }

    closedir($handle);
}
echo "
</div>
";

exit;
$images = array_reverse($images);
echo json_encode($images);

echo "<hr>";

echo json_encode($wideImages);

?>
</html>