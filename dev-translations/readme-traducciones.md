# Sistema de Traducciones - Plugin Services Form

## Configuración del Entorno

El plugin Services Form utiliza las siguientes tecnologías:

- PHP para el backend de WordPress
- React/JSX para la interfaz de usuario
- Node.js y webpack para la compilación del frontend
- Sistema de internacionalización de WordPress (i18n)

## Actualización del Sistema de Traducciones

### 1. Estado Actual
- Text Domain: `funnel-services-form`
- Domain Path: `/languages/`
- Archivo POT base en: `languages/funnel-services-form.pot`
- Sistema de textos personalizables en: `includes/admin/form-texts-admin.php`

### 2. Cadenas Faltantes en POT

Después de analizar todos los archivos, se han identificado las siguientes cadenas que necesitan ser añadidas al archivo POT:

1. **Archivos React/JSX** (frontend):
   - "Selecionar um serviço" (`app/app.jsx`)
   - "Carregando..." (`app/components/Preloader.jsx`)
   - "Email enviado com sucesso!" (`app/components/SuccessMessage.jsx`)
   - "Redirecionando..." (`app/components/SuccessMessage.jsx`)
   - "Aviso" (`app/components/NoPhasePopup.jsx`)
   - "O serviço \"%s\" não tem opções de fase disponíveis." (`app/components/NoPhasePopup.jsx`)
   - "Fechar" (`app/components/NoPhasePopup.jsx`)

2. **Archivos PHP** (backend):
   - Muchas cadenas ya se encuentran en el archivo POT actual, pero puede haber más en los archivos dinámicos del backend.

### 3. Herramientas para Actualizar el POT

Para actualizar correctamente el archivo POT, se puede usar WP-CLI:

```
wp i18n make-pot . languages/funnel-services-form.pot --include="includes/,app/,templates/"
```

O, si no tienes WP-CLI, puedes usar la herramienta de node:

```
npm install --save-dev @wordpress/scripts
npx wp-scripts make-pot --input ./ --output ./languages/funnel-services-form.pot
```

### 4. Sistema de Textos Personalizables

El plugin ya implementa un sistema muy útil en `includes/admin/form-texts-admin.php` que permite a los usuarios personalizar todos los textos del formulario desde el panel de administración. Estos textos se cargan en el frontend a través de `FSF_data.form_texts`.

### 5. Pasos Recomendados

1. Actualizar el archivo POT con todas las cadenas identificadas
2. Crear archivos PO/MO para nuevos idiomas si es necesario
3. Añadir soporte para más idiomas según sea necesario
4. Probar la funcionalidad de traducción en diferentes idiomas
5. Documentar el proceso para futuras actualizaciones

### 6. Buenas Prácticas Implementadas

- Uso correcto de `__()` y `_e()` en archivos PHP
- Sistema de internacionalización en JavaScript con `wp_localize_script`
- Sistema de textos personalizables en el panel de administración
- Text domain consistente en todo el proyecto