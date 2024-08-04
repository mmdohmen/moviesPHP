const errorEmail = document.querySelector("#errorEmail");
const errorPassword = document.querySelector("#errorPassword");
const formLogin = document.querySelector("#formLogin");

let validarEmail = false;
let validarPassword = false;


// Caputar el evento submit del formulario
formLogin.addEventListener('submit', (event) => {
  validateForm(event);
});


// Validación del formulario
const validateForm = (event) => {
  const email = document.querySelector('#email').value;
  const password = document.querySelector('#password').value;
  // const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // expresión regular para validar email en formato correcto
  const emailRegex = /^(([^<>()[\]\\.,;:\s@\“]+(\.[^<>()[\]\\.,;:\s@\“]+)*)|(\“.+\“))@((\[[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}])|(([a-zA-Z\-0–9]+\.)+[a-zA-Z\-0–9]{2,}))$/; // expresión regular para validar email en formato correcto

  // Validar email, vacio, formato correcto y longitud máxima
  if (email.trim() === '') {
    event.preventDefault();
    messageError('El email es obligatorio', errorEmail);
  } else if (email.length > 60) {
    event.preventDefault();
    messageError('El email no debe superar los 60 caracteres', errorEmail);
  } else if (!emailRegex.test(email)) {
    event.preventDefault();
    messageError('Ingrese un email válido', errorEmail);
  } else {
    clearError(errorEmail);
    validarEmail = true;
  };

  // Validar password , vacio, minimo de 8 caracteres, sin espacios
  if (password === '') {
    // event.preventDefault();
    messageError('La contraseña es obligatoria', errorPassword);
  } else if (password.length < 8 || password.length > 20) {
    event.preventDefault();
    messageError('Ingrese una contraseña entre 8 y 20 caractares', errorPassword);
  } else if (password.includes(' ')) {
    event.preventDefault();
    messageError('La contraseña no debe contener espacios', errorPassword);
  } else {
    clearError(errorPassword);
    validarPassword = true;
  }

  // LLamar a función Mensaje de exito validaciones
  if (validarEmail && validarPassword) {
    // event.preventDefault();
    messageSuccess();
  }
};

// Mensaje de error validaciones
const messageError = (message, element) => {
  element.innerHTML = message;
  element.className = 'text-danger fs-6 mt-1 ms-1';
};

// Limpiar errores de validación
const clearError = (element) => {
  element.innerHTML = '';
};

// Mensaje de éxito sweetAlert 2
const messageSuccess = () => {
  let timerInterval;
  Swal.fire({
    title: "Datos Correctos",
    html: "<p class='text-center'>Iniciando sesión</p>",
    timer: 3000,
    timerProgressBar: true,
    didOpen: () => {
      Swal.showLoading();
      const timer = Swal.getPopup().querySelector("b");
      timerInterval = setInterval(() => {
        timer.textContent = `${Swal.getTimerLeft()}`;
      }, 100);
    },
    willClose: () => {
      clearInterval(timerInterval);
    }
  }).then((result) => {
    if (result.dismiss === Swal.DismissReason.timer) {
      location.href = "https://lea-2024.github.io/proyecto-movies/";
    }
  });
}