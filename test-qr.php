<?php

require __DIR__ . '/vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;

$result = Builder::create()
    ->data('Hello from Docker!')
    ->size(300)
    ->margin(10)
    ->build();

$file = __DIR__ . '/qr-test.png';
$result->saveToFile($file);

echo "QR Code created: " . $file;
