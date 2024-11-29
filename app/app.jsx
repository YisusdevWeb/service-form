import React, { useState, useEffect } from 'react';
import { Box, Typography, Paper, Button } from '@mui/material';
import useStore from './store/store.js';
import StepForm from './form/StepForm.jsx';
import SummaryTabs from './components/SummaryTabs';
import Preloader from './components/Preloader';
import ResetPopup from './components/ResetPopup';
import NoPhasePopup from './components/NoPhasePopup';

const App = () => {
  const [showSummary, setShowSummary] = useState(false);
  const [loading, setLoading] = useState(true);
  const [resetPopupOpen, setResetPopupOpen] = useState(false);
  const [noPhasePopupOpen, setNoPhasePopupOpen] = useState(false);
  const [serviceWithoutPhases, setServiceWithoutPhases] = useState(null);
  const { currentService, setCurrentService, resetService } = useStore();
  const servicios = FSF_data.servicios || [];

  const servicos = servicios.map((servicio) => ({
    id: servicio.ID,
    titulo: servicio.title,
    fases_do_servico: servicio.acf ? servicio.acf.fases_do_servico : [],
  }));

  const [availableServices, setAvailableServices] = useState(servicos);
  const [completedServices, setCompletedServices] = useState([]);

  useEffect(() => {
    const timer = setTimeout(() => {
      setLoading(false);
    }, 2000);

    return () => clearTimeout(timer);
  }, []);

  useEffect(() => {
    if (!loading && servicos.length === 0) {
      setCurrentService(null);
    }
  }, [loading, servicos, setCurrentService]);

  const handleComplete = () => {
    setShowSummary(true);
  };

  const handleServiceComplete = (completedService) => {
    setCompletedServices((prev) => [...prev, completedService.id]);
    setAvailableServices((prev) => prev.filter((service) => service.id !== completedService.id));
  };

  const handleResetService = () => {
    setResetPopupOpen(true);
  };

  const handleConfirmReset = () => {
    resetService();
    setAvailableServices(servicos); // Resetear los servicios disponibles
    setShowSummary(false);
    setResetPopupOpen(false);
  };

  const handleCloseResetPopup = () => {
    setResetPopupOpen(false);
  };

  const handleServiceClick = (service) => {
    if (!service.fases_do_servico || service.fases_do_servico.length === 0) {
      setServiceWithoutPhases(service);
      setNoPhasePopupOpen(true);
    } else {
      setCurrentService(service);
    }
  };

  const handleCloseNoPhasePopup = () => {
    setNoPhasePopupOpen(false);
  };

  const handleClearLocalStorage = () => {
    localStorage.clear();
    window.location.reload(); // Recargar la página para aplicar los cambios
  };

  if (loading) {
    return <Preloader />;
  }

  return (
    <>
      <Box p={5} sx={{ backgroundColor: '#f9f9f9', display: 'flex', flexDirection: { xs: 'column', md: 'row' }, gap: 3 }}>
        <Box
          sx={{
            flex: 1,
          }}
        >
          <Paper elevation={3} sx={{ padding: 2, borderRadius: 2, backgroundColor: '#e6e6e6' }}>
            <Typography variant="h5" gutterBottom sx={{ color: '#0f4c80' }}>Servicios</Typography>
            <ul style={{ listStyleType: 'none', padding: 0 }}>
              {availableServices.map((servico) => (
                <li
                  key={servico.id}
                  onClick={() => !currentService && handleServiceClick(servico)}
                  style={{
                    cursor: currentService ? 'not-allowed' : 'pointer',
                    marginBottom: '10px',
                    padding: '10px',
                    backgroundColor: currentService && currentService.id === servico.id ? '#d3d3ff' : currentService ? 'none' : '#ffffff',
                    borderRadius: '5px',
                    transition: 'background-color 0.3s, transform 0.3s',
                    boxShadow: currentService && currentService.id !== servico.id ? 'none' : '0 2px 5px rgba(0,0,0,0.15)',
                    borderColor: '#bebebe',
                    borderWidth: '1px',
                    borderStyle: currentService && currentService.id === servico.id ? 'solid' : 'none',
                    display: currentService && currentService.id === servico.id ? 'block' : currentService ? 'none' : 'block',
                  }}
                  onMouseEnter={(e) => {
                    if (!currentService || currentService.id === servico.id) {
                      e.currentTarget.style.backgroundColor = '#e6e6e6';
                      e.currentTarget.style.transform = 'scale(1.03)';
                    }
                  }}
                  onMouseLeave={(e) => {
                    if (!currentService || currentService.id !== servico.id) {
                      e.currentTarget.style.backgroundColor = '#ffffff';
                      e.currentTarget.style.transform = 'scale(1)';
                    }
                  }}
                >
                  <Typography variant="h6" color={currentService && currentService.id === servico.id ? "secondary" : "#0f4c80"}>{servico.titulo}</Typography>
                </li>
              ))}
            </ul>
            {currentService && (
              <Box
                sx={{
                  mt: 2,
                  textAlign: 'center',
                }}
              >
                <Button variant="contained" color="secondary" onClick={handleResetService}>
                  Habilitar Otros Servicios
                </Button>
              </Box>
            )}
            <Box
              sx={{
                mt: 2,
                textAlign: 'center',
              }}
            >
              <Button variant="contained" color="error" onClick={handleClearLocalStorage}>
                Reiniciar Todo
              </Button>
            </Box>
          </Paper>
        </Box>
        <Box sx={{ flex: 2 }}>
          <Paper elevation={3} sx={{ padding: 2, borderRadius: 2, backgroundColor: '#f9f9f9' }}>
            {currentService && currentService.fases_do_servico ? (
              showSummary ? <SummaryTabs /> : <StepForm onComplete={handleComplete} onServiceComplete={handleServiceComplete} />
            ) : (
              <Typography sx={{ color: '#0f4c80' }}>Seleccione un servicio para ver los detalles.</Typography>
            )}
          </Paper>
        </Box>
      </Box>
      <ResetPopup
        open={resetPopupOpen}
        onClose={handleCloseResetPopup}
        onConfirm={handleConfirmReset}
      />
      <NoPhasePopup
        open={noPhasePopupOpen}
        onClose={handleCloseNoPhasePopup}
        serviceTitle={serviceWithoutPhases?.titulo}
      />
    </>
  );
};

export default App;
