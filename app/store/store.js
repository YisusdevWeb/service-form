import { create } from 'zustand';

const useStore = create((set) => ({
  currentService: JSON.parse(localStorage.getItem('currentService')) || null,
  currentPhase: JSON.parse(localStorage.getItem('currentPhase')) || 0,
  selections: JSON.parse(localStorage.getItem('selections')) || {},

  setCurrentService: (service) => {
    const uniqueServiceId = `${service.id}_${Date.now()}`;
    localStorage.setItem('currentService', JSON.stringify({ ...service, uniqueId: uniqueServiceId }));
    localStorage.setItem('currentPhase', JSON.stringify(0));
    set(() => ({
      currentService: { ...service, uniqueId: uniqueServiceId },
      currentPhase: 0,
    }));
  },

  setCurrentPhase: (phase) => {
    localStorage.setItem('currentPhase', JSON.stringify(phase));
    set(() => ({
      currentPhase: phase,
    }));
  },

  addSelection: (uniqueServiceId, phase, selection) => {
    set((state) => {
      const currentService = state.currentService;
      const phaseId = `f_${phase}`;
      const phaseTitle = currentService?.fases_do_servico?.find(f => f.id_fase === phaseId)?.titulo || `Fase ${parseInt(phase) + 1}`;
      const newSelections = {
        ...state.selections,
        [uniqueServiceId]: {
          ...state.selections[uniqueServiceId],
          [phase]: { ...selection, phaseTitle },
          serviceTitle: currentService.titulo,
        },
      };
      localStorage.setItem('selections', JSON.stringify(newSelections));
      return { selections: newSelections };
    });
  },

  resetService: () => {
    localStorage.removeItem('currentService');
    localStorage.removeItem('currentPhase');
    set(() => ({
      currentService: null,
      currentPhase: 0,
    }));
  },

  setSelections: (selections) => {
    set({ selections });
  },
}));

export default useStore;
