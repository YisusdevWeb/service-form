import React from 'react';
import { Dialog, DialogActions, DialogContent, DialogContentText, DialogTitle, Button } from '@mui/material';

const NoPhasePopup = ({ open, onClose, serviceTitle }) => {
  return (
    <Dialog
      open={open}
      onClose={onClose}
      aria-labelledby="no-phase-popup-title"
      aria-describedby="no-phase-popup-description"
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
      <DialogTitle id="no-phase-popup-title" sx={{ fontFamily: 'Poppins, sans-serif', color: 'var(--heading-color)', fontWeight: 'bold', textAlign: 'center' }}>
        {FSF_data?.form_texts?.notice || 'Notice'}
      </DialogTitle>
      <DialogContent>
        <DialogContentText id="no-phase-popup-description" sx={{ fontFamily: 'Poppins, sans-serif', color: 'var(--font-color)', textAlign: 'center' }}>
          {FSF_data?.form_texts?.service_no_phase ? 
            FSF_data.form_texts.service_no_phase.replace('%s', serviceTitle) : 
            `The service "${serviceTitle}" has no phase options available.`}
        </DialogContentText>
      </DialogContent>
      <DialogActions sx={{ justifyContent: 'center', paddingBottom: '1rem' }}>
        <Button
          onClick={onClose}
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
          {FSF_data?.form_texts?.close || 'Close'}
        </Button>
      </DialogActions>
    </Dialog>
  );
};

export default NoPhasePopup;