import { debounce } from '../utils/debounce';

export const handleSelectionFactory = (currentPhase, selections, addSelection, currentService, setCurrentPhase, setSnackbarMessage, setSnackbarSeverity, setSnackbarOpen) => {
  return debounce((option, value) => {
    const currentSelections = selections[currentPhase] || {};
    addSelection(currentPhase, { ...currentSelections, [option]: value });
    if (value) {
      setSnackbarMessage(`Seleccionado: ${option}`);
      setSnackbarSeverity('success');
      if (currentService.fases_do_servico[currentPhase].tipo_selecao === 'unica') {
        setCurrentPhase(currentPhase + 1);
      }
    } else {
      setSnackbarMessage(`Deseleccionado: ${option}`);
      setSnackbarSeverity('warning');
    }
    setSnackbarOpen(true);
  }, 300);
};
