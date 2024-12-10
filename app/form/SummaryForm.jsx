import React, { useState, useEffect } from 'react';
import { Box, Typography, Paper, Tabs, Tab, Button, TextField } from '@mui/material';
import { useForm } from 'react-hook-form';
import useStore from '../store/store.js';

const TabPanel = ({ children, value, index, ...other }) => {
  return (
    <div
      role="tabpanel"
      hidden={value !== index}
      id={`tabpanel-${index}`}
      aria-labelledby={`tab-${index}`}
      {...other }
    >
      {value === index && <Box p={3}>{children}</Box>}
    </div>
  );
};

const SummaryForm = ({ onEditSelections, onAddMoreServices, onContinueQuote, userData }) => {
  const { register, handleSubmit, formState: { errors }, reset } = useForm();
  const { selections } = useStore();
  const [value, setValue] = useState(0);
  const [isEditing, setIsEditing] = useState(false);
  const [editableUserData, setEditableUserData] = useState(userData);

  const handleChange = (event, newValue) => {
    setValue(newValue);
  };

  const onSubmit = (data) => {
    const finalData = {
      ...data,
      selections,
    };
    console.log(finalData);
    alert("Formulario enviado con éxito");
    reset();
  };

  const handleEditUserData = () => {
    setIsEditing(true);
  };

  const handleSaveUserData = () => {
    // Aquí puedes agregar la lógica para guardar los datos editados
    setIsEditing(false);
  };

  const completedServices = Object.entries(selections).map(([uniqueServiceId, serviceSelections]) => {
    const serviceTitle = serviceSelections.serviceTitle || `Servicio ${uniqueServiceId}`;
    const phases = Object.keys(serviceSelections)
      .filter(phaseId => phaseId !== 'serviceTitle')
      .map(phaseId => {
        const phaseSelections = serviceSelections[phaseId];
        const phaseTitle = phaseSelections.phaseTitle;
        return {
          phaseId,
          phaseTitle,
          phaseSelections
        };
      });

    return { uniqueServiceId, serviceTitle, phases };
  });

  return (
    <Box sx={{ maxWidth: 800, mx: 'auto', p: 2 }}>
      <Typography variant="h5" gutterBottom sx={{ color: '#0f4c80', fontWeight: 'bold', textAlign: 'center' }}>
        Resumen de Selecciones
      </Typography>
      <Box sx={{ borderBottom: 1, borderColor: 'divider' }}>
        <Tabs value={value} onChange={handleChange} aria-label="Summary Tabs">
          {completedServices.map((service, index) => (
            <Tab key={service.uniqueServiceId} label={service.serviceTitle} />
          ))}
        </Tabs>
      </Box>
      {completedServices.map((service, index) => (
        <TabPanel key={service.uniqueServiceId} value={value} index={index}>
          <Paper sx={{ p: 3, mb: 3, backgroundColor: '#f5f5f5', borderRadius: 2 }}>
            <Typography variant="h6" sx={{ color: '#0f4c80', fontWeight: 'bold' }}>{service.serviceTitle}</Typography>
            {service.phases.map(({ phaseId, phaseTitle, phaseSelections }) => (
              <Box key={phaseId} mb={2}>
                <Typography variant="h6" sx={{ color: '#0f4c80', fontWeight: 'bold' }}>{phaseTitle}</Typography>
                <ul style={{ listStyleType: 'none', paddingLeft: 0 }}>
                  {Object.entries(phaseSelections).map(([option, selected]) => (
                    selected && option !== 'phaseTitle' ? <li key={option} style={{ color: '#333', marginBottom: '4px' }}>{option}</li> : null
                  ))}
                </ul>
              </Box>
            ))}
          </Paper>
        </TabPanel>
      ))}
      <form onSubmit={handleSubmit(onSubmit)}>
        <Paper sx={{ p: 3, backgroundColor: '#e6e6e6', borderRadius: 2, mb: 2 }}>
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
              />
              <TextField
                label="Email"
                fullWidth
                value={editableUserData.email}
                onChange={(e) => setEditableUserData({ ...editableUserData, email: e.target.value })}
                margin="normal"
                variant="outlined"
              />
              <TextField
                label="WhatsApp"
                fullWidth
                value={editableUserData.whatsapp}
                onChange={(e) => setEditableUserData({ ...editableUserData, whatsapp: e.target.value })}
                margin="normal"
                variant="outlined"
              />
              <Button variant="contained" color="primary" onClick={handleSaveUserData}>
                Guardar
              </Button>
            </>
          ) : (
            <>
              <Typography>Nombre: {editableUserData.nombre}</Typography>
              <Typography>Email: {editableUserData.email}</Typography>
              <Typography>WhatsApp: {editableUserData.whatsapp}</Typography>
              <Button variant="contained" color="primary" onClick={handleEditUserData}>
                Editar Información
              </Button>
            </>
          )}
        </Paper>
        <Box display="flex" justifyContent="space-between">
          <Button variant="contained" color="primary" onClick={onAddMoreServices}>Agregar Otro Servicio</Button>
          <Button variant="contained" color="primary" type="submit" sx={{ px: 4, py: 1.5 }}>Enviar</Button>
        </Box>
      </form>
    </Box>
  );
};

export default SummaryForm;
