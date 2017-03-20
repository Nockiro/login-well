<?php

header("Content-Type: image/jpeg");
$img = ImageCreateFromPNG("../cardsimg/" . $_GET['img'] . ".png");
imagejpeg($img);
?>
