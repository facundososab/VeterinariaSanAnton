formulario = document.getElementById('formulario');

const validate = (e) => {
  e.preventDefault();
  const email = document.getElementById('inputEmail');
  const clave = document.getElementById('inputPassword');
  const emailError = document.getElementById('emailError');
  const claveError = document.getElementById('passwordError');

  if (!emailValido(email.value.trim())) {
    emailError.innerHTML = 'Email inválido';
  }

  if (!claveValida(clave.value.trim())) {
    claveError.innerHTML =
      'Clave inválida. Debe tener entre 8 y 15 caracteres, al menos una letra mayúscula, una letra minúscula, un número y un carácter especial.';
  }

  if (emailValido(email.value) && claveValida(clave.value)) {
    formulario.submit();
  }
};

const emailValido = (email) => {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
};

const claveValida = (clave) => {
  return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,15}/.test(
    clave
  );
};

formulario.addEventListener('submit', validate);
