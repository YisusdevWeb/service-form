import React, { useState, useEffect } from "react";
import { Box, Typography, Paper, Button } from "@mui/material";
import useStore from "./store/store.js";
import StepForm from "./form/StepForm.jsx";
import UserForm from "./form/UserForm.jsx";
import Preloader from "./components/Preloader";
import ResetPopup from "./components/ResetPopup";
import NoPhasePopup from "./components/NoPhasePopup";
import FloatingResetButton from "./components/FloatingResetButton";

const App = () => {
  const [showUserForm, setShowUserForm] = useState(true);
  const [userData, setUserData] = useState(null);
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

  const handleUserSubmit = (data) => {
    setUserData(data);
    setShowUserForm(false);
  };

  const handleComplete = () => {
    setShowSummary(true);
  };

  const handleServiceComplete = (completedService) => {
    setCompletedServices((prev) => [...prev, completedService.id]);
    setAvailableServices((prev) =>
      prev.filter((service) => service.id !== completedService.id)
    );
  };

  const handleResetService = () => {
    setResetPopupOpen(true);
  };

  const handleConfirmReset = () => {
    resetService();
    setAvailableServices(servicos); // Resetear los servicios disponibles
    setShowUserForm(true);          // Volver a mostrar el formulario de usuario
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
      <Box
        p={5}
        sx={{
          backgroundColor: "#f9f9f9",
          maxWidth: "800px",
          mx: "auto"
        }}
      >
        {showUserForm ? (
          <UserForm onUserSubmit={handleUserSubmit} />
        ) : !currentService ? (
          <Box>
            <Typography variant="h5" gutterBottom sx={{ color: "#0f4c80" }}>
              Servicios
            </Typography>
            <ul style={{ listStyleType: "none", padding: 0 }}>
              {availableServices.map((servico) => (
                <li
                  key={servico.id}
                  onClick={() => handleServiceClick(servico)}
                  style={{
                    cursor: "pointer",
                    marginBottom: "10px",
                    padding: "10px",
                    backgroundColor: "#ffffff",
                    borderRadius: "5px",
                    transition: "background-color 0.3s, transform 0.3s",
                    boxShadow: "0 2px 5px rgba(0,0,0,0.15)",
                    borderColor: "#bebebe",
                    borderWidth: "1px",
                    borderStyle: "solid",
                  }}
                >
                  <Typography variant="h6" color="#0f4c80">
                    {servico.titulo}
                  </Typography>
                </li>
              ))}
            </ul>
          </Box>
        ) : (
          <StepForm
            onComplete={handleComplete}
            onServiceComplete={handleServiceComplete}
            userData={userData} // Pasar la información del usuario
          />
        )}
      </Box>
      <FloatingResetButton onClick={handleClearLocalStorage} />
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
