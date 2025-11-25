import { debounce } from '../utils/debounce';

export const handleSelectionFactory = (currentPhase, selections, addSelection, currentService, setCurrentPhase, setSnackbarMessage, setSnackbarSeverity, setSnackbarOpen, onAutoAdvance) => {
  return debounce((option, value) => {
    // Identify current service by uniqueId and read selections only from that service
    const uniqueId = currentService?.uniqueId;
    const currentSelections = uniqueId ? (selections?.[uniqueId]?.[currentPhase] || {}) : (selections[currentPhase] || {});

    // Guardar la selección para la fase actual del servicio
    addSelection(currentPhase, { ...currentSelections, [option]: value });

    if (value) {
      setSnackbarMessage(`Selecionado: ${option}`);
      setSnackbarSeverity('success');

      // Avanzar de fase sólo si no estamos ya en la última fase
      const totalPhases = currentService?.fases_do_servico?.length || 0;
      if (typeof currentPhase === 'number' && currentPhase < totalPhases - 1) {
        // Si la fase es de selección única, avanzamos automáticamente
        if (currentService.fases_do_servico[currentPhase]?.tipo_selecao === 'unica') {
          const next = currentPhase + 1;
          if (typeof onAutoAdvance === 'function') {
            onAutoAdvance(next);
          } else {
            setCurrentPhase(next);
          }
        }
      }
    } else {
      setSnackbarMessage(`Desmarcado: ${option}`);
      setSnackbarSeverity('warning');
    }

    setSnackbarOpen(true);
  }, 300);
};
