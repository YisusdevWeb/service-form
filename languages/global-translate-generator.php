<?php
/**
 * Autogenerador de archivos .mo para plugins de WordPress - Versión Global
 * 
 * Script universal para generar archivos .mo a partir de .po en cualquier plugin de WordPress.
 * Copia este script en el directorio de traducciones de cualquier plugin y se adaptará automáticamente.
 * 
 * @package AI-Vault
 * @subpackage Translation-System
 * @version 1.0
 */

class GlobalWordPressTranslationGenerator {
    
    private $langDir;
    private $pluginName;
    private $locales;
    
    public function __construct($locales = ['es_ES', 'pt_PT']) {
        $this->langDir = __DIR__;
        $this->pluginName = $this->detectPluginName();
        $this->locales = $locales;
        echo "[AI-Vault Translation System] Sistema de autogeneración iniciado para: {$this->pluginName}\n";
    }
    
    public function detectPluginName() {
        // Intentar detectar el nombre del plugin desde el directorio
        $dir = basename($this->langDir);
        
        // Buscar archivos .pot/.po en el directorio para inferir el nombre
        $files = scandir($this->langDir);
        foreach ($files as $file) {
            if (preg_match('/^(.+)\.pot$/', $file, $matches)) {
                return $matches[1];
            }
            if (preg_match('/^(.+)-[a-z]{2}_[A-Z]{2}\.po$/', $file, $matches)) {
                return $matches[1];
            }
        }
        
        // Fallback: usar el nombre del directorio
        return $dir;
    }
    
    public function generateAll() {
        echo "[AI-Vault Translation System] Iniciando autogeneración de archivos .mo para {$this->pluginName}...\n";
        
        $processed = 0;
        $updated = 0;
        
        foreach ($this->locales as $locale) {
            $poFile = $this->langDir . '/' . $this->pluginName . '-' . $locale . '.po';
            $moFile = $this->langDir . '/' . $this->pluginName . '-' . $locale . '.mo';
            
            if (file_exists($poFile)) {
                echo "[AI-Vault Translation System] Procesando $locale...\n";
                
                // Verificar si el archivo .mo existe y cuándo fue modificado
                $poModified = filemtime($poFile);
                $moExists = file_exists($moFile);
                $moModified = $moExists ? filemtime($moFile) : 0;
                
                // Solo regenerar si el .po es más reciente que el .mo o si el .mo no existe
                if (!$moExists || $poModified > $moModified) {
                    if ($moExists) {
                        echo "[AI-Vault Translation System]  .po es más reciente, regenerando .mo...\n";
                    } else {
                        echo "[AI-Vault Translation System]  .mo no existe, generando...\n";
                    }
                    
                    if ($this->generateMO($poFile, $moFile)) {
                        echo "[AI-Vault Translation System]  ✓ $moFile generado exitosamente\n";
                        $updated++;
                    } else {
                        echo "[AI-Vault Translation System]  ✗ Error generando $moFile\n";
                    }
                } else {
                    echo "[AI-Vault Translation System]  .mo está actualizado, no se requiere regeneración\n";
                }
                $processed++;
            } else {
                echo "[AI-Vault Translation System] Advertencia: No se encontró $poFile\n";
            }
        }
        
        echo "[AI-Vault Translation System] Autogeneración completada para {$this->pluginName}.\n";
        echo "[AI-Vault Translation System] Procesados: $processed, Actualizados: $updated\n";
    }
    
