import React, { useEffect } from 'react';
import { Box, Typography, Paper, Checkbox, FormControlLabel, InputLabel, FormControl, FormHelperText } from '@mui/material';
import { useForm } from 'react-hook-form';
import Logo from '../components/Logo';
import BootstrapInput from '../components/BootstrapInput'; // Importa el componente BootstrapInput
import "../../assets/scss/styles.scss";

const UserForm = ({ onUserSubmit }) => {
  const { register, handleSubmit, formState: { errors } } = useForm();

  const apiBaseUrl = FSF_data.api_base_url.user_info;
  const termsUrl = FSF_data.terms_url; // Obtener la URL de los términos y condiciones

  useEffect(() => {
    // Seleccionar el div con el ID 'FSF_frontend-seccion'
    const sectionElement = document.getElementById('FSF_frontend-seccion');

    if (sectionElement) {
      // Agregar clase cuando el componente esté montado
      sectionElement.classList.add('FSF_frontend-section-background');
      // Limpiar: eliminar clase al desmontar el componente
      return () => {
        sectionElement.classList.remove('FSF_frontend-section-background');
      };
    }
  }, []);

  const onSubmit = (data) => {
    if (data.website) return;
    fetch(`${apiBaseUrl}`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-WP-Nonce': FSF_data.nonce || ''
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
    <Box sx={{ maxWidth: 600, mx: 'auto', p: 1, backgroundColor: '#f9f9f9', borderRadius: 2 }}>
      <Logo /> {/* Usando el componente Logo aquí */}
      <Typography variant="h5" gutterBottom sx={{ color: '#0f4c80', fontWeight: 'bold', textAlign: 'center', fontSize: '2rem' }}>
        PEDIDO DE PROPOSTA
      </Typography>
      <Typography variant="body1" align="center" sx={{ marginBottom: 3, fontWeight: 'bold', fontSize: '1rem' }}>
        Preenche os campos abaixo para pedires a tua proposta!
      </Typography>
      <form onSubmit={handleSubmit(onSubmit)}>
        <Paper sx={{ p: 3, backgroundColor: '#ffffff', borderRadius: 2, mb: 2, boxShadow: 1 }}>
          <FormControl fullWidth margin="dense" error={!!errors.nombre}>
            <InputLabel shrink htmlFor="nombre" sx={{ fontSize: '1.25rem', position: 'relative', marginBottom: '-9px', marginLeft: '-14px' }}>
              Nome e Apelido *
            </InputLabel>
            <BootstrapInput
              id="nombre"
              placeholder="O teu Primeiro e último nome"
              {...register('nombre', { required: 'Nome é obrigatório', minLength: { value: 3, message: 'Deve ter pelo menos 3 caracteres' } })}
            />
            <FormHelperText>{errors.nombre ? errors.nombre.message : ''}</FormHelperText>
          </FormControl>

          <FormControl fullWidth margin="dense" error={!!errors.email}>
            <InputLabel shrink htmlFor="email" sx={{ fontSize: '1.25rem', position: 'relative', marginBottom: '-9px', marginLeft: '-14px' }}>
              E-mail *
            </InputLabel>
            <BootstrapInput
              id="email"
              placeholder="O teu melhor e-mail"
              {...register('email', {
                required: 'Email é obrigatório',
                pattern: {
                  value: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
                  message: 'Insere um email válido',
                }
              })}
            />
            <FormHelperText>{errors.email ? errors.email.message : ''}</FormHelperText>
          </FormControl>

          <FormControl fullWidth margin="dense" error={!!errors.whatsapp}>
            <InputLabel shrink htmlFor="whatsapp" sx={{ fontSize: '1.25rem', position: 'relative', marginBottom: '-9px', marginLeft: '-14px' }}>
            O teu WhatsApp*
            </InputLabel>
            <BootstrapInput
              id="whatsapp"
              placeholder="O teu WhatsApp"
              {...register('whatsapp', {
                required: 'teu WhatsApp é obrigatório',
                pattern: {
                  value: /^\+?[0-9\s-]+$/,
                  message: 'Insere teu WhatsApp válido',
                }
              })}
            />
            <FormHelperText>{errors.whatsapp ? errors.whatsapp.message : ''}</FormHelperText>
          </FormControl>

          {/* Honeypot field */}
          <InputLabel shrink htmlFor="website" sx={{ fontSize: '1.25rem', display: 'none' }}>
            Website
          </InputLabel>
          <BootstrapInput
            id="website"
            fullWidth
            {...register('website')}
            style={{ display: 'none' }}
          />

          {/* Checkbox de políticas de privacidad */}
          <FormControlLabel
            control={
              <Checkbox
                {...register('privacyPolicy', { required: 'É necessário aceitar as políticas de privacidade' })}
                color="primary"
              />
            }
            label={
              <Typography sx={{ fontSize: '1rem' }} variant="body2" color={errors.privacyPolicy ? 'error' : 'textPrimary'}>
                Li e aceito <a href={termsUrl} target="_blank" rel="noopener noreferrer">a Política de Privacidade</a>
              </Typography>
            }
          />
          {errors.privacyPolicy && <Typography variant="body2" color="error">{errors.privacyPolicy.message}</Typography>}

          <Box display="flex" justifyContent="center" sx={{ mt: 2, mb: 2 }}>
            {/* Botón personalizado */}
            <button className="custom-button" type="submit">
              <span className="icon-btn"></span>
              <span className="title-btn" data-animate-text="SOLICITAR PROPOSTA">
                SOLICITAR PROPOSTA
              </span>
            </button>
          </Box>
        </Paper>
      </form>
    </Box>
  );
};

export default UserForm;
