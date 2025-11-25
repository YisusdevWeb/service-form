import React from 'react';
import { Box, Typography } from '@mui/material';
import CheckCircleIcon from '@mui/icons-material/CheckCircle';

const SuccessMessage = () => {
  return (
    <>
      {/* Overlay oscuro */}
      <Box
        sx={{
          position: 'fixed',
          top: 0,
          left: 0,
          right: 0,
          bottom: 0,
          backgroundColor: 'rgba(0, 0, 0, 0.7)',
          zIndex: 9998,
        }}
      />
      {/* Modal centrado */}
      <Box
        sx={{
          display: 'flex',
          flexDirection: 'column',
          alignItems: 'center',
          justifyContent: 'center',
          p: 4,
          backgroundColor: 'var(--bg-color, #090a15)',
          borderRadius: 3,
          boxShadow: '0 20px 60px rgba(0, 0, 0, 0.5)',
          border: '1px solid rgba(255, 255, 255, 0.2)',
          position: 'fixed',
          top: '50%',
          left: '50%',
          transform: 'translate(-50%, -50%)',
          zIndex: 9999,
          minWidth: '300px',
          maxWidth: '90vw',
          backdropFilter: 'blur(10px)',
          animation: 'popIn 0.3s ease-out',
          '@keyframes popIn': {
            '0%': { opacity: 0, transform: 'translate(-50%, -50%) scale(0.8)' },
            '100%': { opacity: 1, transform: 'translate(-50%, -50%) scale(1)' },
          },
        }}
      >
        <CheckCircleIcon sx={{ fontSize: 80, color: '#4ade80', mb: 2 }} />
        <Typography 
          variant="h5" 
          sx={{ 
            color: '#ffffff', 
            fontFamily: 'Poppins, sans-serif',
            fontWeight: 600,
            textAlign: 'center',
          }}
        >
          {FSF_data?.form_texts?.email_sent_success || 'Email sent successfully!'}
        </Typography>
        <Typography
          variant="body2"
          sx={{
            color: 'rgba(255, 255, 255, 0.7)',
            mt: 1,
            fontFamily: 'Poppins, sans-serif',
          }}
        >
          {FSF_data?.form_texts?.redirecting || 'Redirecting...'}
        </Typography>
      </Box>
    </>
  );
};

export default SuccessMessage;
