import React, { useState, useEffect, useRef } from "react";
import {
  Box,
  Typography,
  Paper,
  Tabs,
  Tab,
  Button,
} from "@mui/material";
import { useForm } from "react-hook-form";
import useStore from "../store/store.js";
import SuccessMessage from "../components/SuccessMessage";
import { useNavigate } from "react-router-dom"; // Importa useNavigate
import "../../assets/scss/styles.scss";

// Separación de TabPanel en su propio componente
const TabPanel = ({ children, value, index }) => {
  return (
    <div
      role="tabpanel"
      hidden={value !== index}
      id={`tabpanel-${index}`}
      aria-labelledby={`tab-${index}`}
      className="tab-panel"
    >
      {value === index && <Box p={3}>{children}</Box>}
    </div>
  );
};

// Resumen de selección
const SummaryForm = ({ onEditSelections, onAddMoreServices, userData }) => {
  const { handleSubmit, reset } = useForm();
  const { selections } = useStore();
  const [value, setValue] = useState(0);
  const [showSuccess, setShowSuccess] = useState(false);
  const apiBaseUrl = FSF_data.api_base_url.user_info;
  const formRef = useRef(null);
  const navigate = useNavigate(); // Obtén la función de navegación

  // Funciones de manejo de estado y eventos
  const handleChange = (event, newValue) => setValue(newValue);
  const handleAddMoreServicesAndScroll = () => {
    onAddMoreServices();
    scrollToForm();
  };

  const scrollToForm = () => {
    if (formRef.current) {
      formRef.current.scrollIntoView({ behavior: "smooth" });
    }
  };

  const onSubmit = async () => {
    const finalData = { ...userData, selections };
    try {
      const response = await fetch(`${apiBaseUrl}/${userData.post_id}`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(finalData),
      });
      if (!response.ok) throw new Error("Error de red");
      const data = await response.json();
      console.log("Success:", data);
      setShowSuccess(true);

        navigate("/"); // Redirige al home después de un segundo
        setTimeout(() => {
          window.location.reload();  // Esto recargará la página después de un pequeño retraso
        }, 2000);
    } catch (error) {
      console.error("Error:", error);
      alert("Houve um erro ao enviar a cotação.");
    }
  };

  const handleCloseSuccessMessage = () => {
    setShowSuccess(false);
    reset();
    setValue(0);
  };

  // Enfocar el formulario después de mostrar el mensaje de éxito
  useEffect(() => {
    if (showSuccess) scrollToForm();
  }, [showSuccess]);

  // Enfocar el formulario al cargar
  useEffect(() => scrollToForm(), []);

  // Procesar servicios seleccionados
  const completedServices = Object.entries(selections).map(([uniqueServiceId, serviceSelections]) => {
    const serviceTitle = serviceSelections.serviceTitle || `Servicio ${uniqueServiceId}`;
    const phases = Object.keys(serviceSelections)
      .filter(phaseId => phaseId !== "serviceTitle")
      .map(phaseId => ({
        phaseId,
        phaseTitle: serviceSelections[phaseId].phaseTitle,
        phaseSelections: serviceSelections[phaseId],
      }));
    return { uniqueServiceId, serviceTitle, phases };
  });

  if (!userData) {
    return (
      <Typography variant="h5" gutterBottom className="heading">
        Informação do usuário não disponível. Por favor, volte a inserir os dados.
      </Typography>
    );
  }

  return (
    <Box className="summary-form" ref={formRef}>
      {showSuccess ? (
        <SuccessMessage onClose={handleCloseSuccessMessage} />
      ) : (
        <>
          <Typography variant="h5" gutterBottom className="heading">
            Resumo das Seleções
          </Typography>
          <form onSubmit={handleSubmit(onSubmit)}>
            <Paper className="form-paper">
              <Box display="flex" flexDirection="column" alignItems="center" sx={{ p: 2 }}>
                <Box sx={{ width: "100%", mb: 2 }}>
                  <Box sx={{ borderBottom: 1, borderColor: "var(--border-color)" }}>
                    <Tabs
                      value={value}
                      onChange={handleChange}
                      aria-label="Summary Tabs"
                      variant="scrollable"
                      scrollButtons="auto"
                    >
                      {completedServices.map(service => (
                        <Tab
                          key={service.uniqueServiceId}
                          label={service.serviceTitle}
                          sx={{ fontFamily: "Poppins, sans-serif", textTransform: "none" }}
                        />
                      ))}
                    </Tabs>
                  </Box>
                  {completedServices.map((service, index) => (
                    <TabPanel key={service.uniqueServiceId} value={value} index={index}>
                      <Paper className="tab-panel">
                        <Typography variant="h6" className="phase-title">{service.serviceTitle}</Typography>
                        {service.phases.map(({ phaseId, phaseTitle, phaseSelections }) => (
                          <Box key={phaseId} mb={2}>
                            <Typography variant="h6" className="phase-title">{phaseTitle}</Typography>
                            <ul>
                              {Object.entries(phaseSelections).map(([option, selected]) =>
                                selected && option !== "phaseTitle" ? <li key={option}>{option}</li> : null
                              )}
                            </ul>
                          </Box>
                        ))}
                      </Paper>
                      <Box className="buttons">
                        <Button
                          variant="contained"
                          color="primary"
                          onClick={() => onEditSelections(service.uniqueServiceId)}
                          className="custom-button"
                        >
                          EDITAR SERVIÇO
                        </Button>
                        <Button
                          variant="contained"
                          color="primary"
                          onClick={handleAddMoreServicesAndScroll} // Usar función optimizada
                          className="custom-button"
                        >
                          ADICIONAR SERVIÇO
                        </Button>
                      </Box>
                    </TabPanel>
                  ))}
                </Box>
              </Box>

              <Box display="flex" justifyContent="center" mb={2}>
                <Button variant="contained" color="primary" type="submit" className="custom-button">
                ENVIAR PROPOSTA
                </Button>
              </Box>
            </Paper>
          </form>
        </>
      )}
    </Box>
  );
};

export default SummaryForm;
