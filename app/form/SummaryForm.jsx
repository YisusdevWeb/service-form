import React from 'react';
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

const SummaryForm = () => {

  const { register, handleSubmit, formState: { errors }, reset } = useForm();
  const { selections } = useStore();
  const [value, setValue] = React.useState(0);

  const handleChange = (event, newValue) => {
    setValue(newValue);
  };

  const onSubmit = (data) => {
    const finalData = {
      ...data,
      selections,
    };
    console.log(finalData); // Aquí puedes enviar los datos a un servidor o mostrar un mensaje de confirmación
    alert("Formulario enviado con éxito");
    reset(); // Resetear el formulario después de enviarlo
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
        </TabPanel>
      ))}
      <form onSubmit={handleSubmit(onSubmit)}>
        <Paper sx={{ p: 3, backgroundColor: '#e6e6e6', borderRadius: 2, mb: 2 }}>
          <TextField
            label="Nombre"
            fullWidth
            {...register('nombre', { required: 'Nombre es obligatorio', minLength: { value: 3, message: 'Nombre debe tener al menos 3 caracteres' } })}
            margin="normal"
            variant="outlined"
            error={!!errors.nombre}
            helperText={errors.nombre ? errors.nombre.message : ''}
          />
          <TextField
            label="Email"
            fullWidth
            {...register('email', {
              required: 'Email es obligatorio',
              pattern: {
                value: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
                message: 'Ingresa un email válido'
              }
            })}
            margin="normal"
            variant="outlined"
            error={!!errors.email}
            helperText={errors.email ? errors.email.message : ''}
          />
          <TextField
            label="WhatsApp"
            fullWidth
            {...register('whatsapp', {
              required: 'WhatsApp es obligatorio',
              pattern: {
                value: /^\d+$/,
                message: 'Ingresa un número de WhatsApp válido'
              }
            })}
            margin="normal"
            variant="outlined"
            error={!!errors.whatsapp}
            helperText={errors.whatsapp ? errors.whatsapp.message : ''}
          />
        </Paper>
        <Box display="flex" justifyContent="space-between"> 
  
  <Button variant="contained" color="primary" type="submit" sx={{ px: 4, py: 1.5 }}>Enviar</Button>
</Box>

      </form>
    </Box>
  );
};

export default SummaryForm;
