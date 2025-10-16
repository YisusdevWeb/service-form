import React from 'react';
import { createRoot } from 'react-dom/client';
import { CssBaseline, ThemeProvider } from '@mui/material';
import { BrowserRouter } from 'react-router-dom'; // Importa BrowserRouter
import App from './App';
import theme from './utils/theme'; // Importa el tema centralizado
import '../assets/scss/styles.scss'; // Importa tus estilos globales

document.addEventListener('DOMContentLoaded', () => {
  const container = document.getElementById('FSF_frontend-seccion');
  if (container) {
    const root = createRoot(container);
    root.render(
      <React.StrictMode>
        <BrowserRouter> {/* Envuelve tu aplicación con BrowserRouter */}
          <ThemeProvider theme={theme}>
            <CssBaseline />
            <App />
          </ThemeProvider>
        </BrowserRouter>
      </React.StrictMode>
    );

    // Desplazar la vista al formulario después de montar la aplicación con un pequeño retardo
    setTimeout(() => {
      container.scrollIntoView({ behavior: 'smooth' });
    }, 110); // 100 ms para permitir la carga completa
  } else {
    console.log("O contentor de destino não existe nesta página.");
  }
});
