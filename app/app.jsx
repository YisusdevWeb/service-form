import React, { useEffect, useState } from 'react';
import FormLayout from './form/FormLayout';
import useStore from './store';
import fetchData from './utils/fetchData';

const App = () => {
  const [servicos, setServicos] = useState([]);
  const { setCurrentService } = useStore(); // Acceso a Zustand para actualizar el servicio

  useEffect(() => {
    const getData = async () => {
      const data = await fetchData();
      setServicos(data);

      // Establecer el primer servicio por defecto si está disponible
      if (data.length > 0) {
        setCurrentService(data[0]);
      }
    };

    getData();
  }, [setCurrentService]);

  return (
    <div>
      {servicos.length > 0 ? (
        <FormLayout servicos={servicos} />
      ) : (
        <p>Cargando servicios...</p>
      )}
    </div>
  );
};

export default App;
