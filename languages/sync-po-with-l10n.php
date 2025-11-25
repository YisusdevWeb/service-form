<?php
// Safe PO synchronizer: fills empty msgstr using existing l10n dictionaries.
// Usage: php sync-po-with-l10n.php

declare(strict_types=1);

function loadDictionary(string $l10nPath): array {
    if (!file_exists($l10nPath)) {
        throw new RuntimeException("Dictionary not found: {$l10nPath}");
    }
    $data = include $l10nPath;
    if (!is_array($data) || !isset($data['messages']) || !is_array($data['messages'])) {
        throw new RuntimeException("Invalid l10n dictionary structure: {$l10nPath}");
    }
    return $data['messages'];
}

function escapePoString(string $s): string {
    // Escape backslashes and quotes for PO syntax
    $s = str_replace('\\', '\\\\', $s);
    $s = str_replace('"', '\\"', $s);
    return $s;
}

function syncPo(string $poPath, array $dictionary): array {
    if (!file_exists($poPath)) {
        throw new RuntimeException("PO file not found: {$poPath}");
    }
    $lines = file($poPath);
    $out = [];

    $currentMsgId = null;
    $collectingMsgId = false;
    $msgIdBuffer = '';
    $modifiedCount = 0;
    $emptyCountBefore = 0;

    foreach ($lines as $i => $line) {
        $trim = trim($line);

        // Detect start of msgid
        if (strpos($trim, 'msgid ') === 0) {
            $collectingMsgId = true;
            // Extract first quoted part
            $first = preg_replace('/^msgid\s+"(.*)"$/', '$1', $trim);
            $msgIdBuffer = $first !== null ? stripcslashes($first) : '';
            $currentMsgId = $msgIdBuffer;
            $out[] = $line;
            continue;
        }

        // If collecting msgid, concatenate continued lines
        if ($collectingMsgId && strlen($trim) > 0 && $trim[0] === '"') {
            $continued = preg_replace('/^"(.*)"$/', '$1', $trim);
            $msgIdBuffer .= stripcslashes($continued);
            $currentMsgId = $msgIdBuffer;
            $out[] = $line;
            continue;
        }

        // Detect msgstr for current msgid
        if (strpos($trim, 'msgstr ') === 0) {
            // Stop collecting msgid when we reach msgstr
            $collectingMsgId = false;

            // Header block: msgid "" — skip changes
            $isHeader = ($currentMsgId === '');

            // Extract current msgstr content
            $currentStr = preg_replace('/^msgstr\s+"(.*)"$/', '$1', $trim);
            $isEmpty = ($currentStr === '' || $currentStr === null);
            if ($isEmpty) {
                $emptyCountBefore++;
            }

            if (!$isHeader && $isEmpty && $currentMsgId !== null) {
                // Lookup translation
                if (isset($dictionary[$currentMsgId]) && $dictionary[$currentMsgId] !== '') {
                    $translation = (string)$dictionary[$currentMsgId];
                    $translation = escapePoString($translation);
                    $line = 'msgstr "' . $translation . '"' . PHP_EOL;
                    $modifiedCount++;
                }
            }
            $out[] = $line;
            continue;
        }

        // Reset state when hitting a blank line between entries
        if ($trim === '') {
            $currentMsgId = null;
            $collectingMsgId = false;
            $msgIdBuffer = '';
        }

        $out[] = $line;
    }

    // Backup original
    $backupPath = $poPath . '.bak';
    if (!@copy($poPath, $backupPath)) {
        throw new RuntimeException("Failed to backup {$poPath} to {$backupPath}");
    }

    // Write updated content
    file_put_contents($poPath, implode('', $out));

    return ['modified' => $modifiedCount, 'empties_before' => $emptyCountBefore];
}

