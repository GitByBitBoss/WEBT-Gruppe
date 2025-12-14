<?php

// Autoloader – vendor liegt eine Ebene über "public"
require __DIR__ . '/../vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;

// ---------------------------------------------------------
// 1. Request-Daten einlesen & validieren
// ---------------------------------------------------------
$lessonIdRaw = $_GET['lessonId'] ?? '';
$lessonId = trim($lessonIdRaw);

$errorMessageHtml = '';
$qrResultHtml = '<p class="help-text">Gib eine Lesson ID ein und klicke auf „QR Code generieren“.</p>';

// Regex: 3–20 Zeichen, Buchstaben/Zahlen/Bindestrich
$pattern = '/^[A-Za-z0-9-]{3,20}$/';

if ($lessonId !== '') {
    if (!preg_match($pattern, $lessonId)) {
        $errorMessageHtml = '<div class="error-message">Die Lesson ID ist ungültig. Bitte verwende 3–20 Zeichen (A–Z, 0–9, -).</div>';
    } else {
        // Gültige Lesson ID -> QR-Code erzeugen
        // Beispiel: wir kodieren eine URL, könnte auch ein anderes Schema sein
        $lessonUrl = 'https://example.com/lessons/' . urlencode($lessonId);

        $qrResult = Builder::create()
            ->writer(new PngWriter())
            ->data($lessonUrl)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(220)
            ->margin(10)
            ->build();

        $qrDataUri = $qrResult->getDataUri();

        $safeLessonId = htmlspecialchars($lessonId, ENT_QUOTES, 'UTF-8');
        $safeLessonUrl = htmlspecialchars($lessonUrl, ENT_QUOTES, 'UTF-8');

        $qrResultHtml = <<<HTML
<h2>QR Code für Lesson ID „{$safeLessonId}“</h2>
<div class="qr-wrapper">
    <img src="{$qrDataUri}" alt="QR code for lesson {$safeLessonId}" />
</div>
<p class="qr-caption">Enthält: {$safeLessonUrl}</p>
HTML;
    }
}

// ---------------------------------------------------------
// 2. Template laden
// ---------------------------------------------------------
$templatePath = __DIR__ . '/learning-modules_US8.html';

if (!is_readable($templatePath)) {
    http_response_code(500);
    echo "Template file not found: " . htmlspecialchars($templatePath);
    exit;
}

$handle = fopen($templatePath, 'r');
if ($handle === false) {
    http_response_code(500);
    echo "Could not open template file.";
    exit;
}

$templateSize = filesize($templatePath);
$template = $templateSize > 0 ? fread($handle, $templateSize) : '';
fclose($handle);

if ($template === '') {
    http_response_code(500);
    echo "Template file is empty.";
    exit;
}

// ---------------------------------------------------------
// 3. Platzhalter ersetzen (Templating-System)
// ---------------------------------------------------------
$pageTitle = 'Interactive Lesson QR Code Generator';
$headerTitle = 'Interactive QR Code Generator';

$headerSubtitle = <<<TXT
Enter a lesson ID, generate a QR code, and use it to quickly access lesson materials.
This page is rendered using the same simple PHP templating system.
TXT;

$placeholders = [
    '{{PAGE_TITLE}}',
    '{{HEADER_TITLE}}',
    '{{HEADER_SUBTITLE}}',
    '{{FORM_ACTION}}',
    '{{LESSON_ID_VALUE}}',
    '{{ERROR_MESSAGE}}',
    '{{QR_RESULT}}',
];

$values = [
    $pageTitle,
    $headerTitle,
    $headerSubtitle,
    htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'),
    htmlspecialchars($lessonId, ENT_QUOTES, 'UTF-8'),
    $errorMessageHtml,
    $qrResultHtml,
];

$output = str_replace($placeholders, $values, $template);

// ---------------------------------------------------------
// 4. HTML ausgeben
// ---------------------------------------------------------
echo $output;
