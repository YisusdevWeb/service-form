import React from 'react';
import { createRoot } from 'react-dom/client';
import { CssBaseline, ThemeProvider, createTheme } from '@mui/material';
import '../assets/scss/styles.scss'; // Importa estilos globales
import App from './App'; // Asegúrate de que la ruta es correcta

const theme = createTheme({
  // Aquí puedes personalizar tu tema si es necesario
});

document.addEventListener('DOMContentLoaded', () => {
  const container = document.getElementById('FSF_frontend-seccion');
  if (container) {
    const root = createRoot(container);
    root.render(
      <React.StrictMode>
        <ThemeProvider theme={theme}>
          <CssBaseline />
          <App /> {/* Aquí cargará el formulario dinámico */}
        </ThemeProvider>
      </React.StrictMode>
    );
  } else {
    console.log("El contenedor objetivo no existe en esta página.");
  }
});
