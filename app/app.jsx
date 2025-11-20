import React, { useState, useEffect, lazy, Suspense } from "react";
import { Box, Typography, Paper } from "@mui/material";
import useStore from "./store/store.js";
const StepForm = lazy(() => import("./form/StepForm.jsx"));
const UserForm = lazy(() => import("./form/UserForm.jsx"));
import Logo from "./components/Logo"; // Importa el componente Logo
const FloatingResetButton = lazy(() => import("./components/FloatingResetButton"));
const Preloader = lazy(() => import("./components/Preloader"));
const NoPhasePopup = lazy(() => import("./components/NoPhasePopup"));

const App = () => {
  const [showUserForm, setShowUserForm] = useState(true);
  const [userData, setUserData] = useState(null);
  const [loading, setLoading] = useState(true);
  const [noPhasePopupOpen, setNoPhasePopupOpen] = useState(false);
  const [serviceWithoutPhases, setServiceWithoutPhases] = useState(null);
  const { currentService, setCurrentService, resetService, setCurrentPhase, setSelections } = useStore();
  const servicios = FSF_data.servicios || [];

  const servicos = servicios.map((servicio) => ({
    id: servicio.ID,
    titulo: servicio.title,
    fases_do_servico: servicio.acf ? servicio.acf.fases_do_servico : [],
  }));

  const [availableServices, setAvailableServices] = useState(servicos);
  const [completedServices, setCompletedServices] = useState([]);
  useEffect(() => {
    // Limpiar localStorage y resetear el estado al cargar la página
    localStorage.clear();
    setCurrentService(null);
    setCurrentPhase(0);
    setSelections({});
    setAvailableServices(servicos);
    const timer = setTimeout(() => {
      setLoading(false);
    }, 2000);

    return () => clearTimeout(timer);
  }, [setCurrentService, setCurrentPhase, setSelections]);
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

  const handleServiceClick = (service) => {
    resetService(); // Limpiar estado anterior
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
    return <Suspense fallback={<div>Loading...</div>}>
             <Preloader />
           </Suspense>;
  }

  return (
    <div className="funil-services-form-root">
      <Box
        sx={{
          maxWidth: "600px",
          mx: "auto",
          p: { xs: 0, sm: 3, md: 5 } // Diferente padding según el tamaño de la pantalla
        }}
      >
        {showUserForm ? (
          <Suspense fallback={<div>Loading...</div>}>
            <UserForm onUserSubmit={handleUserSubmit} />
          </Suspense>
        ) : !currentService ? (
          <Box>
            <Logo /> {/* Usando el componente Logo aquí */}
            <Typography variant="h5" gutterBottom sx={{ color: 'var(--heading-color)', fontWeight: 'bold', textAlign: 'center',fontSize: '2rem', mb:3.75  }}>
              Selecionar um serviço
            </Typography>
            <ul style={{ listStyleType: "none", padding: 0 }}>
              {[...availableServices]
                .sort((a, b) => {
                  if (a.titulo < b.titulo) return -1;
                  if (a.titulo > b.titulo) return 1;
                  return 0;
                })
                .map((servico) => (
                  <li
                    key={servico.id}
                    onClick={() => handleServiceClick(servico)}
                    style={{
                      cursor: "pointer",
                      marginBottom: "10px",
                      padding: "10px",
                      backgroundColor: "rgba(255, 255, 255, 0.9)",
                      borderRadius: "8px",
                      transition: "background-color 0.3s, transform 0.3s",
                      boxShadow: "0 4px 15px rgba(0,0,0,0.2)",
                      border: "1px solid rgba(255, 255, 255, 0.3)",
                    }}
                  >
                    <Typography variant="h6" sx={{ color: 'var(--input-text)', fontWeight: '600' }}>
                      {servico.titulo}
                    </Typography>
                  </li>
                ))}
            </ul>
          </Box>
        ) : (
          <Suspense fallback={<div>Loading...</div>}>
            <StepForm
              onComplete={handleComplete}
              onServiceComplete={handleServiceComplete}
              userData={userData} // Pasar la información del usuario
            />
          </Suspense>
        )}
      </Box>
      {/* <FloatingResetButton onClick={handleClearLocalStorage} /> */}
      <Suspense fallback={<div>Loading...</div>}>
        <NoPhasePopup
          open={noPhasePopupOpen}
          onClose={handleCloseNoPhasePopup}
          serviceTitle={serviceWithoutPhases?.titulo}
        />
      </Suspense>
    </div>
  );
};

export default App;
