document.addEventListener('DOMContentLoaded', () => {
  // Referencias
  const btnMenuOpen = document.querySelector("#btnMenuOpen"); // referencia Botón abrir menú nav
  const btnMenuClose = document.querySelector("#btnMenuClose"); // referencia Botón cerrar menú nav
  const headerListLinks = document.querySelector("#headerListLinks"); // referencia menú links nav
  const navLinks = document.querySelectorAll(".header_items"); // referencia items links del nav
  const btnTop = document.querySelector("#btnTop"); // referencia botón top



  // funcion que muetra/oculta el botón top
  const showHideBtnTop = () => {
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
      btnTop.style.display = "block";
    } else {
      btnTop.style.display = "none";
    };
  };

  //Evento scroll para llamar a función que muetra/oculta el botón top
  window.onscroll = () => showHideBtnTop();

  // Función para hacer scroll hacia arriba
  const goToTop = () => {
    document.body.scrollTop = 0; // Ir hacia arriba - opción para unos navegadores
    document.documentElement.scrollTop = 0; // Ir hacia arriba - optimo para otros navegadores
  };

  //Escuchar evento click en botón Top y llamar a función para hacer scroll hacia arriba
  btnTop.addEventListener('click', goToTop);

  // abrir menu de navegación responsive
  btnMenuOpen.addEventListener('click', () => {
    headerListLinks.classList.remove('hide_links-animation');
    headerListLinks.classList.add('show_links');
    headerListLinks.classList.add('show_links-animation');
    btnMenuOpen.classList.remove('btn_menu-active');
    btnMenuClose.classList.add('btn_menu-active');
  });

  // cerrar menu de navegación responsive
  btnMenuClose.addEventListener('click', () => {
    headerListLinks.classList.add('hide_links-animation');
    setTimeout(() => {
      headerListLinks.classList.remove('show_links');
    }, 500);
    btnMenuOpen.classList.add('btn_menu-active');
    btnMenuClose.classList.remove('btn_menu-active');
  });

  // Cerrar menú de navegación responsive cuando se hace click en un link
  for (let link of navLinks) {
    link.addEventListener('click', () => {
      headerListLinks.classList.add('hide_links-animation');
      setTimeout(() => {
        headerListLinks.classList.remove('show_links');
      }, 500);
      btnMenuOpen.classList.add('btn_menu-active');
      btnMenuClose.classList.remove('btn_menu-active');
    });
  }

  // acceder al botón tendencias anterior
  const btnTrendPrev = document.querySelector("#btnTrendPrev");
  // acceder al botón tendencias siguiente
  const btnTrendNext = document.querySelector("#btnTrendNext");

  // Escuchar evento resize al cargar la pagina
  // Escuchar el evento resize para cambiar contenido de botón anterior/siguiente en index tendencias
  window.addEventListener('resize', () => {
    const widthWindow = window.innerWidth; // obtener el ancho de la ventana
    // Si el ancho es inferior a 576px mostrar iconos en botones
    if (widthWindow < 576) {
      if (btnTrendPrev && btnTrendNext) { // si existen los botones mostrar iconos

        btnTrendPrev.innerHTML = "<i class=\"fa-solid fa-angle-left\"></i>";
        btnTrendNext.innerHTML = "<i class=\"fa-solid fa-angle-right\"></i>";
      }
    } else { // si es mayor a 576px mostrar el texto
      if (btnTrendPrev && btnTrendNext) { // si existen los botones mostrar texto

        btnTrendPrev.innerText = "Anterior";
        btnTrendNext.innerText = "Siguiente";
      };
    }
  });
  // disparar el evento resize cuando cargar el navegador
  window.dispatchEvent(new Event('resize'));

  // Conteneder peliculas aclamadas
  const acclaimedsContainer = document.querySelector("#acclaimedsContainer");
  //  Botón next slice peliculas aclamadas
  const acclaimedBtnNext = document.querySelector("#acclaimedBtnNext");
  //  Botón prev slice peliculas aclamadas
  const acclaimedBtnPrev = document.querySelector("#acclaimedBtnPrev");
  // Evento click botón next - mover slice hacia la izquierda
  if (acclaimedBtnNext && acclaimedBtnPrev) { // si existen los botones escuchar el evento click
    acclaimedBtnNext.addEventListener('click', () => {
      acclaimedsContainer.scrollLeft += 400;
    });
    // Evento click botón prev - mover slice hacia la izquierda
    acclaimedBtnPrev.addEventListener('click', () => {
      acclaimedsContainer.scrollLeft -= 400;
    });
  };

  //Scroll aclamadas - detectar inicio/fin para mostrar/ocultar botones next ó prev
  if (acclaimedsContainer) { // si el contenedor aclamadas existe escuchar y verificar el evento scroll
    function verifyScrollAcclaimed() {
      // Verificar la posición final del contenedor
      if (acclaimedsContainer.scrollWidth - acclaimedsContainer.scrollLeft === acclaimedsContainer.clientWidth) {
        acclaimedBtnNext.disabled = true;
        acclaimedBtnNext.classList.add('acclaimed_btn-hide');
      } else {
        acclaimedBtnNext.disabled = false;
        acclaimedBtnNext.classList.remove('acclaimed_btn-hide');
      }
      // Verificar la posicion inicial del contenedor
      if (acclaimedsContainer.scrollLeft === 0) {
        acclaimedBtnPrev.disabled = true;
        acclaimedBtnPrev.classList.add('acclaimed_btn-hide');
      } else {
        acclaimedBtnPrev.disabled = false;
        acclaimedBtnPrev.classList.remove('acclaimed_btn-hide');
      }
    };
    // Llamar a función verificar scroll position y escuchar el evento scroll haciendo la verificación
    verifyScrollAcclaimed();
    acclaimedsContainer.addEventListener('scroll', verifyScrollAcclaimed);
  };
  /* escuchar evento scroll para que detecte en que sección del index estoy y aplique la animación correspondiente
    según donde este */
  const searchContainer = document.querySelector("#searchContainer"); //contenedor search
  const trendsContainer = document.querySelector('#trends'); // contenedor peliculas - tendencias
  const acclaimedContainer = document.querySelector('#acclaimeds') // contenedor peliculas - aclamadas
  // Escuchar evento scroll
  window.addEventListener('scroll', () => {
    const scrollPos = window.scrollY || window.scrollTop;
    const windowHeight = window.innerHeight;

    // Obtener posicion scroll contenedor search
    if (searchContainer) { // si el contenedor existe obtener posicion scroll contenedor search y aplicar animación
      const rectSearch = searchContainer.getBoundingClientRect(); // obtener posicion scroll contenedor search
      // Si el contenedor está a la altura de la ventana desde el borde superior
      if (rectSearch.top - scrollPos < windowHeight) {
        searchContainer.classList.add('anim_slice_up');
      } else {
        searchContainer.classList.remove('anim_slice_up');
      }
    };
    // Obtener posicion scroll contenedor peliculas - tendencias
    if (trendsContainer) { // si el contenedor existe obtener posicion scroll contenedor peliculas - tendencias
      const rectTrends = trendsContainer.getBoundingClientRect();
      // Si el contenedor está a la altura de la ventana desde el borde superior
      if (rectTrends.top - scrollPos < windowHeight) {
        trendsContainer.classList.add('anim_slice_up');
      } else {
        trendsContainer.classList.remove('anim_slice_up');
      }
    };
    // Obtener posicion scroll contenedor peliculas - aclamadas
    if (acclaimedsContainer) { // si el contenedor existe obtener posicion scroll contenedor peliculas - aclamadas
      const rectAcclaimeds = acclaimedContainer.getBoundingClientRect();
      // Si el contenedor está a la altura de la ventana desde el borde superior
      if (rectAcclaimeds.top - scrollPos < windowHeight / 4) {
        acclaimedContainer.classList.add('anim_slice_up');
      } else {
        acclaimedContainer.classList.remove('anim_slice_up');
      }
    };
  });
});









