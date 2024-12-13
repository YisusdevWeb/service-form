import React from 'react';
import { createRoot } from 'react-dom/client';
import { CssBaseline, ThemeProvider } from '@mui/material';
import App from './App';
import theme from './utils/theme'; // Importa el tema centralizado
import '../assets/scss/styles.scss'; // Importa tus estilos globales


document.addEventListener('DOMContentLoaded', () => {
  const container = document.getElementById('FSF_frontend-seccion');
  if (container) {
    const root = createRoot(container);
    root.render(
      <React.StrictMode>
        <ThemeProvider theme={theme}>
          <CssBaseline />
          <App />
        </ThemeProvider>
      </React.StrictMode>
    );
  } else {
    console.log("O contentor de destino não existe nesta página.");
  }
});
