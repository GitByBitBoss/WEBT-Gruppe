<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\OpenSans;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

$result = Builder::create()
    ->writer(new PngWriter())
    ->writerOptions([])
    ->data('https://youtube.com')
    ->encoding(new Encoding('UTF-8'))
    ->errorCorrectionLevel(ErrorCorrectionLevel::High)
    ->size(300)
    ->margin(10)
    ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
    ->labelText('This is the label')
    ->labelFont(new OpenSans(20))
    ->labelAlignment(LabelAlignment::Center)
    ->validateResult(false)
    ->build();

header('Content-Type: '.$result->getMimeType());
echo $result->getString();

// Save to file
$result->saveToFile(__DIR__ . '/qrcode.png');

// Data URI
$dataUri = $result->getDataUri();
