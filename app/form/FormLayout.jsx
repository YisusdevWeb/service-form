import React from 'react';
import PhaseSidebar from './PhaseSidebar';
import PhaseContent from './PhaseContent';

const FormLayout = ({ servicos }) => {
  return (
    <div className="form-layout">
      {/* Menú lateral dinámico */}
      <PhaseSidebar servicos={servicos} />

      {/* Contenido dinámico */}
      <PhaseContent />
    </div>
  );
};

export default FormLayout;
