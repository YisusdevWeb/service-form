import React from 'react';
import { Box, Typography, Paper, Tabs, Tab, Button } from '@mui/material';
import useStore from '../store/store.js';

const TabPanel = ({ children, value, index, ...other }) => {
  return (
    <div
      role="tabpanel"
      hidden={value !== index}
      id={`tabpanel-${index}`}
      aria-labelledby={`tab-${index}`}
      {...other}
    >
      {value === index && (
        <Box p={3}>
          {children}
        </Box>
      )}
    </div>
  );
};

const SummaryForm = ({ onEditSelections, onAddMoreServices, onContinueQuote }) => {
  const { selections } = useStore();
  const [value, setValue] = React.useState(0);

  const handleChange = (event, newValue) => {
    setValue(newValue);
  };

  // Obtenemos los servicios completados y organizamos las fases correctamente
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
      <Typography variant="h5" gutterBottom sx={{ color: '#0f4c80', fontWeight: 'bold', textAlign: 'center' }}>Resumen de Selecciones</Typography>
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
          <Box display="flex" justifyContent="space-between">
            <Button variant="contained" color="primary" onClick={() => onEditSelections(service.uniqueServiceId)}>Editar Selecciones</Button>
            <Button variant="contained" color="primary" onClick={onContinueQuote}>Continuar Cotización</Button>
            <Button variant="contained" color="primary" onClick={onAddMoreServices}>Agregar Otro Servicio</Button>
          </Box>
        </TabPanel>
      ))}
    </Box>
  );
};

export default SummaryForm;
