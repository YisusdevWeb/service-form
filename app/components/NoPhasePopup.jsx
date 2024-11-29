import React from 'react';
import { Dialog, DialogActions, DialogContent, DialogContentText, DialogTitle, Button } from '@mui/material';

const NoPhasePopup = ({ open, onClose, serviceTitle }) => {
  return (
    <Dialog
      open={open}
      onClose={onClose}
      aria-labelledby="no-phase-popup-title"
      aria-describedby="no-phase-popup-description"
    >
      <DialogTitle id="no-phase-popup-title">Advertencia</DialogTitle>
      <DialogContent>
        <DialogContentText id="no-phase-popup-description">
          El servicio "{serviceTitle}" no tiene opciones de fases disponibles.
        </DialogContentText>
      </DialogContent>
      <DialogActions>
        <Button onClick={onClose} color="primary">Cerrar</Button>
      </DialogActions>
    </Dialog>
  );
};

export default NoPhasePopup;
