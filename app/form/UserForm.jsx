import React from 'react';
import { Box, Typography, Paper, TextField, Button, MenuItem } from '@mui/material';
import { useForm } from 'react-hook-form';

const UserForm = ({ onUserSubmit }) => {
  const { register, handleSubmit, formState: { errors } } = useForm();

  const apiBaseUrl = FSF_data.api_base_url.user_info;

  const onSubmit = (data) => {
    if (data.website) return;

    fetch(`${apiBaseUrl}`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(data),
    })
    .then(response => {
      if (!response.ok) throw new Error('Network response was not ok');
      return response.json();
    })
    .then(responseData => {
      if (onUserSubmit) {
        onUserSubmit({ ...data, post_id: responseData.post_id });
      }
    })
    .catch((error) => {
      console.error('Erro:', error);
      alert('Houve um erro ao criar a entrada.');
    });
  };

  return (
    <Box sx={{ maxWidth: 500, mx: 'auto', p: 2, backgroundColor: '#f9f9f9', borderRadius: 2 }}>
      <Typography variant="h6" gutterBottom sx={{ color: '#0f4c80', fontWeight: 'bold', textAlign: 'center' }}>
        <Box
          component="img"
          sx={{
            width: "50%",
            height: "auto",
            mx: 'auto',
            display: 'block',
            marginBottom: '16px',
          }}
          alt="Dappin Logo"
          src="https://dappin.pt/wp-content/uploads/2024/01/dappin_logo-768x177.png"
        />
        PEDIDO DE PROPOSTA
      </Typography>
      <Typography variant="body1" align="center" sx={{ marginBottom: 3 }}>
        Preenche os campos abaixo para pedires a tua proposta!
      </Typography>
      <form onSubmit={handleSubmit(onSubmit)}>
        <Paper sx={{ p: 3, backgroundColor: '#ffffff', borderRadius: 2, mb: 2, boxShadow: 1 }}>
          <TextField
            label="O teu nome *"
            placeholder="O teu primeiro e último nome"
            fullWidth
            {...register('nombre', { required: 'Nome é obrigatório', minLength: { value: 3, message: 'Nome deve ter pelo menos 3 caracteres' } })}
            margin="normal"
            variant="outlined"
            error={!!errors.nombre}
            helperText={errors.nombre ? errors.nombre.message : ''}
          />
          <TextField
            label="O teu melhor e-mail *"
            placeholder="O teu email empresarial"
            fullWidth
            {...register('email', {
              required: 'Email é obrigatório',
              pattern: {
                value: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
                message: 'Insere um email válido',
              }
            })}
            margin="normal"
            variant="outlined"
            error={!!errors.email}
            helperText={errors.email ? errors.email.message : ''}
          />
          <TextField
            label="O teu Telefone *"
            placeholder="O teu Telefone"
            fullWidth
            {...register('whatsapp', {
              required: 'Telefone é obrigatório',
              pattern: {
                value: /^\+?[0-9\s-]+$/,
                message: 'Insere um número de Telefone válido',
              }
            })}
            margin="normal"
            variant="outlined"
            error={!!errors.whatsapp}
            helperText={errors.whatsapp ? errors.whatsapp.message : ''}
          />
          
          {/* Honeypot field */}
          <TextField
            label="Website"
            fullWidth
            {...register('website')}
            margin="normal"
            variant="outlined"
            style={{ display: 'none' }}
          />
        </Paper>
        <Box display="flex" justifyContent="center">
           {/* Botón personalizado */}
           <button className="dsn-btn" type="submit">
           
            <span className="title-btn" data-animate-text="SOLICITAR PROPOSTA">
              SOLICITAR PROPOSTA
            </span>
          </button>
        </Box>
      </form>
    </Box>
  );
};

export default UserForm;
