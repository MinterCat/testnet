<?php
$png = $_GET['png'];
$src = __DIR__ . "/static/img/Cat$png.webp";
$info = pathinfo($src);

$img = imageCreatefromWebp($src);
imagePng($img, $info['dirname'] . '/' . $info['filename'] . '.png');

header('Content-Type: image/x-png');
imagePng($img);
