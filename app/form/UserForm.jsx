import React from 'react';
import { Box, Typography, Paper, TextField, Button } from '@mui/material';
import { useForm } from 'react-hook-form';

const UserForm = ({ onUserSubmit }) => {
  const { register, handleSubmit, formState: { errors } } = useForm();

  const onSubmit = (data) => {
    onUserSubmit(data);
  };

  return (
    <Box sx={{ maxWidth: 800, mx: 'auto', p: 2 }}>
      <Typography variant="h5" gutterBottom sx={{ color: '#0f4c80', fontWeight: 'bold', textAlign: 'center' }}>
        Información del Usuario
      </Typography>
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
        <Box display="flex" justifyContent="center">
          <Button variant="contained" color="primary" type="submit" sx={{ px: 4, py: 1.5 }}>Continuar con la cotización</Button>
        </Box>
      </form>
    </Box>
  );
};

export default UserForm;
