import React, { useState, useEffect, useRef } from "react";
import {
  Box,
  Typography,
  Paper,
  Tabs,
  Tab,
  Button,
  TextField,
} from "@mui/material";
import { useForm } from "react-hook-form";
import useStore from "../store/store.js";
import SuccessMessage from "../components/SuccessMessage";
import "../../assets/scss/styles.scss";

const TabPanel = ({ children, value, index, ...other }) => {
  return (
    <div
      role="tabpanel"
      hidden={value !== index}
      id={`tabpanel-${index}`}
      aria-labelledby={`tab-${index}`}
      {...other}
      className="tab-panel"
    >
      {value === index && <Box p={3}>{children}</Box>}
    </div>
  );
};

const SummaryForm = ({ onEditSelections, onAddMoreServices, userData }) => {
  const { handleSubmit, reset } = useForm();
  const { selections } = useStore();
  const [value, setValue] = useState(0);
  const [showSuccess, setShowSuccess] = useState(false);
  const apiBaseUrl = FSF_data.api_base_url.user_info;

  const handleChange = (event, newValue) => {
    setValue(newValue);
  };

  const formRef = useRef(null); // Añadir referencia al contenedor del formulario

  const onSubmit = () => {
    const finalData = {
      ...userData,
      selections,
    };
    fetch(`${apiBaseUrl}/${userData.post_id}`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(finalData),
    })
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then(data => {
      console.log('Success:', data);
      setShowSuccess(true);
      setTimeout(() => {
        window.location.reload();
      }, 1000);
    })
    .catch((error) => {
      console.error('Error:', error);
      alert('Houve um erro ao enviar a cotação.');
    });
  };

  const handleCloseSuccessMessage = () => {
    setShowSuccess(false);
    reset(); 
    setValue(0);
  };

  // Enfocar el formulario después de mostrar el mensaje de éxito
  useEffect(() => {
    if (showSuccess && formRef.current) {
      formRef.current.scrollIntoView({ behavior: 'smooth' });
    }
  }, [showSuccess]);

  // Enfocar el formulario después de agregar un nuevo servicio
  const handleAddMoreServices = () => {
    onAddMoreServices();
    if (formRef.current) {
      formRef.current.scrollIntoView({ behavior: 'smooth' });
    }
  };

  // Enfocar el formulario cuando se carga por primera vez
  useEffect(() => {
    if (formRef.current) {
      formRef.current.scrollIntoView({ behavior: 'smooth' });
    }
  }, []);

  const completedServices = Object.entries(selections).map(
    ([uniqueServiceId, serviceSelections]) => {
      const serviceTitle =
        serviceSelections.serviceTitle || `Servicio ${uniqueServiceId}`;
      const phases = Object.keys(serviceSelections)
        .filter((phaseId) => phaseId !== "serviceTitle")
        .map((phaseId) => {
          const phaseSelections = serviceSelections[phaseId];
          const phaseTitle = phaseSelections.phaseTitle;
          return {
            phaseId,
            phaseTitle,
            phaseSelections,
          };
        });

      return { uniqueServiceId, serviceTitle, phases };
    }
  );

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
            {/* Integración de Secciones */}
            <Paper className="form-paper">
              <Box display="flex" flexDirection="column" alignItems="center" sx={{ p: 2 }}>
                {/* Tabs Section */}
                <Box sx={{ width: '100%', mb: 2 }}>
                  <Box sx={{ borderBottom: 1, borderColor: "var(--border-color)" }}>
                    <Tabs
                      value={value}
                      onChange={handleChange}
                      aria-label="Summary Tabs"
                      variant="scrollable"
                      scrollButtons="auto"
                    >
                      {completedServices.map((service, index) => (
                        <Tab
                          key={service.uniqueServiceId}
                          label={service.serviceTitle}
                          sx={{ fontFamily: "Poppins, sans-serif", textTransform: "none" }}
                        />
                      ))}
                    </Tabs>
                  </Box>
                  {completedServices.map((service, index) => (
                    <TabPanel
                      key={service.uniqueServiceId}
                      value={value}
                      index={index}
                    >
                      <Paper className="tab-panel">
                        <Typography variant="h6" className="phase-title">
                          {service.serviceTitle}
                        </Typography>
                        {service.phases.map(
                          ({ phaseId, phaseTitle, phaseSelections }) => (
                            <Box key={phaseId} mb={2}>
                              <Typography variant="h6" className="phase-title">
                                {phaseTitle}
                              </Typography>
                              <ul>
                                {Object.entries(phaseSelections).map(
                                  ([option, selected]) =>
                                    selected && option !== "phaseTitle" ? (
                                      <li key={option}>{option}</li>
                                    ) : null
                                )}
                              </ul>
                            </Box>
                          )
                        )}
                      </Paper>
                      <Box className="buttons">
                        <Button
                          variant="contained"
                          color="primary"
                          onClick={() => onEditSelections(service.uniqueServiceId)}
                          className="custom-button"
                        >
                          Editar Último Serviço
                        </Button>
                        <Button
                          variant="contained"
                          color="primary"
                          onClick={handleAddMoreServices} // Usar la función modificada
                          className="custom-button"
                        >
                          Adicionar Outro Serviço
                        </Button>
                      </Box>
                    </TabPanel>
                  ))}
                </Box>
              </Box>

              <Box display="flex" justifyContent="center" mb={2}>
                <Button
                  variant="contained"
                  color="primary"
                  type="submit"
                  className="custom-button"
                >
                  Enviar Cotação
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
