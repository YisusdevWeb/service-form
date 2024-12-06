import React from 'react';
import { Box, Button, Paper, Typography } from '@mui/material';
import { useFormContext } from 'react-hook-form';

const PhaseContent = ({ fase, handleSelection, watch, getValues }) => {
  return (
    <Paper sx={{ padding: 3, backgroundColor: '#f4f4f4', borderRadius: 2, mb: 2, boxShadow: '0 2px 5px rgba(0,0,0,0.1)' }}>
      <Typography variant="h6" sx={{ color: '#0f4c80', fontWeight: 'bold' }}>{fase?.titulo || 'Sin título'}</Typography>
      <Typography variant="body1" gutterBottom sx={{ color: '#555', mb: 2 }}>{fase?.descricao || 'Sin descripción'}</Typography>
      {fase?.escrever_as_opcoes && (
        <Box display="flex" flexWrap="wrap" gap={2}>
          {fase.escrever_as_opcoes.map((opcao) => (
            <Button
              key={opcao.id_opcion || opcao.titulo}
              variant={watch(opcao.titulo) ? 'contained' : 'outlined'}
              onClick={() => handleSelection(opcao.titulo, !getValues(opcao.titulo))}
              sx={{
                flex: '1 1 calc(50% - 16px)',
                minWidth: '120px',
                textTransform: 'none',
                '@media (max-width: 600px)': {
                  flex: '1 1 100%',
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
