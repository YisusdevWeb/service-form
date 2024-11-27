import { create } from 'zustand';

const useStore = create((set) => ({
  currentService: null, // El servicio actualmente seleccionado
  currentPhase: 0, // La fase actual del servicio
  setCurrentService: (service) => set({ currentService: service, currentPhase: 0 }), // Función para establecer el servicio y reiniciar la fase
  nextPhase: () => set((state) => ({ currentPhase: state.currentPhase + 1 })), // Avanzar a la siguiente fase
  prevPhase: () => set((state) => ({ currentPhase: state.currentPhase - 1 })), // Volver a la fase anterior
}));

export default useStore;
