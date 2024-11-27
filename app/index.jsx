import React from 'react';
import { createRoot } from 'react-dom/client';
import { CssBaseline, ThemeProvider, createTheme } from '@mui/material';
import '../assets/scss/styles.scss'; // Importa estilos globales
import App from '/app/App'; // Asegúrate de que la ruta es correcta

const theme = createTheme({
  // Aquí puedes personalizar tu tema si es necesario
});

// Renderizar la aplicación de React
const root = createRoot(document.getElementById('FSF_frontend-seccion'));

root.render(
  <React.StrictMode>
    <ThemeProvider theme={theme}>
      <CssBaseline />
      <App /> {/* Aquí cargará el formulario dinámico */}
    </ThemeProvider>
  </React.StrictMode>
);
