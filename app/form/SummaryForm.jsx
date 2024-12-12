import React, { useState, useEffect } from 'react';
import { Box, Typography, Paper, Tabs, Tab, Button, TextField } from '@mui/material';
import { useForm } from 'react-hook-form';
import useStore from '../store/store.js';
import SuccessMessage from '../components/SuccessMessage'; // Importar el nuevo componente

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
  const { register, handleSubmit, formState: { errors }, reset } = useForm();
  const { selections } = useStore();
  const [value, setValue] = useState(0);
  const [isEditing, setIsEditing] = useState(false);
  const [editableUserData, setEditableUserData] = useState(userData);
  const [showSuccess, setShowSuccess] = useState(false); // Estado para mostrar mensaje de éxito

  const apiBaseUrl = FSF_data.api_base_url.user_info;

  useEffect(() => {
    if (userData) {
      setEditableUserData(userData);
    }
  }, [userData]);

  const handleChange = (event, newValue) => {
    setValue(newValue);
  };

  const onSubmit = (data) => {
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
      setShowSuccess(true); // Mostrar mensaje de éxito
      reset();
    })
    .catch((error) => {
      console.error('Error:', error);
      alert('Hubo un error al enviar la cotización.');
    });
  };

  const handleEditUserData = () => {
    setIsEditing(true);
  };

  const handleSaveUserData = () => {
    setIsEditing(false);
  };

  const completedServices = Object.entries(selections).map(
    ([uniqueServiceId, serviceSelections]) => {
      const serviceTitle = serviceSelections.serviceTitle || `Servicio ${uniqueServiceId}`;
      const phases = Object.keys(serviceSelections)
        .filter((phaseId) => phaseId !== 'serviceTitle')
        .map((phaseId) => {
          const phaseSelections = serviceSelections[phaseId];
          const phaseTitle = phaseSelections.phaseTitle;
          return {
            phaseId,
            phaseTitle,
            phaseSelections
          };
        });

      return { uniqueServiceId, serviceTitle, phases };
    }
  );

  if (!userData) {
    return <Typography variant="h5" gutterBottom className="heading">
      Información de usuario no disponible. Por favor, vuelva a ingresar los datos.
    </Typography>;
  }
  return (
    <Box className="summary-form">
      {showSuccess ? (
        <SuccessMessage onClose={() => setShowSuccess(false)} /> // Mostrar mensaje de éxito
      ) : (
        <>
          <Typography variant="h5" gutterBottom className="heading">
            Resumen de Selecciones
          </Typography>
          <form onSubmit={handleSubmit(onSubmit)}>
            <Paper className="form-paper">
              <Typography variant="h6">Información del Usuario</Typography>
              {isEditing ? (
                <>
                  <TextField
                    label="Nombre"
                    fullWidth
                    value={editableUserData.nombre}
                    onChange={(e) => setEditableUserData({ ...editableUserData, nombre: e.target.value })}
                    margin="normal"
                    variant="outlined"
                    sx={{ mb: 2 }}
                  />
                  <TextField
                    label="Email"
                    fullWidth
                    value={editableUserData.email}
                    onChange={(e) => setEditableUserData({ ...editableUserData, email: e.target.value })}
                    margin="normal"
                    variant="outlined"
                    sx={{ mb: 2 }}
                  />
                  <TextField
                    label="WhatsApp"
                    fullWidth
                    value={editableUserData.whatsapp}
                    onChange={(e) => setEditableUserData({ ...editableUserData, whatsapp: e.target.value })}
                    margin="normal"
                    variant="outlined"
                    sx={{ mb: 2 }}
                  />
                  <Button variant="contained" color="primary" onClick={handleSaveUserData} className="save-button">
                    Guardar
                  </Button>
                </>
              ) : (
                <>
                  <Typography>Nombre: {editableUserData.nombre}</Typography>
                  <Typography>Email: {editableUserData.email}</Typography>
                  <Typography>WhatsApp: {editableUserData.whatsapp}</Typography>
                  <Button variant="contained" color="primary" onClick={handleEditUserData} className="edit-button">
                    Editar Información
                  </Button>
                </>
              )}
            </Paper>
            <Box sx={{ borderBottom: 1, borderColor: 'var(--border-color)' }}>
              <Tabs value={value} onChange={handleChange} aria-label="Summary Tabs">
                {completedServices.map((service, index) => (
                  <Tab key={service.uniqueServiceId} label={service.serviceTitle} sx={{ fontFamily: 'Poppins, sans-serif' }} />
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
                        {Object.entries(phaseSelections).map(([option, selected]) => (
                          selected && option !== 'phaseTitle' ? <li key={option}>{option}</li> : null
                        ))}
                      </ul>
                    </Box>
                  ))}
                </Paper>
                <Box className="buttons">
                  <Button variant="contained" color="primary" onClick={() => onEditSelections(service.uniqueServiceId)} className="edit-button">
                    Editar último servicio
                  </Button>
                  <Button variant="contained" color="primary" onClick={onAddMoreServices} className="add-button">
                    Agregar Otro Servicio
                  </Button>
                </Box>
              </TabPanel>
            ))}
            <Paper className="form-paper">
              <Box display="flex" justifyContent="center" mb={2}>
                <Button variant="contained" color="primary" type="submit" className="submit-button">
                  Enviar Cotización
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
