import React from 'react';
import { Box, Typography, Paper, TextField, Button } from '@mui/material';
import { useForm } from 'react-hook-form';

const UserForm = ({ onUserSubmit }) => {
  const { register, handleSubmit, formState: { errors } } = useForm();

  const apiBaseUrl = FSF_data.api_base_url.user_info;

  const onSubmit = (data) => {
    // Verificar que el campo honeypot esté vacío
    if (data.website) {
     // console.error("Bot detected!");
     // alert("Bot detected!");
      return;
    }

    fetch(`${apiBaseUrl}`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(data),
    })
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then(responseData => {
    //  console.log('Success:', responseData);
     // alert('Entrada creada con éxito.');
      if (onUserSubmit) {
        onUserSubmit({ ...data, post_id: responseData.post_id }); // Pasar los datos del usuario al siguiente formulario
      }
    })
    .catch((error) => {
      console.error('Error:', error);
      alert('Hubo un error al crear la entrada.');
    });
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
          {/* Campo Honeypot */}
          <TextField
            label="Website"
            fullWidth
            {...register('website')}
            margin="normal"
            variant="outlined"
            style={{ display: 'none' }}  // Campo oculto
          />
        </Paper>
        <Box display="flex" justifyContent="center" mb={2}>
          <Button variant="contained" color="primary" type="submit" sx={{ px: 4, py: 1.5 }}>Continuar con la cotización</Button>
        </Box>
      </form>
    </Box>
  );
};

export default UserForm;
