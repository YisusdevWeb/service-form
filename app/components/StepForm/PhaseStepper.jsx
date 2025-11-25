import React from 'react';
import { Stepper, Step, StepLabel } from '@mui/material';
import '../../../assets/scss/styles.scss'; 

const PhaseStepper = ({ currentPhase, fases, onStepClick }) => {
 // console.log('Fases:', fases, 'Current Phase:', currentPhase);

  return (
    <Stepper activeStep={currentPhase}>
      {fases.map((fase, index) => (
        <Step key={index} onClick={() => onStepClick(index)}>
          <StepLabel
            slotProps={{
              stepIcon: {
                sx: {
                  color: currentPhase >= index ? '#ffffff' : 'rgba(255, 255, 255, 0.4)', // Círculos blancos
                  '&.Mui-active': {
                    color: '#ffffff', // Color blanco cuando el paso está activo
                  },
                  '&.Mui-completed': {
                    color: '#ffffff', // Color blanco cuando el paso está completado
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
