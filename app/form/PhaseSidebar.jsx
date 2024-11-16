import React from 'react';
import useStore from '../store';

const PhaseSidebar = ({ servicos }) => {
  const { setCurrentService } = useStore();

  const handleServiceClick = (servico) => {
    setCurrentService(servico);
  };

  return (
    <aside className="phase-sidebar">
      <ul>
        {servicos.map((servico) => (
          <li key={servico.id}>
            <button
              type="button"
              onClick={() => handleServiceClick(servico)}
              className="service-link"
            >
              {servico.title.rendered}
            </button>
          </li>
        ))}
      </ul>
    </aside>
  );
};

export default PhaseSidebar;
