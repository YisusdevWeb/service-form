import React from 'react';
import { Box, Button } from '@mui/material';

const FormNavigation = ({ currentPhase, totalPhases, onPrevious, onNext }) => {
  return (
    <Box mt={4} display="flex" justifyContent="space-between">
      {currentPhase > 0 && (
        <Button variant="contained" color="primary" onClick={onPrevious}>Anterior</Button>
      )}
      <Button variant="contained" color="primary" onClick={onNext}>
        {currentPhase < totalPhases - 1 ? 'Siguiente' : 'Completar'}
      </Button>
    </Box>
  );
};

export default FormNavigation;
