<?php
header('Content-Type: image/png');

$img = $data['image'];

imagepng($img);
imagedestroy($img);
?>