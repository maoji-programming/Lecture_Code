<?php
$incoming_file = '.\rose.jpg';
$img = new \Imagick();
$img->readImage(realpath($incoming_file));
//echo realpath($incoming_file);

// If 0 is provided as a width or height parameter,
// aspect ratio is maintained
$img->thumbnailImage(1024, 768, TRUE);

header('Content-type: image/jpeg');
echo $img;
?>
