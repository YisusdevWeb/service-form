import React, { useCallback, useEffect, useState } from 'react';
import { Box, Button, Typography, Stepper, Step, StepLabel, Paper, CssBaseline } from '@mui/material';
import { useForm } from 'react-hook-form';
import { createTheme, ThemeProvider } from '@mui/material/styles';
import useStore from '../store/store.js';
import AlertSnackbar from '../components/AlertSnackbar';
import { handleSelectionFactory } from '../utils/handleSelection';
import AddMoreServicesPopup from '../components/AddMoreServicesPopup';
import SummaryForm from './SummaryForm';

const theme = createTheme({
  components: {
    MuiStepLabel: {
      styleOverrides: {
        label: {
          display: 'none',
        },
      },
    },
  },
});

const StepForm = React.memo(({ onComplete, onServiceComplete }) => {
  const { register, handleSubmit, setValue, getValues, watch } = useForm();
  const { currentService, currentPhase, setCurrentPhase, addSelection, selections, resetService } = useStore();
  const [snackbarOpen, setSnackbarOpen] = useState(false);
  const [snackbarMessage, setSnackbarMessage] = useState('');
  const [snackbarSeverity, setSnackbarSeverity] = useState('info');
  const [addMoreServicesPopupOpen, setAddMoreServicesPopupOpen] = useState(false);
  const [showSummary, setShowSummary] = useState(false);

  const handleSelection = useCallback(
    handleSelectionFactory(
      currentPhase,
      selections,
      (phase, selection) => addSelection(currentService.uniqueId, phase, selection),
      currentService,
      setCurrentPhase,
      setSnackbarMessage,
      setSnackbarSeverity,
      setSnackbarOpen
    ),
    [currentPhase, selections, currentService, setCurrentPhase, setSnackbarMessage, setSnackbarSeverity, setSnackbarOpen, addSelection]
  );

  useEffect(() => {
    const currentSelections = selections[currentService?.uniqueId]?.[currentPhase];
    if (currentSelections) {
      Object.keys(currentSelections).forEach((option) => {
        setValue(option, currentSelections[option]);
      });
    }
  }, [currentPhase, selections, setValue, currentService]);

  const onSubmit = () => {
    const currentSelections = selections[currentService?.uniqueId]?.[currentPhase] || {};
    const isSelected = Object.values(currentSelections).some((value) => value === true);

    if (!isSelected) {
      setSnackbarMessage('Debes seleccionar al menos una opción para continuar.');
      setSnackbarSeverity('error');
      setSnackbarOpen(true);
      return;
    }

    if (currentPhase < currentService.fases_do_servico.length - 1) {
      setCurrentPhase(currentPhase + 1);
    } else {
      setAddMoreServicesPopupOpen(true);
    }
  };

  const handleConfirmAddMoreServices = () => {
    onServiceComplete(currentService);
    resetService();
    setAddMoreServicesPopupOpen(false);
  };

  const handleCloseAddMoreServicesPopup = () => {
    setAddMoreServicesPopupOpen(false);
    setShowSummary(true);
  };

  const handleStepClick = (step) => {
    if (step <= currentPhase) {
      setCurrentPhase(step);
    }
  };

  const handleCloseSnackbar = () => {
    setSnackbarOpen(false);
  };

  return (
    <ThemeProvider theme={theme}>
      <CssBaseline />
      {showSummary ? (
        <SummaryForm />
      ) : (
        <Box>
          <Typography variant="h4" gutterBottom sx={{ color: '#0f4c80', textAlign: 'center', fontWeight: 'bold' }}>{currentService.titulo}</Typography>
          <form onSubmit={handleSubmit(onSubmit)}>
            <Stepper activeStep={currentPhase} sx={{ mb: 3, display: 'flex', justifyContent: 'center' }} alternativeLabel>
              {currentService.fases_do_servico.map((fase, index) => (
                <Step key={fase.id_fase || index} onClick={() => handleStepClick(index)}>
                  <StepLabel></StepLabel>
                </Step>
              ))}
            </Stepper>
            <Typography sx={{ textAlign: 'center', mb: 2 }}>
              Paso {currentPhase + 1} de {currentService.fases_do_servico.length}
            </Typography>
            <Paper sx={{ padding: 3, backgroundColor: '#f4f4f4', borderRadius: 2, mb: 2, boxShadow: '0 2px 5px rgba(0,0,0,0.1)' }}>
              <Typography variant="h6" sx={{ color: '#0f4c80', fontWeight: 'bold' }}>{currentService.fases_do_servico[currentPhase]?.titulo || 'Sin título'}</Typography>
              <Typography variant="body1" gutterBottom sx={{ color: '#555', mb: 2 }}>{currentService.fases_do_servico[currentPhase]?.descricao || 'Sin descripción'}</Typography>
              {currentService.fases_do_servico[currentPhase]?.escrever_as_opcoes && (
                <Box display="flex" flexWrap="wrap" gap={2}>
                  {currentService.fases_do_servico[currentPhase].escrever_as_opcoes.map((opcao) => (
                    <Button
                      key={opcao.id_opcion || opcao.titulo}
                      variant={watch(opcao.titulo) ? 'contained' : 'outlined'}
                      onClick={() => handleSelection(opcao.titulo, !getValues(opcao.titulo))}
                      sx={{
                        flex: '1 1 calc(50% - 16px)',
                        minWidth: '120px',
                        textTransform: 'none',
                        '@media (max-width: 600px)': {
                          flex: '1 1 100%',
                        },
                      }}
                    >
                      {opcao.titulo}
                    </Button>
                  ))}
                </Box>
              )}
            </Paper>
            <Box mt={4} display="flex" justifyContent="space-between">
              {currentPhase > 0 && (
                <Button variant="contained" color="primary" onClick={() => setCurrentPhase(currentPhase - 1)}>Anterior</Button>
              )}
              <Button variant="contained" color="primary" type="submit">
                {currentPhase < currentService.fases_do_servico.length - 1 ? 'Siguiente' : 'Completar'}
              </Button>
            </Box>
          </form>
          <AlertSnackbar
            open={snackbarOpen}
            message={snackbarMessage}
            severity={snackbarSeverity}
            onClose={handleCloseSnackbar}
          />
          <AddMoreServicesPopup
            open={addMoreServicesPopupOpen}
            onClose={handleCloseAddMoreServicesPopup}
            onConfirm={handleConfirmAddMoreServices}
          />
        </Box>
      )}
    </ThemeProvider>
  );
});

export default StepForm;
