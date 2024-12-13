import React from 'react';
import { Stepper, Step, StepLabel } from '@mui/material';
import '../../../assets/scss/styles.scss'; 

const PhaseStepper = ({ currentPhase, fases, onStepClick }) => {
  return (
    <Stepper activeStep={currentPhase}>
      {fases.map((fase, index) => (
        <Step key={index} onClick={() => onStepClick(index)}>
          <StepLabel
            slotProps={{
              stepIcon: {
                sx: {
                  color: currentPhase >= index ? 'var(--theme-color)' : 'var(--assistant-color)', // Cambia el color de los círculos
                  '&.Mui-active': {
                    color: 'var(--theme-color-darken)', // Color cuando el paso está activo
                  },
                  '&.Mui-completed': {
                    color: 'var(--theme-color)', // Color cuando el paso está completado
                  },
                },
              },
            }}
          >
            {fase.titulo}
          </StepLabel>
        </Step>
      ))}
    </Stepper>
  );
};

export default PhaseStepper;
