# Sistema de Traducciones - Funnel Services Form

Este directorio contiene todos los archivos relacionados con el sistema de internacionalización (i18n) del plugin Funnel Services Form.

## Estructura de Archivos

- `funnel-services-form.pot` - Plantilla de traducciones (POT) con todas las cadenas traducibles
- `funnel-services-form-es_ES.po` - Archivo de traducciones al español
- `funnel-services-form-pt_PT.po` - Archivo de traducciones al portugués
- `funnel-services-form-es_ES.mo` - Archivo compilado de traducciones al español
- `funnel-services-form-pt_PT.mo` - Archivo compilado de traducciones al portugués
- `english-base.php` - Archivo con las cadenas base en inglés
- `update-translations.php` - Script para actualizar POT y PO
- `rebuild-mo.php` - Script para generar archivos MO
- `verify-translations.php` - Script para verificar traducciones
- `update-all-translations.php` - Script completo para actualizar todo

## Scripts Disponibles

### Actualizar todas las traducciones
```bash
php languages/update-all-translations.php
```

Este script realiza todas las operaciones necesarias para mantener actualizado el sistema de traducciones.

### Actualizar solo POT y PO
```bash
php languages/update-translations.php
```

### Generar archivos MO
```bash
php languages/rebuild-mo.php
```

### Verificar traducciones
```bash
php languages/verify-translations.php
```

## Notas Importantes

1. El plugin utiliza el sistema de internacionalización de WordPress con las funciones `__()`, `_e()`, etc.
2. Las cadenas traducibles en el frontend React se obtienen a través de `FSF_data.form_texts.clave || 'texto_por_defecto'`
3. Los archivos MO son necesarios para que WordPress cargue las traducciones correctamente
4. El archivo `english-base.php` contiene todas las cadenas base en inglés para asegurar que el inglés sea el idioma por defecto

## Proceso de Internacionalización

1. Las cadenas se extraen de archivos PHP y JSX
2. Se actualiza el archivo POT con todas las cadenas nuevas
3. Se actualizan los archivos PO manteniendo las traducciones existentes
4. Se generan los archivos MO para su uso por WordPress
5. Se verifica que todas las cadenas estén correctamente disponibles

## Cómo agregar traducciones

Para traducir cadenas al español o portugués:

1. Abrir el archivo `.po` correspondiente (`funnel-services-form-es_ES.po` o `funnel-services-form-pt_PT.po`)
2. Encontrar la cadena que se desea traducir, por ejemplo:
   ```
   msgid "The service \"%s\" has no phase options available."
   msgstr ""
   ```
3. Agregar la traducción en el `msgstr`:
   - Para español: `msgstr "El servicio \"%s\" no tiene opciones de fase disponibles."`
   - Para portugués: `msgstr "O serviço \"%s\" não tem opções de fase disponíveis."`
4. Guardar el archivo `.po`
5. Regenerar el archivo `.mo` usando `php global-translate-generator.php`

Los archivos `.po` pueden editarse manualmente o con herramientas especializadas como Poedit.