function toggleVisibility(button) {
  let passwordInput = button.previousElementSibling;
  let visibilityIcon = button.querySelector(".material-icons");

  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    visibilityIcon.textContent = "visibility_off";
  } else {
    passwordInput.type = "password";
    visibilityIcon.textContent = "visibility";
  }
}

$(document).ready(function () {
  $("#identidade").mask("000.000.000-0");
  $("#cpf").mask("0000");
});
function regexNumero(dado) {
  dado = dado.replace(/[^\d]+/g, "");
  return dado;
}

document.getElementById("identidade").addEventListener("input", function () {
  let identidadeMInput = this;
  let identidadeM = regexNumero(identidadeMInput.value);
  if (identidadeM.length < 10) {
    identidadeMInput.setCustomValidity("Indentidade inválida");
  } else {
    identidadeMInput.setCustomValidity("");
  }
});
