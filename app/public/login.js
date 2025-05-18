document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.getElementById("login-form");
    const errorText = document.querySelector(".error");

    loginForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const username = e.target.username.value;
        const password = e.target.password.value;

        try {
            const res = await fetch("http://localhost:4000/api/login", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    correo: username,
                    contraseña: password
                })
            });

            const data = await res.json();

            if (!res.ok) {
                throw new Error(data.message || "Error al iniciar sesión");
            }

            sessionStorage.setItem("token", data.token);
            sessionStorage.setItem("rol", data.rol);

            if (data.rol === "profesor") {
                window.location.href = "/preguntas";
            } else if (data.rol === "estudiante") {
                window.location.href = "/museo";
            } else {
                alert("Rol no válido.");
            }

        } catch (err) {
            console.error(err);
            errorText.classList.remove("escondido");
            errorText.textContent = err.message || "Error al iniciar sesión";
        }
    });
});
