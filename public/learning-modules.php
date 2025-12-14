<?php
// Module data (can come from DB later, but for now just arrays)
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

// Build module cards HTML using HEREDOC
$moduleCardsHtml = '';

foreach ($modules as $module) {
    // escape basic text to be safe
    $id       = (int) $module['id'];
    $title    = htmlspecialchars($module['title'],   ENT_QUOTES, 'UTF-8');
    $summary  = htmlspecialchars($module['summary'], ENT_QUOTES, 'UTF-8');
    $duration = htmlspecialchars($module['duration'], ENT_QUOTES, 'UTF-8');
    $level    = htmlspecialchars($module['level'],    ENT_QUOTES, 'UTF-8');

    $moduleCardsHtml .= <<<HTML
<article class="module-card">
    <span class="module-tag">Module {$id}</span>
    <h2>{$title}</h2>
    <p>{$summary}</p>
    <p class="meta">Duration: {$duration} · Level: {$level}</p>
</article>

HTML;
}

// --- Basic templating engine using fread + str_replace ---

$templatePath = __DIR__ . '/learning-modules.html';

if (!is_readable($templatePath)) {
    http_response_code(500);
    echo "Template file not found.";
    exit;
}

$handle = fopen($templatePath, 'r');
$template = '';

if ($handle !== false) {
    $template = fread($handle, filesize($templatePath));
    fclose($handle);
}

// Values for placeholders (also using HEREDOC for longer text)
$pageTitle = 'Learning Modules – DriveWell Prototype';

$headerTitle = 'Learning Modules (Prototype)';
$headerSubtitle = <<<TXT
This page is rendered through a simple PHP templating system.
All module information is stored in arrays and injected into this HTML template.
TXT;

$footerText = 'Prototype only – layout and content are for demonstration purposes.';

// Replace placeholders
$placeholders = [
    '{{PAGE_TITLE}}',
    '{{HEADER_TITLE}}',
    '{{HEADER_SUBTITLE}}',
    '{{MODULE_CARDS}}',
    '{{FOOTER_TEXT}}',
];

$values = [
    $pageTitle,
    $headerTitle,
    $headerSubtitle,
    $moduleCardsHtml,
    $footerText,
];

$output = str_replace($placeholders, $values, $template);

// Send final HTML to browser
echo $output;
