window.addEventListener('load', () => {
// Campo fecha en registro - modificar texto placeholder cuando se elija la fecha
  const inputDate = document.querySelector('#inputDate');
  const inputDatePlaceholder = document.querySelector('#inputDatePlaceholder');

  // Campo de fecha - página Registro
  let picker = new Pikaday({
    field: document.getElementById('datepicker'),
    format: 'D/M/YYYY',
    toString(date, format) {
      // Obtener dia, mes y año y retornar la fecha completa
      const day = date.getDate();
      const month = date.getMonth() + 1;
      const year = date.getFullYear();
      return `${day}/${month}/${year}`;
    },
    parse(dateString, format) {
      // formato de la fecha con la / incluida
      const parts = dateString.split('/');
      const day = parseInt(parts[0], 10);
      const month = parseInt(parts[1], 10) - 1;
      const year = parseInt(parts[2], 10);
      return new Date(year, month, day);
    }
  });
});

