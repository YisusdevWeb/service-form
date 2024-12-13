import React from 'react';
import { Box, Button } from '@mui/material';
import '../../../assets/scss/styles.scss'; // Importa tus estilos globales

const FormNavigation = ({ currentPhase, totalPhases, onPrevious, onNext }) => {
  return (
    <Box mt={4} display="flex" justifyContent="space-between">
      {currentPhase > 0 && (
        <Button
          className="custom-button"
          sx={{
            fontFamily: 'Poppins, sans-serif', // Asegúrate de que la fuente se aplique
            backgroundColor: 'var(--theme-color)',
            color: 'white',
            '&:hover': {
              backgroundColor: 'var(--theme-color-darken)',
            },
          }}
          onClick={onPrevious}
        >
          Anterior
        </Button>
      )}
      <Button
        className="custom-button"
        sx={{
          fontFamily: 'Poppins, sans-serif', // Asegúrate de que la fuente se aplique
          backgroundColor: 'var(--theme-color)',
          color: 'white',
          '&:hover': {
            backgroundColor: 'var(--theme-color-darken)',
          },
        }}
        onClick={onNext}
      >
        {currentPhase < totalPhases - 1 ? 'Siguiente' : 'Completar'}
      </Button>
    </Box>
  );
};

export default FormNavigation;
