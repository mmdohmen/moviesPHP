// Función para limpiar la búsqueda
function clearSearch() {
    document.getElementById('searchForm').reset();
    document.getElementById('resultados').style.display = 'none';
    document.getElementById('clearButton').style.display = 'none';
    window.history.pushState({}, document.title, window.location.pathname);
  }