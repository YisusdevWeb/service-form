import { create } from 'zustand';

const useStore = create((set) => ({
  currentService: null, // Servicio actual
  setCurrentService: (service) => set({ currentService: service }),
}));

export default useStore;
