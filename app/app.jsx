import React, { useEffect } from 'react';
import { Box, Button, Checkbox, Typography, Stepper, Step, StepLabel, FormControlLabel, Radio, RadioGroup, Paper } from '@mui/material';
import { styled } from '@mui/system';
import { useForm } from 'react-hook-form';
import useStore from './store/store.js';

const CustomButton = styled(Button)({
  marginBottom: '10px',
  '&.MuiButton-containedPrimary': {
    backgroundColor: '#1976d2',
  },
});

const App = () => {
  const { register, handleSubmit, watch, formState: { errors } } = useForm();
  const onSubmit = data => console.log(data);

  const servicios = FSF_data.servicios || [];

  const servicos = servicios.map((servicio) => ({
    id: servicio.ID,
    titulo: servicio.title,
    fases_do_servico: servicio.acf ? servicio.acf.fases_do_servico : [],
  }));

  const { currentService, setCurrentService, currentPhase, nextPhase, prevPhase } = useStore();

  useEffect(() => {
    if (servicos.length > 0 && !currentService) {
      setCurrentService(servicos[0]);
    }
  }, [servicos, currentService, setCurrentService]);

  return (
    <Box p={5}>
      <Box display="flex" gap={3}>
        <Box flex={1}>
          <Paper elevation={3}>
            <Box p={2}>
              <Typography variant="h5" gutterBottom>Servicios</Typography>
              <ul>
                {servicos.map((servico) => (
                  <li key={servico.id} onClick={() => setCurrentService(servico)} style={{ cursor: 'pointer', marginBottom: '10px' }}>
                    <Typography variant="h6" color="primary">{servico.titulo}</Typography>
                  </li>
                ))}
              </ul>
            </Box>
          </Paper>
        </Box>
        <Box flex={2}>
          <Paper elevation={3}>
            <Box p={2}>
              {currentService ? (
                <>
                  <Typography variant="h4" gutterBottom>{currentService.titulo}</Typography>
                  <form onSubmit={handleSubmit(onSubmit)}>
                    {currentService.fases_do_servico && currentService.fases_do_servico.length > 0 ? (
                      <>
                        <Stepper activeStep={currentPhase}>
                          {currentService.fases_do_servico.map((fase, index) => (
                            <Step key={fase.id_fase || index}>
                              <StepLabel>{fase.titulo}</StepLabel>
                            </Step>
                          ))}
                        </Stepper>
                        <Box mt={3}>
                          <Typography variant="h6">{currentService.fases_do_servico[currentPhase].titulo}</Typography>
                          <Typography variant="body1" gutterBottom>{currentService.fases_do_servico[currentPhase].descricao}</Typography>
                          {currentService.fases_do_servico[currentPhase].escrever_as_opcoes && (
                            <Box>
                              {currentService.fases_do_servico[currentPhase].tipo_selecao === 'multipla' ? (
                                // Selección Múltiple (Checkboxes)
                                currentService.fases_do_servico[currentPhase].escrever_as_opcoes.map((opcao) => (
                                  <Box key={opcao.id_opcion} display="flex" alignItems="center" mb={1}>
                                    <FormControlLabel
                                      control={<Checkbox {...register(opcao.titulo)} />}
                                      label={
                                        <Box
                                          component="span"
                                          sx={{ 
                                            display: 'flex', 
                                            alignItems: 'center', 
                                            bgcolor: 'primary.light', 
                                            p: 1, 
                                            borderRadius: 1 
                                          }}
                                        >
                                          {opcao.titulo}
                                        </Box>
                                      }
                                    />
                                  </Box>
                                ))
                              ) : (
                                // Selección Única (Botones)
                                <RadioGroup>
                                  {currentService.fases_do_servico[currentPhase].escrever_as_opcoes.map((opcao) => (
                                    <CustomButton
                                      key={opcao.id_opcion}
                                      value={opcao.titulo}
                                      variant="contained"
                                      color="primary"
                                      onClick={nextPhase}
                                    >
                                      {opcao.titulo}
                                    </CustomButton>
                                  ))}
                                </RadioGroup>
                              )}
                            </Box>
                          )}
                        </Box>
                        <Box mt={4} display="flex" justifyContent="space-between">
                          {currentPhase > 0 && (
                            <Button variant="contained" color="primary" onClick={prevPhase}>Anterior</Button>
                          )}
                          {currentPhase < currentService.fases_do_servico.length - 1 ? (
                            <Button variant="contained" color="primary" onClick={nextPhase}>Siguiente</Button>
                          ) : (
                            <Button variant="contained" color="primary" type="submit">Enviar</Button>
                          )}
                        </Box>
                      </>
                    ) : (
                      <Typography>No hay fases disponibles para este servicio.</Typography>
                    )}
                  </form>
                </>
              ) : (
                <Typography>Seleccione un servicio para ver los detalles.</Typography>
              )}
            </Box>
          </Paper>
        </Box>
      </Box>
    </Box>
  );
};

export default App;
