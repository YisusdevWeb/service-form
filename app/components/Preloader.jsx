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
      bgcolor="#f9f9f9"
    >
      <CircularProgress />
      <Typography variant="h6" sx={{ marginTop: 2, color: '#0f4c80' }}>
      Carregando...
      </Typography>
    </Box>
  );
};

export default Preloader;
