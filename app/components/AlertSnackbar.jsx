import React from 'react';
import { Snackbar, Alert } from '@mui/material';

const AlertSnackbar = ({ open, message, severity, onClose }) => {
  return (
    <Snackbar open={open} autoHideDuration={2000} onClose={onClose} anchorOrigin={{ vertical: 'bottom', horizontal: 'center' }}>
      <Alert onClose={onClose} severity={severity} sx={{ width: '100%' }}>
        {message}
      </Alert>
    </Snackbar>
  );
};

export default AlertSnackbar;
