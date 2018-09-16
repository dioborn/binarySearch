<?php

include_once 'BinarySearch.php';

$fileName = !empty($argv[1]) ? $argv[1] : "mega.log";
$key = isset($argv[2]) ? $argv[2] : '1234567';
$debug = !empty($argv[3]) ? true : false;

$start = microtime(true);

$search = new BinarySearch();
$search->setDebug($debug);
$result = $search->run($fileName, $key);

$end = microtime(true);

echo "\nKey: " . $key;
echo "\nValue: " . var_export($result, true);
echo "\nScript execution time: " . ($end - $start) . " seconds.";
echo "\nIterations: " . $search->getIterations() . "\n";
