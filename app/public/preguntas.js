document.getElementById("form-pregunta").addEventListener("submit", async (e) => {
            e.preventDefault();

            const form = e.target;
            const respuestas = [
                form.respuesta1.value,
                form.respuesta2.value,
                form.respuesta3.value,
                form.respuesta4.value,
            ];
            const correcta = parseInt(form.correcta.value);

            const body = {
                pregunta: form.pregunta.value,
                nivel: form.nivel.value,
                respuestas: respuestas.map((texto, index) => ({
                    texto,
                    es_correcta: (index + 1) === correcta
                }))
            };

            const res = await fetch("/api/preguntas", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(body)
            });

            const data = await res.json();
            alert(data.message);
        });