import React from 'react';
import { Typography, Paper, Box } from '@mui/material';
import MultipleChoiceOption from './MultipleChoiceOption';
import SingleChoiceOption from './SingleChoiceOption';

const StepContent = ({ currentPhase, currentService, selections, handleSelection, getValues, watch }) => {
  const fase = currentService.fases_do_servico[currentPhase];
  const currentSelections = selections[currentPhase] || {};

  return (
    <Paper sx={{ padding: 3, backgroundColor: '#f4f4f4', borderRadius: 2, mb: 2, boxShadow: '0 2px 5px rgba(0,0,0,0.1)' }}>
      <Typography variant="h6" sx={{ color: '#0f4c80', fontWeight: 'bold' }}>{fase?.titulo || 'Sin título'}</Typography>
      <Typography variant="body1" gutterBottom sx={{ color: '#555', mb: 2 }}>{fase?.descricao || 'Sin descripción'}</Typography>
      {fase?.escrever_as_opcoes && (
        <Box display="flex" flexWrap="wrap" gap={2}>
          {fase.escrever_as_opcoes.map((opcao) => {
            const isSelected = !!watch(opcao.titulo);
            const handleClick = () => handleSelection(opcao.titulo, !getValues(opcao.titulo));
            return fase.tipo_selecao === 'multipla' ? (
              <MultipleChoiceOption key={opcao.id_opcion || opcao.titulo} option={opcao} isSelected={isSelected} handleSelection={handleClick} />
            ) : (
              <SingleChoiceOption key={opcao.id_opcion || opcao.titulo} option={opcao} isSelected={isSelected} handleSelection={handleClick} />
            );
          })}
        </Box>
      )}
    </Paper>
  );
};

export default StepContent;
