document.getElementById("formLogin").addEventListener("submit", function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch("login.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        document.getElementById("msg").innerText = data;
    })
    .catch(err => {
        document.getElementById("msg").innerText = "Erro ao enviar";
    });
});
