import React from 'react';
import { Box, Button, TextField, Typography, Paper } from '@mui/material';
import { useForm } from 'react-hook-form';
import useStore from '../store/store.js';

const SummaryForm = () => {
  const { register, handleSubmit, formState: { errors }, reset } = useForm();
  const { selections, currentService } = useStore();

  const onSubmit = (data) => {
    const finalData = {
      ...data,
      selections,
    };
    console.log(finalData); // Aquí puedes enviar los datos a un servidor o mostrar un mensaje de confirmación
    alert("Formulario enviado con éxito");
    reset(); // Resetear el formulario después de enviarlo
  };

  return (
    <Box sx={{ maxWidth: 800, mx: 'auto', p: 2 }}>
      <Typography variant="h5" gutterBottom sx={{ color: '#0f4c80', fontWeight: 'bold', textAlign: 'center' }}>Resumen de Selecciones</Typography>
      <Paper sx={{ p: 3, mb: 3, backgroundColor: '#f5f5f5', borderRadius: 2 }}>
        {currentService.fases_do_servico.map((fase, index) => (
          <Box key={index} mb={2}>
            <Typography variant="h6" sx={{ color: '#0f4c80', fontWeight: 'bold' }}>{fase.titulo}</Typography>
            <ul style={{ listStyleType: 'none', paddingLeft: 0 }}>
              {Object.entries(selections[index] || {}).map(([option, selected]) => (
                selected ? <li key={option} style={{ color: '#333', marginBottom: '4px' }}>{option}</li> : null
              ))}
            </ul>
          </Box>
        ))}
      </Paper>
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
        <Box mt={4} display="flex" justifyContent="flex-end">
          <Button variant="contained" color="primary" type="submit" sx={{ px: 4, py: 1.5 }}>Enviar</Button>
        </Box>
      </form>
    </Box>
  );
};

export default SummaryForm;
