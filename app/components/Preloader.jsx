import React from 'react';
import { Box, CircularProgress, Typography } from '@mui/material';

const Preloader = () => {
  return (
    <Box
      display="flex"
      flexDirection="column"
      alignItems="center"
      justifyContent="center"
      height="100vh"
    >
      <CircularProgress sx={{ color: '#ffffff' }} />
      <Typography variant="h6" sx={{ marginTop: 2, color: '#ffffff' }}>
      Carregando...
      </Typography>
    </Box>
  );
};

export default Preloader;
