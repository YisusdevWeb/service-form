import { create } from 'zustand';

const useStore = create((set) => ({
  currentService: null,
  currentPhase: 0,
  selections: {},
  setCurrentService: (service) =>
    set(() => ({
      currentService: service,
      currentPhase: 0,
      selections: {},
    })),
  setCurrentPhase: (phase) =>
    set(() => ({
      currentPhase: phase,
    })),
  addSelection: (phase, selection) =>
    set((state) => ({
      selections: {
        ...state.selections,
        [phase]: selection,
      },
    })),
  resetService: () =>
    set(() => ({
      currentService: null,
      currentPhase: 0,
      selections: {},
    })),
}));

export default useStore;
