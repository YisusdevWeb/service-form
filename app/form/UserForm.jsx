import React from 'react';
import { Box, Typography, Paper, TextField, Button } from '@mui/material';
import { useForm } from 'react-hook-form';

const UserForm = ({ onUserSubmit }) => {
  const { register, handleSubmit, formState: { errors } } = useForm();

  const apiBaseUrl = FSF_data.api_base_url.user_info;

  const onSubmit = (data) => {
    // Verificar que o campo honeypot esteja vazio
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
     // alert('Entrada criada com sucesso.');
      if (onUserSubmit) {
        onUserSubmit({ ...data, post_id: responseData.post_id }); // Passar os dados do utilizador para o próximo formulário
      }
    })
    .catch((error) => {
      console.error('Erro:', error);
      alert('Houve um erro ao criar a entrada.');
    });
  };

  return (
    <Box sx={{ maxWidth: 800, mx: 'auto', p: 2 }}>
      <Typography variant="h5" gutterBottom sx={{ color: '#0f4c80', fontWeight: 'bold', textAlign: 'center' }}>
        Informações do Utilizador
      </Typography>
      <form onSubmit={handleSubmit(onSubmit)}>
        <Paper sx={{ p: 3, backgroundColor: '#e6e6e6', borderRadius: 2, mb: 2 }}>
          <TextField
            label="Nome"
            fullWidth
            {...register('nombre', { required: 'Nome é obrigatório', minLength: { value: 3, message: 'Nome deve ter pelo menos 3 caracteres' } })}
            margin="normal"
            variant="outlined"
            error={!!errors.nombre}
            helperText={errors.nombre ? errors.nombre.message : ''}
          />
          <TextField
            label="Email"
            fullWidth
            {...register('email', {
              required: 'Email é obrigatório',
              pattern: {
                value: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
                message: 'Insere um email válido'
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
              required: 'WhatsApp é obrigatório',
              pattern: {
                value: /^\d+$/,
                message: 'Insere um número de WhatsApp válido'
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
          <Button variant="contained" color="primary" type="submit" sx={{ px: 4, py: 1.5 }}>Continuar com a cotação</Button>
        </Box>
      </form>
    </Box>
  );
};

export default UserForm;
