<?php
/**
 * Force rebuild MO files from PO files
 * Run: php rebuild-mo.php
 */

$locales = ['es_ES', 'pt_PT'];
$textdomain = 'funnel-services-form';

foreach ($locales as $locale) {
    $po_file = __DIR__ . "/{$textdomain}-{$locale}.po";
    $mo_file = __DIR__ . "/{$textdomain}-{$locale}.mo";
    
    if (!file_exists($po_file)) {
        echo "Warning: PO file not found for {$locale}\n";
        continue;
    }
    
    // Delete existing MO
    if (file_exists($mo_file)) {
        unlink($mo_file);
        echo "Deleted old MO: {$mo_file}\n";
    }
    
    // Parse PO and create MO
    $translations = [];
    $po_content = file_get_contents($po_file);
    
    // Extract all msgid/msgstr pairs (handle multiline strings)
    preg_match_all('/msgid\s+"([^"]+)"\s+msgstr\s+"([^"]+)"/s', $po_content, $matches, PREG_SET_ORDER);
    
    foreach ($matches as $match) {
        $msgid = stripcslashes($match[1]);
        $msgstr = stripcslashes($match[2]);
        
        if (!empty($msgid) && !empty($msgstr)) {
            $translations[$msgid] = $msgstr;
        }
    }
    
    echo "Found " . count($translations) . " translations for {$locale}\n";
    
    // Create MO file using PHP's MO_Translator class if available
    // Otherwise use simple binary format
    $mo_data = '';
    
    // MO file header
    $magic = 0x950412de; // Little endian magic
    $revision = 0;
    $count = count($translations);
    
    $originals_offset = 28;
    $translations_offset = $originals_offset + ($count * 8);
    
    // Build string tables
    $originals_table = '';
    $translations_table = '';
    $originals_index = [];
    $translations_index = [];
    
    $string_offset = $translations_offset + ($count * 8);
    
    foreach ($translations as $msgid => $msgstr) {
        $originals_index[] = [strlen($msgid), $string_offset];
        $originals_table .= $msgid . "\0";
        $string_offset += strlen($msgid) + 1;
        
        $translations_index[] = [strlen($msgstr), $string_offset];
        $translations_table .= $msgstr . "\0";
        $string_offset += strlen($msgstr) + 1;
    }
    
    // Build MO file
    $mo_data = pack('L', $magic);
    $mo_data .= pack('L', $revision);
    $mo_data .= pack('L', $count);
    $mo_data .= pack('L', $originals_offset);
    $mo_data .= pack('L', $translations_offset);
    $mo_data .= pack('L', 0); // hash table size
    $mo_data .= pack('L', 0); // hash table offset
    
    // Add originals index
    foreach ($originals_index as $entry) {
        $mo_data .= pack('L', $entry[0]);
        $mo_data .= pack('L', $entry[1]);
    }
    
    // Add translations index
    foreach ($translations_index as $entry) {
        $mo_data .= pack('L', $entry[0]);
        $mo_data .= pack('L', $entry[1]);
    }
    
    // Add string tables
    $mo_data .= $originals_table . $translations_table;
    
    file_put_contents($mo_file, $mo_data);
    echo "Created MO file: {$mo_file} (" . filesize($mo_file) . " bytes)\n";
}

echo "\nMO rebuild complete!\n";
