import React from 'react';
import { Box, Typography, Button } from '@mui/material';
import CheckCircleIcon from '@mui/icons-material/CheckCircle';

const SuccessMessage = ({ onClose }) => {
  return (
    <Box
      sx={{
        display: 'flex',
        flexDirection: 'column',
        alignItems: 'center',
        justifyContent: 'center',
        p: 3,
        backgroundColor: 'var(--bg-color)',
        borderRadius: 2,
        boxShadow: 3,
        position: 'fixed',
        top: '50%',
        left: '50%',
        transform: 'translate(-50%, -50%)',
        zIndex: 9999,
      }}
    >
      <CheckCircleIcon sx={{ fontSize: 60, color: 'var(--theme-color)' }} />
      <Typography variant="h6" sx={{ mt: 2, color: 'var(--heading-color)' }}>
        Email enviado com sucesso!
      </Typography>
      <Button
        variant="contained"
        onClick={onClose}
        sx={{ mt: 2, backgroundColor: 'var(--theme-color-darken)', color: 'var(--bg-color)' }}
      >
        Fechar
      </Button>
    </Box>
  );
};

export default SuccessMessage;