function main(): void {
    $baseDir = __DIR__;

    $targets = [
        [
            'po' => $baseDir . '/funnel-services-form-es_ES.po',
            'l10n' => $baseDir . '/funnel-services-form-es_ES.l10n.php',
            'locale' => 'es_ES'
        ],
        [
            'po' => $baseDir . '/funnel-services-form-pt_PT.po',
            'l10n' => $baseDir . '/funnel-services-form-pt_PT.l10n.php',
            'locale' => 'pt_PT'
        ],
    ];

    foreach ($targets as $t) {
        echo "Processing {$t['locale']}...\n";
        $dict = loadDictionary($t['l10n']);
        // Supplemental translations for admin/ACF messages and non-emoji keys
        if ($t['locale'] === 'es_ES') {
            $supplement = [
                'ACF Pro' => 'ACF Pro',
                'Actions' => 'Acciones',
                'Advanced Custom Fields (ACF)' => 'Campos Personalizados Avanzados (ACF)',
                'All User Information' => 'Toda la Información de Usuario',
                'and' => 'y',
                'Attention!' => '¡Atención!',
                'Back' => 'Volver',
                'Corporate Blue' => 'Azul Corporativo',
                'Debug / Logs' => 'Depuración / Registros',
                'Enable debug/logs mode' => 'Activar modo debug/logs',
                'Export Selected' => 'Exportar Seleccionados',
                'Insufficient permissions to perform this action.' => 'Permisos insuficientes para realizar esta acción.',
                'Invalid post ID' => 'ID de entrada inválido',
                'Invalid post.' => 'Entrada inválida',
                'No services selected.' => 'No hay servicios seleccionados.',
                'Post not found' => 'Entrada no encontrada',
                'Privacy Policy Link Settings' => 'Configuración del Enlace de Política de Privacidad',
                'Privacy Policy URL' => 'URL de la Política de Privacidad',
                'Remove Selected' => 'Eliminar Seleccionados',
                'Selected Services' => 'Servicios Seleccionados',
                'Show logs and errors on frontend' => 'Mostrar logs y errores en el frontend',
                'Thank You Page Link' => 'Enlace de Página de Agradecimiento',
                'Thank You Page Link Settings' => 'Configuración del Enlace de Agradecimiento',
                'Thank You Page URL' => 'URL de la Página de Agradecimiento',
                'This plugin requires' => 'Este plugin requiere',
                'to be installed and active to function properly, including repeater fields functionality.' => 'que estén instalados y activos para funcionar correctamente, incluyendo la funcionalidad de campos repetidores.',
                'Install them to take advantage of all plugin features!' => '¡Instálalos para aprovechar todas las funciones del plugin!',
                'User Data' => 'Datos del Usuario',
                'User Details' => 'Detalles del Usuario',
                'View' => 'Ver',
                'Delete' => 'Eliminar',
                'Are you sure you want to delete the selected users?' => '¿Seguro que desea eliminar los usuarios seleccionados?',
                'Are you sure you want to delete this user?' => '¿Seguro que desea eliminar este usuario?'
            ];
            $dict = $supplement + $dict; // supplement takes precedence
        } elseif ($t['locale'] === 'pt_PT') {
            $supplement = [
                'ACF Pro' => 'ACF Pro',
                'Actions' => 'Ações',
                'Advanced Custom Fields (ACF)' => 'Campos Personalizados Avançados (ACF)',
                'All User Information' => 'Toda a Informação do Utilizador',
                'and' => 'e',
                'Attention!' => 'Atenção!',
                'Back' => 'Voltar',
                'Corporate Blue' => 'Azul Corporativo',
                'Debug / Logs' => 'Depuração / Registos',
                'Enable debug/logs mode' => 'Ativar modo de depuração/registos',
                'Export Selected' => 'Exportar Selecionados',
                'Insufficient permissions to perform this action.' => 'Permissões insuficientes para realizar esta ação.',
                'Invalid post ID' => 'ID de publicação inválido',
                'Invalid post.' => 'Publicação inválida',
                'No services selected.' => 'Nenhum serviço selecionado.',
                'Post not found' => 'Publicação não encontrada',
                'Privacy Policy Link Settings' => 'Configuração do Link da Política de Privacidade',
                'Privacy Policy URL' => 'URL da Política de Privacidade',
                'Remove Selected' => 'Eliminar Selecionados',
                'Selected Services' => 'Serviços Selecionados',
                'Show logs and errors on frontend' => 'Mostrar registos e erros no frontend',
                'Thank You Page Link' => 'Link da Página de Agradecimento',
                'Thank You Page Link Settings' => 'Configuração do Link da Página de Agradecimento',
                'Thank You Page URL' => 'URL da Página de Agradecimento',
                'This plugin requires' => 'Este plugin requer',
                'to be installed and active to function properly, including repeater fields functionality.' => 'que estejam instalados e ativos para funcionar corretamente, incluindo a funcionalidade de campos repetidores.',
                'Install them to take advantage of all plugin features!' => 'Instale-os para aproveitar todas as funcionalidades do plugin!',
                'User Data' => 'Dados do Utilizador',
                'User Details' => 'Detalhes do Utilizador',
                'View' => 'Ver',
                'Delete' => 'Eliminar',
                'Are you sure you want to delete the selected users?' => 'Tem certeza de que deseja eliminar os utilizadores selecionados?',
                'Are you sure you want to delete this user?' => 'Tem certeza de que deseja eliminar este utilizador?'
            ];
            $dict = $supplement + $dict;
        }
        $res = syncPo($t['po'], $dict);
        echo " - Empty msgstr before: {$res['empties_before']}\n";
        echo " - Filled entries: {$res['modified']}\n";
    }

    echo "Done. Regenerate MO with: php global-translate-generator.php\n";
}

main();
 
