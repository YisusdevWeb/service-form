import React from 'react';
import { Fab } from '@mui/material';
import RestartAltIcon from '@mui/icons-material/RestartAlt';

const FloatingResetButton = ({ onClick }) => {
  return (
    <Fab 
      color="secondary" 
      aria-label="reset" 
      onClick={onClick}
      sx={{
        position: 'fixed',
        bottom: 16,
        right: 16,
        zIndex: 1000,
      }}
    >
      <RestartAltIcon />
    </Fab>
  );
};

export default FloatingResetButton;
