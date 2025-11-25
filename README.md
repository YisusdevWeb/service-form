# EWEB - Funnel Services Form

## Service form plugin with stages for quotations

### Description
Plugin for service forms with steps for quotes. Allows creating multi-phase forms with color and style customization. The base language is English, with support for translations.

### Features
- Service forms with multiple phases
- Style and color customization
- Customizable text system
- Support for multiple languages
- Integration with ACF (Advanced Custom Fields)
- Responsive and modern design
- Full internationalization system with English as base language

### Base Language
This plugin uses **English (en_US)** as its base language following AI-Vault development standards.

### Internationalization System
- Text Domain: `funnel-services-form`
- Domain Path: `/languages/`
- POT file with all strings in English as base
- Dynamic string loading for React/JSX components
- Customizable text system through admin panel

### File Structure
```
funil-services-form/
├── includes/
│   ├── acf/
│   ├── admin/
│   │   ├── js/
│   │   └── views/
│   ├── wp_*.php
│   └── wp_i18n_frontend.php
├── app/
│   ├── components/
│   ├── form/
│   └── store/
├── assets/
├── dist/
├── languages/
│   ├── funnel-services-form.pot
│   └── english-base.php
├── templates/
├── dev-translations/ (development files)
└── funil-services-form.php
```

### Language Configuration
1. The POT file (`languages/funnel-services-form.pot`) contains all strings in English as base
2. Currently available translations:
   - `funnel-services-form-es_ES.po` and `funnel-services-form-es_ES.mo` for Spanish
   - `funnel-services-form-pt_BR.po` and `funnel-services-form-pt_BR.mo` for Portuguese
3. To add support for other languages, create PO/MO files following the same pattern
4. Generated translation files include support scripts for regeneration:
   - `global-translate-generator.php` - Script to regenerate MO files from PO
   - `global-regenerate-mo.bat` - Windows script for regeneration
   - `global-regenerate-mo.sh` - Linux/Mac script for regeneration

### Customizable Text System
The plugin includes a text customization system that allows users to change all form texts from the admin panel without touching translation files. These texts are loaded to the frontend through `FSF_data.form_texts`.

### Translation System Implementation
1. React/JSX components now use dynamic string loading from backend
2. Strings in React components are properly internationalized:
   - App component: "Select a service"
   - Preloader component: "Loading..."
   - SuccessMessage component: "Email sent successfully!", "Redirecting..."
   - NoPhasePopup component: "Notice", "The service...available", "Close"
   - UserForm component: All form texts updated to English base
3. Backend maintains customizable form texts system through admin panel

### Updating Translation Files
1. To update the POT file with new strings:
   ```
   wp i18n make-pot . languages/funnel-services-form.pot --include="includes/,app/,templates/"
   ```
2. After updating PO files with new translations, regenerate MO files:
   ```
   php global-translate-generator.php
   ```
   Or use the appropriate script:
   - On Windows: `global-regenerate-mo.bat`
   - On Linux/Mac: `global-regenerate-mo.sh`
3. The translation system automatically updates both static translations and dynamic customizable texts

### Development Files
Files in `dev-translations/` contain tools and documentation to maintain and update the translation system:
- `traducciones-pendientes.md` - Documentation of strings needing translation
- `readme-traducciones.md` - Documentation about translation system
- `cadenas-traduccion.json` - Structured list of strings missing from POT
- `funnel-services-form-updated.pot` - Updated version of POT file
- `update-translations.js` - Script to automate updates
- `instrucciones-actualizacion.md` - Detailed instructions for implementing changes

### Developer Notes
- English is the base language of the plugin
- React/JSX strings are now included in the translation system
- The customizable text system allows users to change texts without editing files
- All files are encoded in UTF-8 without BOM
- The system follows WordPress internationalization best practices
- Dynamic frontend string loading allows for real-time translation updates