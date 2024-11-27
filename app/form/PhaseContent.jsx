import React from 'react';
import useStore from '../store/store.js';

const PhaseContent = () => {
  const { currentService } = useStore();

  if (!currentService) {
    return <div className="phase-content">Seleccione un servicio para ver los detalles.</div>;
  }

  return (
    <div className="phase-content">
      <h2>{currentService.titulo}</h2>
      <div>
        {currentService.fases_do_servico.length > 0 ? (
          <ul>
            {currentService.fases_do_servico.map((fase) => (
              <li key={fase.id_fase}>
                <h3>{fase.titulo}</h3>
                <p>{fase.descricao}</p>
                {fase.escrever_as_opcoes?.length > 0 && (
                  <ul>
                    {fase.escrever_as_opcoes.map((opcao) => (
                      <li key={opcao.id_opcion}>{opcao.titulo}</li>
                    ))}
                  </ul>
                )}
              </li>
            ))}
          </ul>
        ) : (
          <p>No hay fases disponibles para este servicio.</p>
        )}
      </div>
    </div>
  );
};

export default PhaseContent;
