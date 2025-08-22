// Alterar funcionario
function validarFormulario(event) {
    // Pegando os campos pelo id
    const nome = document.getElementById("nome_funcionario");
    const endereco = document.getElementById("endereco");
    const telefone = document.getElementById("telefone");
    const email = document.getElementById("email");

    let mensagensErro = [];

    // Validação de nome
    if (nome && nome.value.trim().length < 3) {
        mensagensErro.push("O nome deve ter pelo menos 3 caracteres.");
    }

    // Validação de endereço
    if (endereco && endereco.value.trim().length < 5) {
        mensagensErro.push("O endereço deve ter pelo menos 5 caracteres.");
    }

    // Validação de telefone
    if (telefone && (telefone.value.length < 8 || isNaN(telefone.value))) {
        mensagensErro.push("Digite um telefone válido com pelo menos 8 números.");
    }

    // Validação de e-mail (regex simples)
    if (email && !/^[\w._%+-]+@[\w.-]+\.[a-zA-Z]{2,}$/.test(email.value)) {
        mensagensErro.push("Digite um e-mail válido.");
    }

    // Se tiver erros, exibe alert e cancela envio
    if (mensagensErro.length > 0) {
        alert(mensagensErro.join("\n"));
        event.preventDefault(); // Impede o envio do formulário
    }
}

// Adiciona a função de validação ao formulário quando o DOM carregar
document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form[action='processa_alteracao_funcionario.php']");
    if (form) {
        form.addEventListener("submit", validarFormulario);
    }
});

// Alterar usuario
function validarFormularioUsuario(event) {
    const nome = document.getElementById("nome");
    const email = document.getElementById("email");
    const perfil = document.getElementById("id_perfil");
    const senha = document.getElementById("nova_senha");

    let mensagensErro = [];

    // Nome precisa ter ao menos 3 caracteres
    if (nome && nome.value.trim().length < 3) {
        mensagensErro.push("O nome deve ter pelo menos 3 caracteres.");
    }

    // E-mail precisa estar em formato válido
    if (email && !/^[\w._%+-]+@[\w.-]+\.[a-zA-Z]{2,}$/.test(email.value)) {
        mensagensErro.push("Digite um e-mail válido.");
    }

    // Perfil precisa estar selecionado
    if (perfil && (perfil.value === "" || perfil.value === null)) {
        mensagensErro.push("Selecione um perfil.");
    }

    // Nova senha (se existir no formulário) deve ter pelo menos 6 caracteres
    if (senha && senha.value.trim() !== "" && senha.value.length < 6) {
        mensagensErro.push("A nova senha deve ter pelo menos 6 caracteres.");
    }

    // Se houver erros, impede envio e mostra mensagens
    if (mensagensErro.length > 0) {
        alert(mensagensErro.join("\n"));
        event.preventDefault();
    }
}

// Executa quando a página terminar de carregar
document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form[action='processa_alteracao_usuario.php']");
    if (form) {
        form.addEventListener("submit", validarFormularioUsuario);
    }
});

// Função para validar formulário de cadastro de funcionário
function validarCadastroFuncionario(event) {
    const nome = document.getElementById("nome_funcionario");
    const endereco = document.getElementById("endereco");
    const telefone = document.getElementById("telefone");
    const email = document.getElementById("email");

    let mensagensErro = [];

    // Nome precisa ter ao menos 3 caracteres
    if (nome && nome.value.trim().length < 3) {
        mensagensErro.push("O nome deve ter pelo menos 3 caracteres.");
    }

    // Endereço precisa ter ao menos 5 caracteres
    if (endereco && endereco.value.trim().length < 5) {
        mensagensErro.push("O endereço deve ter pelo menos 5 caracteres.");
    }

    // Telefone: só números, pelo menos 8 dígitos
    if (telefone && (telefone.value.length < 8 || isNaN(telefone.value))) {
        mensagensErro.push("Digite um telefone válido com pelo menos 8 números.");
    }

    // E-mail: precisa estar em formato válido
    if (email && !/^[\w._%+-]+@[\w.-]+\.[a-zA-Z]{2,}$/.test(email.value)) {
        mensagensErro.push("Digite um e-mail válido.");
    }

    // Se houver erros, cancela envio e mostra mensagens
    if (mensagensErro.length > 0) {
        alert(mensagensErro.join("\n"));
        event.preventDefault();
    }
}

// Quando a página carregar, conecta a validação ao formulário
document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form[action='cadastro_funcionario.php']");
    if (form) {
        form.addEventListener("submit", validarCadastroFuncionario);
    }
});

// Função para validar formulário de cadastro de usuário
function validarCadastroUsuario(event) {
    const nome = document.getElementById("nome");
    const email = document.getElementById("email");
    const senha = document.getElementById("senha");
    const perfil = document.getElementById("id_perfil");

    let mensagensErro = [];

    // Nome: mínimo 3 caracteres
    if (nome && nome.value.trim().length < 3) {
        mensagensErro.push("O nome deve ter pelo menos 3 caracteres.");
    }

    // Email: formato válido
    if (email && !/^[\w._%+-]+@[\w.-]+\.[a-zA-Z]{2,}$/.test(email.value)) {
        mensagensErro.push("Digite um e-mail válido.");
    }

    // Senha: pelo menos 6 caracteres
    if (senha && senha.value.length < 6) {
        mensagensErro.push("A senha deve ter pelo menos 6 caracteres.");
    }

    // Perfil: precisa estar selecionado
    if (perfil && (perfil.value === "" || perfil.value === null)) {
        mensagensErro.push("Selecione um perfil válido.");
    }

    // Se tiver erros, impede envio e mostra alert
    if (mensagensErro.length > 0) {
        alert(mensagensErro.join("\n"));
        event.preventDefault();
    }
}

// Conecta a função ao formulário quando a página carregar
document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form[action='cadastro_usuario.php']");
    if (form) {
        form.addEventListener("submit", validarCadastroUsuario);
    }
});