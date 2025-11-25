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
      PaperProps={{
        sx: {
          backgroundColor: 'rgba(255, 255, 255, 0.08)', // Fondo transparente estilo callout
          backdropFilter: 'blur(10px)',
          WebkitBackdropFilter: 'blur(10px)',
          border: '1px solid rgba(255, 255, 255, 0.25)',
          borderRadius: '14px',
          boxShadow: '0 8px 28px rgba(0, 0, 0, 0.12) inset',
          color: 'var(--font-color)',
          padding: '1rem'
        }
      }}
    >
      <DialogTitle id="add-more-services-popup-title" sx={{ fontFamily: 'Poppins, sans-serif', color: 'var(--heading-color)', fontWeight: 'bold', textAlign: 'center' }}>
      Add More Services
      </DialogTitle>
      <DialogContent>
        <DialogContentText id="add-more-services-popup-description" sx={{ fontFamily: 'Poppins, sans-serif', color: 'var(--font-color)', textAlign: 'center' }}>
        Would you like to add more services?
        </DialogContentText>
      </DialogContent>
      <DialogActions
        sx={{
          display: 'flex',
          justifyContent: 'center', // Centramos los botones
          gap: 2, // Espaciado entre botones
          paddingBottom: '1rem'
        }}
      >
        <Button
          onClick={onClose}
          sx={{
            fontFamily: 'Poppins, sans-serif',
            backgroundColor: 'rgba(255, 255, 255, 0.1)',
            color: 'white',
            border: '1px solid rgba(255, 255, 255, 0.3)',
            borderRadius: '30px',
            padding: '8px 24px',
            textTransform: 'uppercase',
            fontWeight: 'bold',
            '&:hover': {
              backgroundColor: 'rgba(255, 255, 255, 0.2)',
              borderColor: 'white'
            },
          }}
        >
         No
         
        </Button>
        <Button
          onClick={onConfirm}
          sx={{
            fontFamily: 'Poppins, sans-serif',
            backgroundColor: 'var(--theme-color)',
            color: 'white',
            border: '1px solid var(--theme-color)',
            borderRadius: '30px',
            padding: '8px 24px',
            textTransform: 'uppercase',
            fontWeight: 'bold',
            boxShadow: '0 4px 15px rgba(0,0,0,0.3)',
            '&:hover': {
              backgroundColor: 'var(--theme-color-darken)',
              boxShadow: '0 6px 20px rgba(0,0,0,0.4)',
            },
          }}
        >
          Yes
        </Button>
      </DialogActions>
    </Dialog>
  );
};

export default AddMoreServicesPopup;
