import React, { useEffect } from 'react';
import { Box, Typography, Paper, Checkbox, FormControlLabel, InputLabel, FormControl, FormHelperText } from '@mui/material';
import { useForm } from 'react-hook-form';
import Logo from '../components/Logo';
import BootstrapInput from '../components/BootstrapInput'; // Importa el componente BootstrapInput
import "../../assets/scss/styles.scss";

const UserForm = ({ onUserSubmit }) => {
  const { register, handleSubmit, formState: { errors } } = useForm();

  const apiBaseUrl = FSF_data.api_base_url.user_info;
  const termsUrl = FSF_data.terms_url;
  
  // Obtener textos personalizados o usar valores por defecto en inglés
  const texts = FSF_data.form_texts || {};
  const t = {
    formTitle: texts.form_title || 'QUOTE REQUEST',
    formSubtitle: texts.form_subtitle || 'Fill in the fields below to request your quote!',
    nameLabel: texts.name_label || 'Name and Last Name *',
    namePlaceholder: texts.name_placeholder || 'Your First and Last Name',
    nameErrorRequired: texts.name_error_required || 'Name is required',
    nameErrorMin: texts.name_error_min || 'Must be at least 3 characters',
    emailLabel: texts.email_label || 'Email *',
    emailPlaceholder: texts.email_placeholder || 'Your best email',
    emailErrorRequired: texts.email_error_required || 'Email is required',
    emailErrorInvalid: texts.email_error_invalid || 'Enter a valid email',
    whatsappLabel: texts.whatsapp_label || 'Your WhatsApp *',
    whatsappPlaceholder: texts.whatsapp_placeholder || 'Your WhatsApp',
    whatsappErrorRequired: texts.whatsapp_error_required || 'Your WhatsApp is required',
    whatsappErrorInvalid: texts.whatsapp_error_invalid || 'Enter a valid WhatsApp',
    privacyText: texts.privacy_text || 'I have read and accept',
    privacyLinkText: texts.privacy_link_text || 'the Privacy Policy',
    privacyError: texts.privacy_error || 'You must accept the privacy policy',
    submitButton: texts.submit_button || 'REQUEST QUOTE',
    errorMessage: texts.error_message || 'There was an error creating the entry.',
  };

  useEffect(() => {
    // Select div with ID 'FSF_frontend-seccion'
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
      alert(t.errorMessage);
    });
  };

  return (
    <Box sx={{ maxWidth: 600, mx: 'auto', p: 1, borderRadius: 2 }}>
      <Logo /> {/* Usando el componente Logo aquí */}
      <Typography variant="h5" gutterBottom sx={{ color: 'var(--heading-color)', fontWeight: 'bold', textAlign: 'center', fontSize: '2rem' }}>
        {t.formTitle}
      </Typography>
      <Typography variant="body1" align="center" sx={{ marginBottom: 3, fontWeight: 'bold', fontSize: '1rem', color: 'var(--font-color)' }}>
        {t.formSubtitle}
      </Typography>
      <form onSubmit={handleSubmit(onSubmit)}>
        <Paper sx={{ 
          p: 3, 
          background: 'rgb(30 90 142 / 0%)', 
          backdropFilter: 'blur(6px) saturate(81%)',
          WebkitBackdropFilter: 'blur(6px) saturate(81%)',
          border: '1px solid rgba(255, 255, 255, 0.15)',
          borderRadius: 2, 
          mb: 2, 
          boxShadow: '0 8px 32px 0 rgba(0, 0, 0, 0.3)',
          transition: 'transform 0.3s ease',
          '&:hover': {
            transform: 'translateY(-2px)'
          }
        }}>
          <FormControl fullWidth margin="dense" error={!!errors.nombre}>
            <InputLabel shrink htmlFor="nombre" sx={{ fontSize: '1.25rem', position: 'relative', marginBottom: '-9px', marginLeft: '-14px', color: '#ffffff !important' }}>
              {t.nameLabel}
            </InputLabel>
            <BootstrapInput
              id="nombre"
              placeholder={t.namePlaceholder}
              {...register('nombre', { required: t.nameErrorRequired, minLength: { value: 3, message: t.nameErrorMin } })}
            />
            <FormHelperText>{errors.nombre ? errors.nombre.message : ''}</FormHelperText>
          </FormControl>

          <FormControl fullWidth margin="dense" error={!!errors.email}>
            <InputLabel shrink htmlFor="email" sx={{ fontSize: '1.25rem', position: 'relative', marginBottom: '-9px', marginLeft: '-14px', color: '#ffffff !important' }}>
              {t.emailLabel}
            </InputLabel>
            <BootstrapInput
              id="email"
              placeholder={t.emailPlaceholder}
              {...register('email', {
                required: t.emailErrorRequired,
                pattern: {
                  value: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
                  message: t.emailErrorInvalid,
                }
              })}
            />
            <FormHelperText>{errors.email ? errors.email.message : ''}</FormHelperText>
          </FormControl>

          <FormControl fullWidth margin="dense" error={!!errors.whatsapp}>
            <InputLabel shrink htmlFor="whatsapp" sx={{ fontSize: '1.25rem', position: 'relative', marginBottom: '-9px', marginLeft: '-14px', color: '#ffffff !important' }}>
            {t.whatsappLabel}
            </InputLabel>
            <BootstrapInput
              id="whatsapp"
              placeholder={t.whatsappPlaceholder}
              {...register('whatsapp', {
                required: t.whatsappErrorRequired,
                pattern: {
                  value: /^\+?[0-9\s-]+$/,
                  message: t.whatsappErrorInvalid,
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
                {...register('privacyPolicy', { required: t.privacyError })}
                color="primary"
              />
            }
            label={
              <Typography sx={{ fontSize: '1rem' }} variant="body2" color={errors.privacyPolicy ? 'error' : 'textPrimary'}>
                {t.privacyText} <a href={termsUrl} target="_blank" rel="noopener noreferrer">{t.privacyLinkText}</a>
              </Typography>
            }
          />
          {errors.privacyPolicy && <Typography variant="body2" color="error">{errors.privacyPolicy.message}</Typography>}

          <Box display="flex" justifyContent="center" sx={{ mt: 2, mb: 2 }}>
            {/* Botón personalizado */}
            <button className="custom-button" type="submit">
              <span className="icon-btn"></span>
              <span className="title-btn" data-animate-text={t.submitButton}>
                {t.submitButton}
              </span>
            </button>
          </Box>
        </Paper>
      </form>
    </Box>
  );
};

export default UserForm;
