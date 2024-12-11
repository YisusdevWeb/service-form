import React from 'react';
import { Box, Typography, Button } from '@mui/material';

const SuccessMessage = ({ onClose }) => {
  return (
    <Box sx={{ maxWidth: 600, mx: 'auto', p: 2, textAlign: 'center', backgroundColor: '#e6f7e6', borderRadius: 2 }}>
      <Typography variant="h5" gutterBottom sx={{ color: '#4caf50', fontWeight: 'bold' }}>
        ¡Cotización Enviada con Éxito!
      </Typography>
      <Typography variant="body1" sx={{ mb: 2 }}>
        Hemos recibido tu cotización. Te contactaremos pronto con más detalles.
      </Typography>
      <Button variant="contained" color="primary" onClick={onClose}>
        Cerrar
      </Button>
    </Box>
  );
};

export default SuccessMessage;
