import React from 'react';
import { Box, Button } from '@mui/material';
import '../../../assets/scss/styles.scss'; // Importa tus estilos globales

const FormNavigation = ({ currentPhase, totalPhases, onPrevious, onNext }) => {
  const handleNext = () => {
    if (currentPhase < totalPhases - 1) {
      onNext();
    } else {
      // If last step is 'unica' type, we finish the form
      onNext();
    }
  };

  return (
    <Box mt={4} display="flex" justifyContent="space-between">
      {currentPhase > 0 && (
        <Button
          className="custom-button"
          sx={{
            fontFamily: 'Poppins, sans-serif',
            backgroundColor: 'var(--theme-color)',
            color: 'white',
            '&:hover': {
              backgroundColor: 'var(--theme-color-darken)',
            },
          }}
          onClick={onPrevious}
        >
          Previous
        </Button>
      )}
      <Button
        className="custom-button"
        sx={{
          fontFamily: 'Poppins, sans-serif',
          backgroundColor: 'var(--theme-color)',
          color: 'white',
          '&:hover': {
            backgroundColor: 'var(--theme-color-darken)',
          },
        }}
        onClick={handleNext}
      >
        {currentPhase < totalPhases - 1 ? 'CONTINUE' : 'Finish'}
      </Button>
    </Box>
  );
};

export default FormNavigation;
