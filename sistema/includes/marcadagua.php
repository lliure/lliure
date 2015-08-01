<?php

header("Content-type: image/jpeg;"); 
$i = imagecreatefromjpeg($_GET['img']); 
$i2 = imagecreatefromgif("../../imagens/logo.gif"); 

$marX = imagesx($i2);
$marY = imagesy($i2);

$funX = imagesx($i);
$funY = imagesy($i);

imagecopymerge($i, $i2, $funX-$marX, $funY-$marY, 0,0, $marX, imagesy($i2), 30); //cordenas

imagejpeg($i); 
imagedestroy($i); 

?>