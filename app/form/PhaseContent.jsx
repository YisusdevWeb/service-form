import React from 'react';
import useStore from '../store';

const PhaseContent = () => {
  const { currentService } = useStore();

  if (!currentService) {
    return <p>Selecciona un servicio para ver más información.</p>;
  }

  return (
    <div className="phase-content">
      <h2>{currentService.title.rendered}</h2>
      {currentService.acf.fases_do_servico.map((fase) => (
        fase.escrever_as_opcoes ? (
          <div key={fase.id} className="fase">
            <h3>{fase.titulo}</h3>
            <p>{fase.descricao}</p>
            <ul>
              {fase.escrever_as_opcoes.map((opcao) => (
                <li key={opcao.id_opcion}>{opcao.titulo}</li>
              ))}
            </ul>
          </div>
        ) : null
      ))}
    </div>
  );
};

export default PhaseContent;
