# Compatibilidad con Temas de WordPress

Esta carpeta contiene archivos CSS para resolver conflictos de estilos entre el plugin y temas de WordPress.

## 📁 Estructura de Archivos

```
includes/compat/
├── README.md                      # Este archivo (documentación)
└── custom-theme-override.css     # Tu archivo de personalizaciones
```

## 🎯 ¿Cuándo usar estos archivos?

Si el formulario **no se ve correctamente** en tu sitio (colores incorrectos, tipografía diferente, inputs sin estilo), es probable que haya un conflicto con tu tema de WordPress.

## 🔧 Solución Rápida: Archivo de Sobrescritura Personalizada

### Paso 1: Identifica el problema
1. Abre la página con el formulario
2. Presiona **F12** para abrir DevTools
3. Click derecho en el elemento que se ve mal → **Inspeccionar**
4. En el panel **Styles**, observa qué archivo CSS está aplicando el estilo incorrecto

### Paso 2: Edita `custom-theme-override.css`
1. Abre: `wp-content/plugins/services-form/includes/compat/custom-theme-override.css`
2. Agrega tus reglas CSS siguiendo este patrón:

```css
.funil-services-form-root.funil-services-form-root [tu-selector] {
    propiedad: valor !important;
}
```

### Paso 3: Ejemplos Comunes

#### ❌ Problema: Texto no es blanco
```css
.funil-services-form-root.funil-services-form-root p,
.funil-services-form-root.funil-services-form-root span,
.funil-services-form-root.funil-services-form-root label {
    color: #ffffff !important;
    font-family: "Inter", Arial, sans-serif !important;
}
```

#### ❌ Problema: Inputs sin fondo translúcido
```css
.funil-services-form-root.funil-services-form-root input,
.funil-services-form-root.funil-services-form-root textarea {
    background: rgba(255, 255, 255, 0.05) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    border-radius: 8px !important;
    color: #ffffff !important;
}
```

#### ❌ Problema: Botones con estilo incorrecto
```css
.funil-services-form-root.funil-services-form-root button,
.funil-services-form-root.funil-services-form-root .MuiButton-root {
    background: transparent !important;
    border: 2px solid rgba(255, 255, 255, 0.18) !important;
    color: #ffffff !important;
    padding: 10px 24px !important;
}
```

#### ❌ Problema: Tipografía incorrecta en todo el formulario
```css
.funil-services-form-root.funil-services-form-root,
.funil-services-form-root.funil-services-form-root * {
    font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif !important;
}
```

### Paso 4: Limpia la caché
1. En WordPress Admin → Plugin de caché → **Purgar/Limpiar todo**
2. En el navegador: **Ctrl + Shift + R** (recarga forzada)

## 📚 Referencia de Selectores Comunes

| Elemento | Selector |
|----------|----------|
| Inputs de texto | `.funil-services-form-root.funil-services-form-root input` |
| Textarea | `.funil-services-form-root.funil-services-form-root textarea` |
| Botones | `.funil-services-form-root.funil-services-form-root button` |
| Labels | `.funil-services-form-root.funil-services-form-root label` |
| Párrafos | `.funil-services-form-root.funil-services-form-root p` |
| Títulos | `.funil-services-form-root.funil-services-form-root h1` (h2, h3, etc.) |
| Links | `.funil-services-form-root.funil-services-form-root a` |
| MUI Buttons | `.funil-services-form-root.funil-services-form-root .MuiButton-root` |
| MUI Typography | `.funil-services-form-root.funil-services-form-root .MuiTypography-root` |

## 🤖 Información Técnica

- El archivo `custom-theme-override.css` se carga **automáticamente** con prioridad 999
- Esto garantiza que se carga después del CSS del tema
- Las reglas con `!important` tienen máxima prioridad
- No requiere activación manual — solo edita y guarda

## ⚠️ Notas Importantes

1. **Siempre usa `!important`** para garantizar que tus reglas tengan prioridad
2. **Usa el doble selector** `.funil-services-form-root.funil-services-form-root` para aumentar especificidad
3. **No edites los archivos del tema** — esto hace que pierdas cambios en actualizaciones
4. **Documenta tus cambios** — comenta por qué agregaste cada regla

## 🆘 ¿Necesitas ayuda?

Si no logras resolver el conflicto:

1. Toma una captura de pantalla del problema
2. Toma una captura de DevTools mostrando el CSS conflictivo
3. Indica el nombre y versión de tu tema
4. Contacta al soporte del plugin

---

**Versión del plugin**: 1.4.2  
**Última actualización**: 2025-11-25
