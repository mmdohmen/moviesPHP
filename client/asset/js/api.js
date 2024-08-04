// console.log('probando api');
const characters = document.querySelector('#characters');
const pagination = document.querySelector('#pagination');
let page = 1;


// Función para hacer scroll hacia arriba
const goToTop = () => {
  document.body.scrollTop = 0; // Ir hacia arriba - opción para unos navegadores
  document.documentElement.scrollTop = 0; // Ir hacia arriba - optimo para otros navegadores
};

// mostrar spinner cuando cargan los datos
const loadingCards = () => {
  const loading = document.createElement('div');
  loading.innerHTML = `
  <div class="spinner-border spinner_style w-full p-5 mt-5 fs-1" role="status">
    <span class="visually-hidden">Loading...</span>
  </div>
  `;
  return loading;
};

const getData = async (url) => {
  const loading = loadingCards();
  characters.append(loading);
  const response = await fetch(url);
  const data = await response.json();
  characters.removeChild(loading);
  return data;
}

(async () => {
  let dataApi = await getData('https://rickandmortyapi.com/api/character');
  dataApi.results.forEach(element => {
    const character = createCard(element.name, element.image, element.species, element.gender, element.origin);
    // console.log(character)
    characters.append(character);
  });

  // Boton ir a siguiente pagina
  const buttonRight = document.createElement('button');
  buttonRight.innerHTML = '<i class="fa-solid fa-chevron-right"></i>';
  buttonRight.className = 'btn_next_prev';
  // Boton ir a anterior pagina
  const buttonLeft = document.createElement('button');
  buttonLeft.innerHTML = '<i class="fa-solid fa-chevron-left"></i>';
  buttonLeft.className = 'btn_next_prev';

  //escuchar el evento click en boton right
  buttonRight.addEventListener('click', async () => {
    page++;
    chequearPagina(page, buttonLeft, buttonRight); // llamar a funcion para chequear la página actual
    goToTop();
    characters.innerHTML = '';
    dataApi = await getData(dataApi.info.next);
    dataApi.results.forEach(element => {
      const character = createCard(element.name, element.image, element.species, element.gender, element.origin);
      // console.log(character)
      characters.append(character);
    });
  });

  //escuchar el evento click en boton left
  buttonLeft.addEventListener('click', async () => {

    if (page > 0) { // disminuye el número de página mientras la pagina actual sea mayor a 0
      page--;
    }

    chequearPagina(page, buttonLeft, buttonRight); // llamar a funcion para chequear la página actual
    goToTop();
    characters.innerHTML = '';
    dataApi = await getData(dataApi.info.prev);
    dataApi.results.forEach(element => {
      const character = createCard(element.name, element.image, element.species, element.gender, element.origin);
      // console.log(character)
      characters.append(character);
    });
  });

  pagination.append(buttonLeft); //muetra el botón izquierdo
  pagination.append(buttonRight); //muetra el botón derecho

  chequearPagina(page, buttonLeft, buttonRight); // llamar a funcion para chequear la página actual


  // Función para chequear la página actual y habilitar o deshabilitar el boton left ó right
  function chequearPagina(numeroPagina, botonLeft, botonRight) {
    // console.log(numeroPagina)
    if (numeroPagina === 1) {
      botonLeft.setAttribute('disabled', true);
    } else {
      botonLeft.removeAttribute('disabled');
    }

    if (numeroPagina === dataApi.info.pages) {
      botonRight.setAttribute('disabled', true);
    } else {
      botonRight.removeAttribute('disabled');
    }
  }

})();

const createCard = (name, image, species, gender, origin) => {

  const card = document.createElement('div');
  card.className = 'animate__animated animate__zoomIn animate_faster'
  card.innerHTML =
    `
  <div class="card_character card" style="width: 18rem; height:500px">
  <img src="${image}" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title text-white fw-bold">${name}</h5>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">Especie: ${species}</li>
    <li class="list-group-item">Género: ${gender}</li>
    <li class="list-group-item">Origen: ${origin.name}</li>
  </ul>
</div>
  `;
  return card;
};

