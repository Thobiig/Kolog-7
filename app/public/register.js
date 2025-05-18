// public/register.js

// Control del formulario de registro de usuario

document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('register-form');
  const errorMsg = document.querySelector('.error');

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    // Obtener valores del formulario
    const nombre = form.username.value.trim();
    const correo = form.email.value.trim();
    const contraseña = form.password.value;
    const confirmPassword = form['confirm-password'].value;

    // Validar contraseñas coincidan
    if (contraseña !== confirmPassword) {
      errorMsg.textContent = 'Las contraseñas no coinciden';
      errorMsg.classList.remove('escondido');
      return;
    }

    // Construir el payload que el backend espera
    const body = {
      nombre,
      correo,
      contraseña,
      rol: 'estudiante'   // Asignamos por defecto rol de estudiante
    };

    try {
      const res = await fetch('/api/register', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(body)
      });

      const data = await res.json();

      if (!res.ok) {
        // Mostrar mensaje de error desde el backend
        errorMsg.textContent = data.error || 'Error al registrarse';
        errorMsg.classList.remove('escondido');
      } else {
        // Registro exitoso: redirigir a la página de login
        alert(data.message);
        window.location.href = '/login';
      }
    } catch (err) {
      console.error('Fetch error:', err);
      errorMsg.textContent = 'Error de conexión';
      errorMsg.classList.remove('escondido');
    }
  });
});
