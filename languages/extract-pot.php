<?php
/**
 * POT File Generator for Funnel Services Form
 * Extracts all translation strings from PHP files
 */

$plugin_slug = 'funnel-services-form';
$plugin_dir = dirname(__DIR__);
$pot_file = __DIR__ . "/{$plugin_slug}.pot";

// POT header
$pot_content = <<<POT
# Copyright (C) 2024 Yisus Develop
# This file is distributed under the GNU General Public License v3.0.
# POT Template for Funnel Services Form

msgid ""
msgstr ""
"Project-Id-Version: EWEB - Funnel Services Form 1.4.3\\n"
"Report-Msgid-Bugs-To: https://github.com/Yisus-Develop\\n"
"Last-Translator: FULL NAME <EMAIL@ADDRESS>\\n"
"Language-Team: LANGUAGE <LL@li.org>\\n"
"Language: \\n"
"MIME-Version: 1.0\\n"
"Content-Type: text/plain; charset=UTF-8\\n"
"Content-Transfer-Encoding: 8bit\\n"
"POT-Creation-Date: 2025-01-25T00:00:00+00:00\\n"
"PO-Revision-Date: YEAR-MO-DA HO:MI+ZONE\\n"
"X-Generator: Custom PHP Extractor\\n"
"X-Domain: funnel-services-form\\n"


POT;

// Find all PHP files
$php_files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($plugin_dir, RecursiveDirectoryIterator::SKIP_DOTS)
);

$strings = [];

foreach ($php_files as $file) {
    if ($file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        
        // Extract __() function calls
        preg_match_all(
            '/__\s*\(\s*[\'"](.+?)[\'"]\s*,\s*[\'"]' . preg_quote($plugin_slug, '/') . '[\'"]\s*\)/',
            $content,
            $matches
        );
        
        foreach ($matches[1] as $string) {
            $strings[$string] = $file->getPathname();
        }
        
        // Extract _e() function calls
        preg_match_all(
            '/_e\s*\(\s*[\'"](.+?)[\'"]\s*,\s*[\'"]' . preg_quote($plugin_slug, '/') . '[\'"]\s*\)/',
            $content,
            $matches
        );
        
        foreach ($matches[1] as $string) {
            $strings[$string] = $file->getPathname();
        }
    }
}

// Sort strings alphabetically
ksort($strings);

// Generate POT entries
foreach ($strings as $string => $file) {
    $relative_file = str_replace($plugin_dir . DIRECTORY_SEPARATOR, '', $file);
    $relative_file = str_replace('\\', '/', $relative_file);
    
    $pot_content .= "\n#: {$relative_file}\n";
    $pot_content .= "msgid \"" . addslashes($string) . "\"\n";
    $pot_content .= "msgstr \"\"\n";
}

// Write POT file
file_put_contents($pot_file, $pot_content);

echo "[POT Generator] POT file updated successfully!\n";
echo "[POT Generator] Found " . count($strings) . " unique translatable strings\n";
echo "[POT Generator] POT file saved to: {$pot_file}\n";
