<?php

include 'BD/conexao.php';

// echo "<pre>";
// print_r($_SERVER);
// echo "</pre>";
// exit;

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // Capitura os dados digitados no form e salva em varias
    //para facilitar a manipulação dos dados
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $nascimento = $_POST['nascimento'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];

    //abre conexão com banco de dados
    $conexaoComBanco = abrirBD();

    //cria um SQL para realizar insert dos dados
    $sql = "INSERT INTO pessoas (nome, sobrenome, nascimento)
            VALUES ('$nome', '$sobrenome', '$nascimento')";

    if ($conexaoComBanco->query($sql) == TRUE) {

        $ultimo_id = $conexaoComBanco->insert_id;
        $sql = "INSERT INTO enderecos (endereco, idpessoa)
        VALUES ('$endereco', $ultimo_id)";

        if ($conexaoComBanco->query($sql) == TRUE) {

            $sql = "INSERT INTO telefones (telefone, idpessoa)
                VALUES ('$telefone', $ultimo_id)";

            if ($conexaoComBanco->query($sql) == TRUE) {

                echo  "Sucessor ao cadastrar o contato";
            } else {
                echo ":( Erro ao cadastrar o contato :(";
            }
        }
    }

    fecharBD($conexaoComBanco);
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/estilo_cadastrar.css">
    <title>Agenda</title>
</head>

<body>
    <header>
        <h1>Agenda de contatos</h1>

        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="cadastrar.php">Cadastrar</a></li>
            </ul>
        </nav>
    </header>

    <section>
        <h2>Cadastrar Contato</h2>
        <form action="" method="post" enctype="multipart/form-data">

            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" required>

            <label for="sobrenome">Sobrenome</label>
            <input type="text" id="sobrenome" name="sobrenome" required>

            <label for="idade">Nascimento</label>
            <input type="date" id="nascimento" name="nascimento" required>

            <label for="telefone">Telefone</label>
            <input type="text" id="telefone" name="telefone" required>

            <label for="endereco">Endereço</label>
            <input type="text" id="endereco" name="endereco" required>

            <input type="hidden" name="acao" value="">

            <button type="submit">Cadastrar</button>

        </form>
    </section>
</body>

</html>