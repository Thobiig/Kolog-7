document.getElementById("register-form").addEventListener("submit", async => {
    e.preventDefault();
    console.log(e.target.children.username.value)
    const res = await fetch("http://localhost:4000/api/register",{
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            email: e.target.children.email.value,
            username: e.target.children.username.value,
            password: e.target.children.password.value
        })
    });
})