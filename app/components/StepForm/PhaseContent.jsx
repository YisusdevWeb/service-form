import React from 'react';
import { Box, Button, Paper, Typography } from '@mui/material';
import '../../../assets/scss/styles.scss'; 
import DOMPurify from 'dompurify';



const PhaseContent = ({ fase, handleSelection, watch, getValues }) => {
  const sanitizedDescription = DOMPurify.sanitize(fase?.descricao || 'Sem descrição');

  return (
    <Paper sx={{ 
      padding: { xs: 2, md: '50px' }, // Padding similar to services list
      fontFamily: 'Poppins, sans-serif', 
      background: 'rgba(255, 255, 255, 0.05)', 
      backdropFilter: 'blur(15px) saturate(180%)',
      WebkitBackdropFilter: 'blur(15px) saturate(180%)',
      border: '1px solid rgba(255, 255, 255, 0.15)',
      borderRadius: 2, 
      mb: 2, 
      boxShadow: '0 4px 16px 0 rgba(0, 0, 0, 0.3)',
      transition: 'transform 0.3s ease, box-shadow 0.3s ease',
      '&:hover': {
        transform: 'translateY(-2px)',
        boxShadow: '0 6px 20px 0 rgba(0, 0, 0, 0.4)'
      }
    }}>
      <Typography variant="h6" sx={{ fontWeight: 'bold', fontFamily: 'Poppins, sans-serif', color: 'var(--heading-color)', fontWeight: 'bold', padding: '0 0 15px 0' }}>
        {fase?.titulo || 'Sem título'}
      </Typography>
      <Typography
  variant="body1"
  gutterBottom
  sx={{ fontFamily: 'Poppins, sans-serif', color: 'var(--font-color)', mb: 2.5 }}
  dangerouslySetInnerHTML={{ __html: sanitizedDescription }}
/>
      {fase?.escrever_as_opcoes && (
  <Box display="flex" flexDirection="column" gap={2}>
    {fase.escrever_as_opcoes.map((opcao) => (
      <Button
        key={opcao.id_opcion || opcao.titulo}
        variant={watch(opcao.titulo) ? 'contained' : 'outlined'}
        onClick={() => handleSelection(opcao.titulo, !getValues(opcao.titulo))}
        sx={{
          background: watch(opcao.titulo) 
            ? 'linear-gradient(135deg, var(--theme-color), var(--theme-color-light))' 
            : 'rgba(255, 255, 255, 0.05)',
          backdropFilter: watch(opcao.titulo) ? 'none' : 'blur(10px)',
          WebkitBackdropFilter: watch(opcao.titulo) ? 'none' : 'blur(10px)',
          color: watch(opcao.titulo) ? 'white' : 'rgba(255, 255, 255, 0.9)',
          fontFamily: 'Poppins, sans-serif',
          fontSize:'1rem' ,
          borderColor: watch(opcao.titulo) ? 'var(--theme-color)' : 'rgba(255, 255, 255, 0.2)',
          borderWidth: '1px',
          borderRadius: '4px',
          textTransform: 'none',
          width: '100%',
          whiteSpace: 'normal', // Permite que el texto se quiebre
          overflow: 'hidden',
          textOverflow: 'ellipsis',
          '&:hover': {
            background: watch(opcao.titulo) 
              ? 'linear-gradient(135deg, var(--theme-color-darken), var(--theme-color))' 
              : 'rgba(255, 255, 255, 0.1)',
            transform: 'translateY(-2px)',
            boxShadow: '0 4px 12px rgba(15, 76, 128, 0.3)'
          },
          '@media (max-width: 600px)': {
            width: '100%',
          },
        }}
      >
        {opcao.titulo}
      </Button>
    ))}
  </Box>
)}



    
    </Paper>
  );
};

export default PhaseContent;
