import React from 'react';
import { Stepper, Step, StepLabel } from '@mui/material';

const PhaseStepper = ({ currentPhase, fases, onStepClick }) => {
  return (
    <Stepper activeStep={currentPhase} sx={{ mb: 3, display: 'flex', justifyContent: 'center' }} alternativeLabel>
      {fases.map((fase, index) => (
        <Step key={fase.id_fase || index} onClick={() => onStepClick(index)}>
          <StepLabel></StepLabel>
        </Step>
      ))}
    </Stepper>
  );
};

export default PhaseStepper;
