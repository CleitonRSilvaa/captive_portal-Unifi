function regexNumero(dado) {
  dado = dado.replace(/[^\d]+/g, "");
  return dado;
}

function validarCPF(cpf) {
  cpf = regexNumero(cpf);

  if (cpf.length !== 11 || /^(.)\1+$/.test(cpf)) {
    return false;
  }

  var soma = 0;
  var resto;

  for (var i = 1; i <= 9; i++) {
    soma += parseInt(cpf.substring(i - 1, i)) * (11 - i);
  }

  resto = (soma * 10) % 11;

  if (resto === 10 || resto === 11) {
    resto = 0;
  }

  if (resto !== parseInt(cpf.substring(9, 10))) {
    return false;
  }

  soma = 0;

  for (var j = 1; j <= 10; j++) {
    soma += parseInt(cpf.substring(j - 1, j)) * (12 - j);
  }

  resto = (soma * 10) % 11;

  if (resto === 10 || resto === 11) {
    resto = 0;
  }

  if (resto !== parseInt(cpf.substring(10, 11))) {
    return false;
  }

  return true;
}

$(document).ready(function () {
  $("#cpf").mask("000.000.000-00");
  $("#cpfBusca").mask("000.000.000-00");
  $(".cpf").mask("000.000.000-00");
  $("#editCpf").mask("000.000.000-00");
  $("#identidadeM").mask("000.000.000-0");
  $(".identidadeM").mask("000.000.000-0");
  $("#editIdentidade").mask("000.000.000-0");
});

document.getElementById("cpf").addEventListener("input", function () {
  let cpfInput = this;
  let cpf = cpfInput.value;
  let alert = document.getElementById("cpfAlert");
  if (validarCPF(cpf)) {
    cpfInput.setCustomValidity("");
    alert.textContent = "";
    alert.style.display = "none";
  } else {
    cpfInput.setCustomValidity("CPF inválido");
    alert.textContent = "Por favor, digite um CPF válido!";
    alert.style.display = "block";
  }
});

document.getElementById("identidadeM").addEventListener("input", function () {
  let identidadeMInput = this;
  let identidadeM = regexNumero(identidadeMInput.value);
  let alert = document.getElementById("identidadeMAlert");
  if (identidadeM.length < 10) {
    identidadeMInput.setCustomValidity("Indentidade inválida");
    alert.textContent = "Número da identidade incompleto!";
    alert.style.display = "block";
  } else {
    identidadeMInput.setCustomValidity("");
    alert.textContent = "";
    alert.style.display = "none";
  }
});

document.getElementById("editCpf").addEventListener("input", function () {
  let cpfInput = this;
  let cpf = cpfInput.value;
  let alert = document.getElementById("editCpfAlert");
  if (validarCPF(cpf)) {
    cpfInput.setCustomValidity("");
    alert.textContent = "";
    alert.style.display = "none";
  } else {
    cpfInput.setCustomValidity("CPF inválido");
    alert.textContent = "Por favor, digite um CPF válido!";
    alert.style.display = "block";
  }
});

document
  .getElementById("editIdentidade")
  .addEventListener("input", function () {
    let identidadeMInput = this;
    let identidadeM = regexNumero(identidadeMInput.value);
    let alert = document.getElementById("editIdentidadeMAlert");
    if (identidadeM.length < 10) {
      identidadeMInput.setCustomValidity("Indentidade inválida");
      alert.textContent = "Número da identidade incompleto!";
      alert.style.display = "block";
    } else {
      identidadeMInput.setCustomValidity("");
      alert.textContent = "";
      alert.style.display = "none";
    }
  });

function validarFormulario() {
  let nome = document.forms["myForm"]["nome"].value;
  let cpf = document.forms["myForm"]["cpf"].value;
  let identidadeM = document.forms["myForm"]["identidadeM"].value;

  if ((nome === "" || cpf === "", identidadeM === "")) {
    alert("Por favor, preencha todos os campos.");
    return false;
  }
  return true; // O formulário será enviado
}

function validarFormularioEdit() {
  let nome = document.forms["editModal"]["editNome"].value;
  let cpf = document.forms["editModal"]["editCpf"].value;
  let identidadeM = document.forms["editModal"]["editIdentidadeM"].value;

  if ((nome === "" || cpf === "", identidadeM === "")) {
    alert("Por favor, preencha todos os campos.");
    return false;
  }
  return true; // O formulário será enviado
}

function limparCampos() {
  document.getElementById("myForm").reset();
  document.getElementById("editModal").reset();
  document.getElementById("editIdentidadeMAlert").style.display = "none";
  document.getElementById("editCpfAlert").style.display = "none";
}
document
  .getElementById("myModal")
  .addEventListener("hidden.bs.modal", limparCampos);

function preencherInputs(id, nome, cpf, identidade) {
  var editId = document.querySelector('#editModal input[name="editId"]');
  var editNome = document.querySelector('#editModal input[name="editNome"]');
  var editCpf = document.querySelector('#editModal input[name="editCpf"]');
  var editIdentidade = document.querySelector(
    '#editModal input[name="editIdentidade"]'
  );

  editId.value = id;
  editNome.value = nome;
  editCpf.value = cpf;
  editIdentidade.value = identidade;
}
function minhaFuncao(event) {
  // Obtém os valores dos atributos de dados do botão clicado
  const button = event.currentTarget;
  const id = button.dataset.id;
  const nome = button.dataset.nome;
  const cpf = button.dataset.cpf;
  const identidade = button.dataset.identidade;

  preencherInputs(id, nome, cpf, identidade);

  // Abre o modal de edição
  var editModal = new bootstrap.Modal(document.getElementById("editModal"));
  editModal.show();
}
// Obtém uma referência para todos os botões com a classe 'meuBotao'
var botoes = document.querySelectorAll(".meuBotao");
// Adiciona um evento de clique a cada botão
botoes.forEach(function (botao) {
  botao.addEventListener("click", minhaFuncao);
});
function deleteUser() {
  Swal.fire({
    title: "Excluir usuário?",
    text: "Você não vai conseguir reverter isso!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sim, deletar !",
  }).then((result) => {
    if (result.isConfirmed) {
      var form = document.getElementById("formDelete");
      form.submit();
    }
  });
}
