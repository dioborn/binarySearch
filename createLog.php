<?php

$fileName = !empty($argv[1]) ? $argv[1] : "mega.log";
$logSize = !empty($argv[2]) ? $argv[2] : 1024 * 1024 * 1024 * 10;
$keySeparator = "\t";
$recSeparator = "\x0A";


$counter = 0;
$valueLength = 4000;
$file = fopen($fileName, "w");

$filesize = 0;
while ($filesize < $logSize) {
    $randomString = generateRandomString(rand(1, $valueLength));
    $string = $counter . $keySeparator . $counter . '_' . $randomString . $recSeparator;
    fwrite($file, $string);
    $counter++;
    $filesize += strlen($string);
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
