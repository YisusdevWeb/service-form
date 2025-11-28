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
  
  // Obtener textos personalizados o usar valores por defecto
  const texts = FSF_data.form_texts || {};
  
  // Opciones de campos obligatorios (por defecto: nombre y email obligatorios, whatsapp no)
  const required = {
    name: texts.name_required === '1' || texts.name_required === undefined,
    email: texts.email_required === '1' || texts.email_required === undefined,
    whatsapp: texts.whatsapp_required === '1',
    privacy: texts.privacy_required === '1' || texts.privacy_required === undefined,
  };
  
  const t = {
    formTitle: texts.form_title || 'PEDIDO DE PROPOSTA',
    formSubtitle: texts.form_subtitle || 'Preenche os campos abaixo para pedires a tua proposta!',
    nameLabel: (texts.name_label || 'Nome e Apelido') + (required.name ? ' *' : ''),
    namePlaceholder: texts.name_placeholder || 'O teu Primeiro e último nome',
    nameErrorRequired: texts.name_error_required || 'Nome é obrigatório',
    nameErrorMin: texts.name_error_min || 'Deve ter pelo menos 3 caracteres',
    emailLabel: (texts.email_label || 'E-mail') + (required.email ? ' *' : ''),
    emailPlaceholder: texts.email_placeholder || 'O teu melhor e-mail',
    emailErrorRequired: texts.email_error_required || 'Email é obrigatório',
    emailErrorInvalid: texts.email_error_invalid || 'Insere um email válido',
    whatsappLabel: (texts.whatsapp_label || 'O teu WhatsApp') + (required.whatsapp ? ' *' : ''),
    whatsappPlaceholder: texts.whatsapp_placeholder || 'O teu WhatsApp',
    whatsappErrorRequired: texts.whatsapp_error_required || 'Teu WhatsApp é obrigatório',
    whatsappErrorInvalid: texts.whatsapp_error_invalid || 'Insere teu WhatsApp válido',
    privacyText: texts.privacy_text || 'Li e aceito',
    privacyLinkText: texts.privacy_link_text || 'a Política de Privacidade',
    privacyError: texts.privacy_error || 'É necessário aceitar as políticas de privacidade',
    submitButton: texts.submit_button || 'SOLICITAR PROPOSTA',
    errorMessage: texts.error_message || 'Houve um erro ao criar a entrada.',
  };

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
              {...register('nombre', { 
                required: required.name ? t.nameErrorRequired : false, 
                minLength: { value: 3, message: t.nameErrorMin } 
              })}
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
                required: required.email ? t.emailErrorRequired : false,
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
                required: required.whatsapp ? t.whatsappErrorRequired : false,
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
                {...register('privacyPolicy', { required: required.privacy ? t.privacyError : false })}
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
