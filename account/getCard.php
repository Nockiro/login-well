<?php

header("Content-Type: image/jpeg");
$img = ImageCreateFromPNG("../cardsimg/" . filter_input(INPUT_GET, 'img', FILTER_SANITIZE_NUMBER_INT) . ".png");
imagejpeg($img);
?>
