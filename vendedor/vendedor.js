const sideMenu = document.querySelector("aside");
const menuBtn = document.querySelector("#menu_bar");
const closeBtn = document.querySelector("#close_btn");

const themeToggler = document.querySelector(".theme-toggler");

menuBtn.addEventListener("click", () => {
  sideMenu.style.display = "block";
});
closeBtn.addEventListener("click", () => {
  sideMenu.style.display = "none";
});

themeToggler.addEventListener("click", () => {
  // Alterna o tema no frontend
  document.body.classList.toggle("dark-theme-variables");
  themeToggler.querySelector("span:nth-child(1)").classList.toggle("active");
  themeToggler.querySelector("span:nth-child(2)").classList.toggle("active");

  // Define o novo tema com base na presença da classe
  const novoTema = document.body.classList.contains("dark-theme-variables")
    ? "escuro"
    : "claro";

  // Envia a atualização para o servidor
  fetch("vendedor.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: "tema=" + novoTema, // Envia o tema para ser atualizado no banco
  })
    .then((response) => response.text())
    .then((data) => console.log(data)) // Mostra a resposta do servidor no console
    .catch((error) => console.error("Erro ao salvar tema:", error));
});

document
  .getElementById("settings_link")
  .addEventListener("click", function (event) {
    event.preventDefault();
    document.getElementById("settings_menu").classList.toggle("show");
  });

document.getElementById("settings_link").addEventListener("click", function () {
  document.getElementById("settings_menu").classList.toggle("show");
});

document
  .getElementById("settings_link")
  .addEventListener("click", function (event) {
    event.preventDefault();
    document.getElementById("settings_menu").classList.toggle("show");
  });

document
  .getElementById("close_settings")
  .addEventListener("click", function () {
    document.getElementById("settings_menu").classList.remove("show");
  });
