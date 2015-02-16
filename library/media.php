<?php 
//upload image
function imag_uplod($file,$newfile,$max_filesize,$updir, $img, $id,$MaxWe,$MaxHe){
$allowed_filetypes = array('.jpg','.jpeg','.png');
$filename = $file['name'];
$ext = strtolower(substr($filename, strpos($filename,'.'), strlen($filename)-1));

if(!in_array($ext,$allowed_filetypes))
  die('The file you attempted to upload is not allowed.');

if(filesize($file['tmp_name']) > $max_filesize)
  die('The file you attempted to upload is too large.');

if(move_uploaded_file($file['tmp_name'],$newfile.$ext)) {
	
	//creating thumbs
	makeThumbnails($updir, $img.$ext, $id,$MaxWe,$MaxHe);
	
	$errors='';
	
} else {
     $errors= 'There was an error during the file upload.  Please try again.';
}
return $errors;
//end of function
}	


function makeThumbnails($updir, $img, $id,$MaxWe,$MaxHe){
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
		imagecopyresampled($new_image, $old_image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

       $imgt($new_image, $updir.".jpg");
        return;    
    }
}




		


?>