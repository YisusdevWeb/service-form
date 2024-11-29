import React from 'react';
import { Dialog, DialogActions, DialogContent, DialogContentText, DialogTitle, Button } from '@mui/material';

const ResetPopup = ({ open, onClose, onConfirm }) => {
  return (
    <Dialog
      open={open}
      onClose={onClose}
      aria-labelledby="reset-popup-title"
      aria-describedby="reset-popup-description"
    >
      <DialogTitle id="reset-popup-title">Confirmar Reinicio</DialogTitle>
      <DialogContent>
        <DialogContentText id="reset-popup-description">
          ¿Está seguro de que desea cambiar de servicio? Se perderá todo el progreso actual.
        </DialogContentText>
      </DialogContent>
      <DialogActions>
        <Button onClick={onClose} color="primary">Cancelar</Button>
        <Button onClick={onConfirm} color="secondary">Confirmar</Button>
      </DialogActions>
    </Dialog>
  );
};

export default ResetPopup;
