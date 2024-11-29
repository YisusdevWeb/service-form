import React from 'react';
import { Dialog, DialogActions, DialogContent, DialogContentText, DialogTitle, Button } from '@mui/material';

const AddMoreServicesPopup = ({ open, onClose, onConfirm }) => {
  return (
    <Dialog
      open={open}
      onClose={onClose}
      aria-labelledby="add-more-services-popup-title"
      aria-describedby="add-more-services-popup-description"
    >
      <DialogTitle id="add-more-services-popup-title">Agregar Más Servicios</DialogTitle>
      <DialogContent>
        <DialogContentText id="add-more-services-popup-description">
          ¿Deseas agregar más servicios?
        </DialogContentText>
      </DialogContent>
      <DialogActions>
        <Button onClick={onClose} color="primary">No</Button>
        <Button onClick={onConfirm} color="secondary">Sí</Button>
      </DialogActions>
    </Dialog>
  );
};

export default AddMoreServicesPopup;
