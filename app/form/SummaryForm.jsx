import React, { useState, useEffect } from "react";
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
      className="tab-panel" // Aplicar clase CSS
    >
      {value === index && <Box p={3}>{children}</Box>}
    </div>
  );
};
const SummaryForm = ({ onEditSelections, onAddMoreServices, userData }) => {
  const { handleSubmit, reset } = useForm();
  const { selections } = useStore();
  const [value, setValue] = useState(0);
  const [isEditing, setIsEditing] = useState(false);
  const [editableUserData, setEditableUserData] = useState(userData);
  const [showSuccess, setShowSuccess] = useState(false);

  const apiBaseUrl = FSF_data.api_base_url.user_info;

  useEffect(() => {
    if (userData) {
      setEditableUserData(userData);
    }
  }, [userData]);

  const handleChange = (event, newValue) => {
    setValue(newValue);
  };

  const onSubmit = () => {
    const finalData = {
      ...editableUserData,
      selections,
    };
  
    fetch(`${apiBaseUrl}/${editableUserData.post_id}`, {
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
      
      // Temporizador para recargar la página después de 1 segundo
      setTimeout(() => {
        window.location.reload(); // Recargar la página para reiniciar la app
      }, 1000); // 1000 milisegundos = 1 segundo
    })
    .catch((error) => {
      console.error('Error:', error);
      alert('Houve um erro ao enviar a cotação.');
    });
  };
  
  const handleEditUserData = () => {
    setIsEditing(true);
  };

  const handleSaveUserData = () => {
    setIsEditing(false);
  };

  const handleCloseSuccessMessage = () => {
    setShowSuccess(false);
    reset(); // Reset the form
    setValue(0); // Reset the tab value
    setIsEditing(false); // Ensure we are not in editing mode
    setEditableUserData(userData); // Reset the user data
  };
  
  
   // Reset the form setValue(0); // Reset the tab value setEditableUserData(userData); // Reset the user data };

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
    <Box className="summary-form">
      {showSuccess ? (
        <SuccessMessage onClose={handleCloseSuccessMessage} />
      ) : (
        <>
          <Typography variant="h5" gutterBottom className="heading">
          Resumo das Seleções
          </Typography>
          <form onSubmit={handleSubmit(onSubmit)}>
            <Paper className="form-paper">
              <Typography variant="h6" className="heading">
              Informação do Utilizador
              </Typography>
              <Box
                display="flex"
                flexDirection="column"
                alignItems="center"
                sx={{ p: 2 }}
              >
                {isEditing ? (
                  <>
                    <TextField
                      label="Nome"
                      fullWidth
                      value={editableUserData.nombre}
                      onChange={(e) =>
                        setEditableUserData({
                          ...editableUserData,
                          nombre: e.target.value,
                        })
                      }
                      margin="normal"
                      variant="outlined"
                      sx={{ mb: 2 }}
                    />
                    <TextField
                      label="Email"
                      fullWidth
                      value={editableUserData.email}
                      onChange={(e) =>
                        setEditableUserData({
                          ...editableUserData,
                          email: e.target.value,
                        })
                      }
                      margin="normal"
                      variant="outlined"
                      sx={{ mb: 2 }}
                    />
                    <TextField
                      label="WhatsApp"
                      fullWidth
                      value={editableUserData.whatsapp}
                      onChange={(e) =>
                        setEditableUserData({
                          ...editableUserData,
                          whatsapp: e.target.value,
                        })
                      }
                      margin="normal"
                      variant="outlined"
                      sx={{ mb: 2 }}
                    />
                    <Button
                      variant="contained"
                      color="primary"
                      onClick={handleSaveUserData}
                      className="custom-button"
                    >
                      Guardar
                    </Button>
                  </>
                ) : (
                  <>
                    <Box
                      sx={{
                        p: 2,
                        borderRadius: 2,
                        mb: 2,
                        width: "100%",
                        display: "flex",
                        flexDirection: "column",
                        alignItems: "flex-start",
                      }}
                    >
                      <Typography
                        sx={{
                          marginBottom: 1,
                          color: "var(--heading-color)",
                          fontWeight: "bold",
                          fontFamily: "Poppins, sans-serif",
                        }}
                      >
                        Nome
                      </Typography>
                      <Typography
                        sx={{
                          marginBottom: 2,
                          color: "var(--font-color)",
                          width: "100%",
                          padding: "0.5rem 1rem",
                          borderRadius: 1,
                          border: "1px solid var(--border-color)",
                          fontFamily: "Poppins, sans-serif",
                        }}
                      >
                        {editableUserData.nombre}
                      </Typography>
                      <Typography
                        sx={{
                          marginBottom: 1,
                          color: "var(--heading-color)",
                          fontWeight: "bold",
                          fontFamily: "Poppins, sans-serif",
                        }}
                      >
                        Email
                      </Typography>
                      <Typography
                        sx={{
                          marginBottom: 2,
                          color: "var(--font-color)",
                          width: "100%",
                          padding: "0.5rem 1rem",
                          borderRadius: 1,
                          border: "1px solid var(--border-color)",
                          fontFamily: "Poppins, sans-serif",
                        }}
                      >
                        {editableUserData.email}
                      </Typography>
                      <Typography
                        sx={{
                          marginBottom: 1,
                          color: "var(--heading-color)",
                          fontWeight: "bold",
                          fontFamily: "Poppins, sans-serif",
                        }}
                      >
                        WhatsApp
                      </Typography>
                      <Typography
                        sx={{
                          marginBottom: 2,
                          color: "var(--font-color)",
                          width: "100%",
                          padding: "0.5rem 1rem",
                          borderRadius: 1,
                          border: "1px solid var(--border-color)",
                          fontFamily: "Poppins, sans-serif",
                        }}
                      >
                        {editableUserData.whatsapp}
                      </Typography>
                      <Box
                        sx={{
                          display: "flex",
                          justifyContent: "center",
                          width: "100%",
                        }}
                      >
                        <Button
                          variant="contained"
                          color="primary"
                          onClick={handleEditUserData}
                          className="custom-button"
                        >
                          Editar Informação
                        </Button>
                      </Box>
                    </Box>
                  </>
                )}
              </Box>
            </Paper>
            <Box sx={{ borderBottom: 1, borderColor: "var(--border-color)" }}>
              <Tabs
                value={value}
                onChange={handleChange}
                aria-label="Summary Tabs"
              >
                {completedServices.map((service, index) => (
                  <Tab
                    key={service.uniqueServiceId}
                    label={service.serviceTitle}
                    sx={{ fontFamily: "Poppins, sans-serif" }}
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
                    onClick={onAddMoreServices}
                    className="custom-button"
                  >
                    Adicionar Outro Serviço
                  </Button>
                </Box>
              </TabPanel>
            ))}
            
              <Box display="flex" justifyContent="center" mb={2}>
                {" "}
                <Button
                  variant="contained"
                  color="primary"
                  type="submit"
                  className="custom-button"
                >
                  {" "}
                  Enviar Cotação {" "}
                </Button>{" "}
              </Box>
            
          </form>
        </>
      )}
    </Box>
  );
};

export default SummaryForm;