    private function generateMO($poFile, $moFile) {
        // Cargar el archivo PO
        $content = file_get_contents($poFile);
        if ($content === false) {
            return false;
        }

        $lines = explode("\n", $content);
        $currentContext = '';
        $currentId = '';
        $currentPluralId = '';
        $currentTranslation = '';
        $currentPluralTranslation = [];
        $originals = [];
        $translations = [];
        $isPlural = false;

        foreach ($lines as $line) {
            $line = trim($line);
            
            if (strpos($line, 'msgctxt') === 0) {
                $currentContext = $this->parseString(substr($line, 7)); // Remove 'msgctxt '
            } elseif (strpos($line, 'msgid_plural') === 0) {
                $currentPluralId = $this->parseString(substr($line, 12)); // Remove 'msgid_plural '
                $isPlural = true;
            } elseif (strpos($line, 'msgid') === 0) {
                // Si tenemos una entrada anterior, guárdala
                if ($currentId !== '') {
                    $this->addEntry($originals, $translations, $currentContext, $currentId, $currentPluralId, $currentTranslation, $currentPluralTranslation);
                }
                // Reiniciar para la próxima entrada
                $currentContext = '';
                $currentPluralId = '';
                $currentTranslation = '';
                $currentPluralTranslation = [];
                $isPlural = false;
                $currentId = $this->parseString(substr($line, 5)); // Remove 'msgid '
            } elseif (strpos($line, 'msgstr[') === 0) {
                // Traducción plural
                $matches = [];
                if (preg_match('/msgstr\[(\d+)\]/', $line, $matches)) {
                    $index = (int)$matches[1];
                    $translation = $this->parseString(substr($line, strlen($matches[0]) + 1));
                    $currentPluralTranslation[$index] = $translation;
                }
            } elseif (strpos($line, 'msgstr') === 0) {
                // Traducción regular (no plural)
                if (strpos($line, 'msgstr[') === false) {
                    $currentTranslation = $this->parseString(substr($line, 6)); // Remove 'msgstr '
                }
            } elseif (strpos($line, '"') === 0 && $line[strlen($line) - 1] === '"') {
                // Continuación de cadena
                $continuation = $this->parseString($line);
                
                if ($isPlural && !empty($currentPluralTranslation)) {
                    $lastKey = max(array_keys($currentPluralTranslation));
                    $currentPluralTranslation[$lastKey] .= $continuation;
                } elseif ($currentTranslation !== '') {
                    $currentTranslation .= $continuation;
                } elseif ($currentId !== '') {
                    $currentId .= $continuation;
                } elseif ($currentPluralId !== '') {
                    $currentPluralId .= $continuation;
                } elseif ($currentContext !== '') {
                    $currentContext .= $continuation;
                }
            }
        }

        // Manejar la última entrada
        if ($currentId !== '') {
            $this->addEntry($originals, $translations, $currentContext, $currentId, $currentPluralId, $currentTranslation, $currentPluralTranslation);
        }

        // Generar el contenido .mo con el formato binario correcto
        $numEntries = count($originals);
        
        // Calcular offsets
        $headerSize = 28; // Tamaño de la cabecera fija
        $originalsOffsetTableStart = $headerSize;
        $translationsOffsetTableStart = $headerSize + ($numEntries * 8);
        $originalsStringsStart = $translationsOffsetTableStart + ($numEntries * 8);
        
        // Calcular posición de cadenas de traducción
        $transStringsStart = $originalsStringsStart;
        foreach ($originals as $orig) {
            $transStringsStart += strlen($orig) + 1; // +1 para null terminator
        }

        // Crear contenido binario
        $content = '';
        $content .= pack('L', 0x950412de); // Magic number
        $content .= pack('L', 0);          // Revisión
        $content .= pack('L', $numEntries); // Número de cadenas
        $content .= pack('L', $originalsOffsetTableStart);    // Offset tabla originales
        $content .= pack('L', $translationsOffsetTableStart); // Offset tabla traducciones
        $content .= pack('L', 0); // Tamaño de hash table (0 es válido)
        $content .= pack('L', 0); // Offset de hash table

        // Calcular offsets para cadenas
        $origOffset = $originalsStringsStart;
        $transOffset = $transStringsStart;
        $origOffsets = [];
        $transOffsets = [];

        foreach ($originals as $orig) {
            $origLen = strlen($orig);
            $origOffsets[] = [$origLen, $origOffset];
            $origOffset += $origLen + 1;
        }

        foreach ($translations as $trans) {
            $transLen = strlen($trans);
            $transOffsets[] = [$transLen, $transOffset];
            $transOffset += $transLen + 1;
        }

        // Escribir offsets de originales
        foreach ($origOffsets as $offset) {
            $content .= pack('L', $offset[0]); // Length
            $content .= pack('L', $offset[1]); // Offset
        }

        // Escribir offsets de traducciones
        foreach ($transOffsets as $offset) {
            $content .= pack('L', $offset[0]); // Length
            $content .= pack('L', $offset[1]); // Offset
        }

        // Escribir cadenas originales
        foreach ($originals as $orig) {
            $content .= $orig . "\0";
        }

        // Escribir cadenas de traducción
        foreach ($translations as $trans) {
            $content .= $trans . "\0";
        }

        // Guardar archivo .mo
        return file_put_contents($moFile, $content) !== false;
    }
    
