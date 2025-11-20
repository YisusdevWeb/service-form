---

## Historial de cambios / Changelog

### v1.3.1 (Nov 2025)
- **Selector de Medios WordPress**: Logo ahora se selecciona desde la biblioteca de medios de WordPress
- **Botón Reset de Estilos**: Botón para restaurar todos los colores a valores por defecto
- **Valores por Defecto Mejorados**: Colores con mejor contraste y visibilidad
  - Títulos blancos (#ffffff) sobre fondo azul oscuro
  - Labels blancos (#ffffff) para mejor legibilidad
  - Texto secundario más claro (#e5e7eb)
  - Fondo secundario más saturado (#1e5a8e)
  - Glassmorphism más visible (opacidad 0.08)
- **Campos Vacíos = Default**: Si dejas un campo vacío, usa automáticamente el valor por defecto
- **Fix Color Texto Botón**: Ahora usa correctamente la variable `--button-text` en SCSS
- **Fix Logo Display**: Logo se muestra correctamente desde el inicio usando biblioteca WP

### v1.3.0 (Nov 2025)
- **Glassmorphism Design**: Diseño moderno con efecto glassmorphism inspirado en dappin.pt
- **Panel de Personalización Completo**: Admin panel para personalizar logo, colores y estilos
- **Logo Personalizado**: Upload de logo desde el admin de WordPress
- **Sistema de Colores Dinámico**: Personalización completa con códigos hexadecimales:
  - Colores de fondo (gradientes)
  - Colores de textos y títulos
  - Colores de inputs y bordes
  - Colores de botones y hover
  - Ajuste de glassmorphism (opacidad y blur)
- **Mejora de Coherencia Visual**: Inputs blancos con texto oscuro, labels claros, mejor contraste
- **CSS Dinámico**: Estilos generados automáticamente desde las opciones del admin
- **Versiones de Assets Actualizadas**: Cache busting para JS y CSS

### v1.2.0 (Oct 2025)
- Corrección definitiva del "paso fantasma": se eliminó la bandera `recentlyAdvanced` y se consolidó la lógica para evitar doble avance en fases de selección única.
- Limpieza de logs temporales y comentarios de depuración en frontend.
- Revisión y consolidación de la navegación por fases, asegurando que solo se avanza una vez por fase.
- Documentación actualizada con pasos para probar y validar el flujo.
- Validación y protección CSRF: nonce generado en PHP, pasado al frontend y validado en endpoints REST.
- Mejoras en la documentación y estructura del plugin.

---

## Explicación de ajustes recientes

- **Corrección paso fantasma:**
	- Problema: el usuario podía avanzar dos veces en fases de selección única, creando una fase extra.
	- Solución: se consolidó la lógica de avance automático y manual, eliminando la bandera `recentlyAdvanced` y los logs temporales. Ahora solo se avanza una vez por fase, sin duplicados.
	- Resultado: navegación por fases estable y sin errores de avance.

- **Pruebas y validación:**
	- Activar el plugin en WordPress local.
	- Ejecutar `npm install` y `npm run build` para compilar assets.
	- Probar el flujo de selección única y múltiple, asegurando que no aparece el paso extra.
	- Verificar que los correos llegan correctamente al admin y usuario.
	- Confirmar que los logs solo se muestran si debug está activo desde el admin.

- **Envío de correos:**
	- El admin recibe el correo de lead al crear el primer formulario.
	- El usuario solo recibe el correo final (cotización), no el de lead.
	- Esto evita confusión y spam al usuario.

- **Protección y validación:**
	- Nonce generado y validado en cada request REST para evitar envíos no autorizados.
	- Honeypot y validaciones básicas para evitar spam.

---

## Recomendaciones para futuras mejoras

- Agregar panel de configuración en el admin para editar textos, emails, colores y URLs.
- Permitir gestión de fases y opciones desde el admin (sin editar ACF manualmente).
- Editor visual de plantillas de correo.
- Integraciones externas (Google Sheets, Mailchimp, WhatsApp, Zapier, webhooks).
- Panel de logs y exportación de leads.
- Seguridad extra: reCAPTCHA, rate-limiting, validaciones avanzadas.

---
# Funnel Services Form

## Descripción (Español)
Este plugin para WordPress permite crear formularios de servicios con múltiples fases, integrando un frontend en React y un backend en PHP. Incluye protección CSRF, envío de correos automáticos, integración con ACF y navegación inteligente por fases.

### Estructura principal
- **funil-services-form.php**: Bootstrap del plugin, incluye todos los módulos.
- **includes/**: Lógica PHP (REST, mail, ACF, enqueue, shortcode, admin).
- **app/**: Frontend React (componentes, store, utilidades).
- **dist/**: Archivos compilados JS/CSS para producción.
- **assets/**: Estilos y scripts adicionales.

### Flujo general
1. El usuario accede al formulario (shortcode).
2. El frontend React renderiza las fases y gestiona el estado.
3. Al enviar el primer formulario, se crea un post y se envía correo al admin.
4. Al finalizar, se actualiza el post y se envía correo al usuario.
5. La navegación por fases está consolidada: no se producen avances dobles ni pasos fantasma.

### Funciones clave
- **Seguridad**: Nonce generado en PHP y validado en REST.
- **Fases**: Definidas en ACF y pasadas al frontend vía localización JS.
- **Corrección paso fantasma**: Lógica consolidada evita doble avance, sin necesidad de bandera extra.
- **Envío de correos**: Funciones en `wp_mail_functions.php` para admin y usuario.

### Personalización
- Para agregar fases: editar campos ACF y lógica en `acf_fields.php`.
- Para modificar correos: editar plantillas en `templates/emails/` y funciones en `wp_mail_functions.php`.
- Para validar campos: modificar lógica en componentes React y PHP.
### Instalación y build
```pwsh
npm install
npm run build
```
Sube/copia la carpeta `dist` al servidor y activa el plugin en WordPress.

---

## Description (English)
This WordPress plugin creates multi-phase service forms, integrating a React frontend and PHP backend. It includes CSRF protection, automatic emails, ACF integration, and smart phase navigation.

### Main structure
- **funil-services-form.php**: Plugin bootstrap, includes all modules.
- **includes/**: PHP logic (REST, mail, ACF, enqueue, shortcode, admin).
- **app/**: React frontend (components, store, utilities).
- **dist/**: Compiled JS/CSS for production.
- **assets/**: Additional styles and scripts.

### General flow
1. User accesses the form (shortcode).
2. React frontend renders phases and manages state.
3. On first submit, a post is created and email sent to admin.
4. On final submit, post is updated and email sent to user.

### Key features
- **Security**: Nonce generated in PHP and validated in REST.
- **Phases**: Defined in ACF and passed to frontend via JS localization.
- **Ghost step fix**: `recentlyAdvanced` flag prevents double advance.
- **Email sending**: Functions in `wp_mail_functions.php` for admin and user.

### Customization
- To add phases: edit ACF fields and logic in `acf_fields.php`.
- To modify emails: edit templates in `templates/emails/` and functions in `wp_mail_functions.php`.
- To validate fields: modify logic in React components and PHP.
### Installation and build
```pwsh
npm install
npm run build
```
Upload/copy the `dist` folder to the server and activate the plugin in WordPress.

---

## Detalle de funciones principales / Main function details
- **wp_rest_api.php**: Registra endpoints REST, valida nonce, gestiona creación/actualización de posts y envío de correos.
- **wp_mail_functions.php**: Define funciones para enviar correos al admin y usuario, usando plantillas.
- **acf_fields.php**: Define campos ACF para fases y opciones, añade IDs únicos.
- **app/store/store.js**: Zustand store para estado global del formulario.
- **app/utils/handleSelection.js**: Lógica para manejar selecciones y avance automático.
- **app/form/StepForm.jsx**: Componente principal del formulario, maneja navegación y validaciones.

---

## Recomendaciones para editar/extender
- Comenta cada función nueva y describe su propósito.
- Para nuevos campos, actualiza tanto ACF como el frontend React.
- Para nuevos correos, crea la plantilla en `templates/emails/` y llama la función desde el endpoint REST.
- Para seguridad, mantén la validación de nonce y considera añadir reCAPTCHA si el formulario es público.

---

## Contacto / Contact
Para dudas o mejoras, contacta al autor original o revisa la documentación interna en cada archivo.
<<<<<<< HEAD
# service-form
=======
# funil-services-form
>>>>>>> origin/master
