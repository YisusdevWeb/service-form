const fetchData = async () => {
  try {
    const response = await fetch('http://localhost/dappin/wp-json/wp/v2/form-servico/');
    if (!response.ok) {
      throw new Error(`Error al obtener los datos: ${response.statusText}`);
    }
    const data = await response.json();
    return data;
  } catch (error) {
    console.error('Error en fetchData:', error);
    return [];
  }
};

export default fetchData;
