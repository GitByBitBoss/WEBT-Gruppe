<?php

require __DIR__ . '/vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;

$result = Builder::create()
    ->data('https://www.bwin/de-at/sports')
    ->size(300)
    ->margin(10)
    ->build();

$file = __DIR__ . '/qr-test.png';
$result->saveToFile($file);