    private function parseString($str) {
        // Si la cadena empieza con ", asumimos que es una línea completa como "msgid" y removemos el " y "
        if (strpos($str, '"') === 0) {
            $str = substr($str, 1);
        }
        
        // Remover las comillas al final si existen
        if (strlen($str) > 0 && $str[strlen($str) - 1] === '"') {
            $str = substr($str, 0, -1);
        }
        
        // Des-escapar cadenas
        $str = str_replace(['\\"', '\\n', '\\t', '\\r'], ['"', "\n", "\t", "\r"], $str);
        return $str;
    }
    
    private function addEntry(&$originals, &$translations, $context, $id, $pluralId, $translation, $pluralTranslations) {
        if ($context) {
            $id = $context . "\x04" . $id; // CONTEXT EOT MSGID
        }

        if ($pluralId) {
            // Forma plural: MSGID\x00MSGID_PLURAL
            $id = $id . "\x00" . $pluralId;
            // Para traducciones plurales, unirlas con \x00
            $translation = implode("\x00", $pluralTranslations);
        }

        $originals[] = $id;
        $translations[] = $translation;
    }
}

// Detectar configuraciones de idiomas desde un archivo de configuración opcional
$configFile = __DIR__ . '/translation-config.json';
$locales = ['es_ES', 'pt_BR', 'pt_PT']; // Valor por defecto

if (file_exists($configFile)) {
    $config = json_decode(file_get_contents($configFile), true);
    if (isset($config['locales']) && is_array($config['locales'])) {
        $locales = $config['locales'];
    }
}

// Ejecutar el autogenerador
$generator = new GlobalWordPressTranslationGenerator($locales);
$generator->generateAll();

// Crear también un script de línea de comandos para usar con Poedit u otras herramientas
$script_bat = <<< 'EOT'
@echo off
REM Script global para regenerar archivos .mo después de editar con Poedit
echo [AI-Vault Translation System] Regenerando archivos .mo...
php global-translate-generator.php
EOT;

file_put_contents(__DIR__ . '/global-regenerate-mo.bat', $script_bat);

$script_sh = <<< 'EOT'
#!/bin/bash
# Script global para regenerar archivos .mo después de editar con Poedit
echo "[AI-Vault Translation System] Regenerando archivos .mo..."
php global-translate-generator.php
EOT;

file_put_contents(__DIR__ . '/global-regenerate-mo.sh', $script_sh);
chmod(__DIR__ . '/global-regenerate-mo.sh', 0755);

echo "\n[AI-Vault Translation System] Scripts globales de regeneración creados:\n";
echo "- global-translate-generator.php (principal)\n";
echo "- global-regenerate-mo.bat (para Windows)\n";
echo "- global-regenerate-mo.sh (para Linux/Mac)\n";
echo "\n[AI-Vault Translation System] Copia este script en la carpeta de traducciones de cualquier plugin\n";
echo "[AI-Vault Translation System] y se adaptará automáticamente al nombre del plugin.\n";
?>