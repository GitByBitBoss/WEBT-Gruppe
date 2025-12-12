<?php

// Autoloader – vendor liegt eine Ebene über "public"
require __DIR__ . '/../vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;

// ---------------------------------------------------------
// 1. Module-Daten
// ---------------------------------------------------------
$modules = [
    [
        'id'       => 1,
        'title'    => 'Car Theory Basics',
        'summary'  => 'Learn the fundamental rules of the road, signs, and right-of-way scenarios to prepare for your car theory exam.',
        'duration' => '~30 min',
        'level'    => 'Beginner',
        'materialUrl' => 'https://example.com/materials/car-theory-basics',
    ],
    [
        'id'       => 2,
        'title'    => 'Motorcycle Safety Essentials',
        'summary'  => 'Focused content for motorcycle riders: visibility, braking, lane positioning, and common risk situations.',
        'duration' => '~25 min',
        'level'    => 'Intermediate',
        'materialUrl' => 'https://example.com/materials/motorcycle-safety',
    ],
    [
        'id'       => 3,
        'title'    => 'Exam Simulator',
        'summary'  => 'Practice with timed, exam-like question sets that adapt to your performance and highlight topics to review.',
        'duration' => 'Flexible',
        'level'    => 'Mixed',
        'materialUrl' => 'https://example.com/materials/exam-simulator',
    ],
];

// ---------------------------------------------------------
// 2. Template laden (fread)
// ---------------------------------------------------------
$templatePath = __DIR__ . '/learning-modules_US7.html';

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
// 3. Loop-Block im Template finden
// ---------------------------------------------------------
$loopStartTag = '{{MODULE_LOOP_START}}';
$loopEndTag   = '{{MODULE_LOOP_END}}';

$startPos = strpos($template, $loopStartTag);
$endPos   = strpos($template, $loopEndTag);

if ($startPos === false || $endPos === false || $endPos <= $startPos) {
    http_response_code(500);
    echo "Loop tags not found or invalid in template.";
    exit;
}

$beforeLoop = substr($template, 0, $startPos);
$afterLoop  = substr($template, $endPos + strlen($loopEndTag));

$loopBlock = substr(
    $template,
    $startPos + strlen($loopStartTag),
    $endPos - ($startPos + strlen($loopStartTag))
);

// ---------------------------------------------------------
// 4. Module im Loop rendern (inkl. QR-Code)
// ---------------------------------------------------------
$renderedModules = '';

foreach ($modules as $module) {
    $id       = (int) $module['id'];
    $title    = htmlspecialchars($module['title'],   ENT_QUOTES, 'UTF-8');
    $summary  = htmlspecialchars($module['summary'], ENT_QUOTES, 'UTF-8');
    $duration = htmlspecialchars($module['duration'], ENT_QUOTES, 'UTF-8');
    $level    = htmlspecialchars($module['level'],    ENT_QUOTES, 'UTF-8');

    $materialUrl = isset($module['materialUrl']) ? $module['materialUrl'] : '';

    // QR-Code erzeugen – mit Enum ErrorCorrectionLevel
    $qrResult = Builder::create()
        ->writer(new PngWriter())
        ->data($materialUrl)
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel(ErrorCorrectionLevel::High)
        ->size(200)
        ->margin(10)
        ->build();

    // Data-URI für <img src="...">
    $qrDataUri = $qrResult->getDataUri();

    // Platzhalter im Loop-Block ersetzen
    $moduleHtml = str_replace(
        ['{{ID}}', '{{TITLE}}', '{{SUMMARY}}', '{{DURATION}}', '{{LEVEL}}', '{{QR_CODE_SRC}}'],
        [$id,      $title,      $summary,      $duration,      $level,      $qrDataUri],
        $loopBlock
    );

    $renderedModules .= $moduleHtml . "\n";
}

// Template mit gerenderten Modulen zusammensetzen
$templateWithModules = $beforeLoop . $renderedModules . $afterLoop;

// ---------------------------------------------------------
// 5. Weitere Platzhalter (HEREDOC für längere Texte)
// ---------------------------------------------------------
$pageTitle = 'Learning Modules – DriveWell Prototype';

$headerTitle = 'Learning Modules (Prototype)';

$headerSubtitle = <<<TXT
This page is rendered through a simple PHP templating system.
All module information is stored in PHP arrays and injected into this HTML template.
Each module card shows a QR code linking to its lesson materials.
TXT;

$footerText = 'Prototype only – layout and content are for demonstration purposes.';

$placeholders = [
    '{{PAGE_TITLE}}',
    '{{HEADER_TITLE}}',
    '{{HEADER_SUBTITLE}}',
    '{{FOOTER_TEXT}}',
];

$values = [
    $pageTitle,
    $headerTitle,
    $headerSubtitle,
    $footerText,
];

$output = str_replace($placeholders, $values, $templateWithModules);

// ---------------------------------------------------------
// 6. HTML ausgeben
// ---------------------------------------------------------
echo $output;
