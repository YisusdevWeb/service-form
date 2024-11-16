import React from 'react';
import { createRoot } from 'react-dom/client';
import '../assets/scss/styles.scss'; // Importa estilos globales
import App from '/app/App'; // Importa el componente principal

// Render React app
const root = createRoot(document.getElementById('FSF_frontend-seccion'));

root.render(
  <React.StrictMode>
    <App /> {/* Aquí cargará el formulario dinámico */}
  </React.StrictMode>
);
