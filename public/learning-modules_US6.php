<?php
// ---------------------------------------------------------
// Module-Daten (können später aus DB kommen)
// ---------------------------------------------------------
$modules = [
    [
        'id'       => 1,
        'title'    => 'Car Theory Basics',
        'summary'  => 'Learn the fundamental rules of the road, signs, and right-of-way scenarios to prepare for your car theory exam.',
        'duration' => '~30 min',
        'level'    => 'Beginner',
    ],
    [
        'id'       => 2,
        'title'    => 'Motorcycle Safety Essentials',
        'summary'  => 'Focused content for motorcycle riders: visibility, braking, lane positioning, and common risk situations.',
        'duration' => '~25 min',
        'level'    => 'Intermediate',
    ],
    [
        'id'       => 3,
        'title'    => 'Exam Simulator',
        'summary'  => 'Practice with timed, exam-like question sets that adapt to your performance and highlight topics to review.',
        'duration' => 'Flexible',
        'level'    => 'Mixed',
    ],
];

// ---------------------------------------------------------
// Template laden (fread) 
// ---------------------------------------------------------
$templatePath = __DIR__ . '/learning-modules_US6.html';

if (!is_readable($templatePath)) {
    http_response_code(500);
    echo "Template file not found.";
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
// Loop-Block im Template finden
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

// Bereich vor dem Loop, Loop-Block, Bereich nach dem Loop
$beforeLoop = substr($template, 0, $startPos);
$afterLoop  = substr($template, $endPos + strlen($loopEndTag));

$loopBlock = substr(
    $template,
    $startPos + strlen($loopStartTag),
    $endPos - ($startPos + strlen($loopStartTag))
);

// ---------------------------------------------------------
// Loop: Module-HTML dynamisch aus Array generieren
// ---------------------------------------------------------
$renderedModules = '';

foreach ($modules as $module) {
    $id       = (int) $module['id'];
    $title    = htmlspecialchars($module['title'],   ENT_QUOTES, 'UTF-8');
    $summary  = htmlspecialchars($module['summary'], ENT_QUOTES, 'UTF-8');
    $duration = htmlspecialchars($module['duration'], ENT_QUOTES, 'UTF-8');
    $level    = htmlspecialchars($module['level'],    ENT_QUOTES, 'UTF-8');

    // Platzhalter innerhalb des Loop-Blocks ersetzen
    $moduleHtml = str_replace(
        ['{{ID}}', '{{TITLE}}', '{{SUMMARY}}', '{{DURATION}}', '{{LEVEL}}'],
        [$id,      $title,      $summary,      $duration,      $level],
        $loopBlock
    );

    $renderedModules .= $moduleHtml . "\n";
}

// Template wieder zusammenbauen: vor Loop + gerenderte Module + nach Loop
$templateWithModules = $beforeLoop . $renderedModules . $afterLoop;

// ---------------------------------------------------------
// Weitere Platzhalter (HEREDOC für längere Texte)
// ---------------------------------------------------------
$pageTitle = 'Learning Modules – DriveWell Prototype';

$headerTitle = 'Learning Modules (Prototype)';

$headerSubtitle = <<<TXT
This page is rendered through a simple PHP templating system.
All module information is stored in PHP arrays and injected into this HTML template.
TXT;

$footerText = 'Prototype only – layout and content are for demonstration purposes.';

// Einfache Platzhalter-Ersetzung (ohne Loop)
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
// Fertiges HTML ausgeben
// ---------------------------------------------------------
echo $output;
