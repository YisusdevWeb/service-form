import React from 'react';
import { Dialog, DialogActions, DialogContent, DialogContentText, DialogTitle, Button } from '@mui/material';
import '../../assets/scss/styles.scss'; // Importa tus estilos globales

const AddMoreServicesPopup = ({ open, onClose, onConfirm }) => {
  return (
    <Dialog
      open={open}
      onClose={onClose}
      aria-labelledby="add-more-services-popup-title"
      aria-describedby="add-more-services-popup-description"
    >
      <DialogTitle id="add-more-services-popup-title" sx={{ fontFamily: 'Poppins, sans-serif', color: 'var(--heading-color)' }}>
        Agregar Más Servicios
      </DialogTitle>
      <DialogContent>
        <DialogContentText id="add-more-services-popup-description" sx={{ fontFamily: 'Poppins, sans-serif', color: 'var(--font-color)' }}>
          ¿Deseas agregar más servicios?
        </DialogContentText>
      </DialogContent>
      <DialogActions
        sx={{
          display: 'flex',
          justifyContent: 'center', // Centramos los botones
          gap: 2, // Espaciado entre botones
        }}
      >
        <Button
          onClick={onClose}
          color="primary"
          className="custom-button"
          sx={{
            fontFamily: 'Poppins, sans-serif',
            backgroundColor: 'var(--theme-color)',
            color: 'white',
            '&:hover': {
              backgroundColor: 'var(--theme-color-darken)',
            },
          }}
        >
          No
        </Button>
        <Button
          onClick={onConfirm}
          color="secondary"
          className="custom-button"
          sx={{
            fontFamily: 'Poppins, sans-serif',
            backgroundColor: 'var(--theme-color)',
            color: 'white',
            '&:hover': {
              backgroundColor: 'var(--theme-color-darken)',
            },
          }}
        >
          Sí
        </Button>
      </DialogActions>
    </Dialog>
  );
};

export default AddMoreServicesPopup;
