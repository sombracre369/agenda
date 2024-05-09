<?php

include 'BD/conexao.php';
include_once 'funcoes.php';

if (isset($_GET['acao']) && $_GET['acao'] == 'editar'){

    $id = isset($_GET['id']) ? $_GET['id'] : 0;

    $conexaoComBanco = abrirBD();

    $sql= "SELECT * FROM pessoas WHERE id = ?";
    
    $pegarDados = $conexaoComBanco->prepare($sql);

    $pegarDados->bind_param("i",$id);

    $pegarDados->execute();
    $result = $pegarDados->get_result();

    if($result->num_rows == 1){

        $registro = $result->fetch_assoc();
        dd($registro);

    } else {
        echo "nenhum registro encontrado";
        exit;
    }
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
            <input type="text" id="nome" name="nome" value="<?= $registro['nome'] ?>" required>

            <label for="sobrenome">Sobrenome</label>
            <input type="text" id="sobrenome" name="sobrenome" value="<?= $registro['sobrenome'] ?>" required>

            <label for="idade">Nascimento</label>
            <input type="date" id="nascimento" name="nascimento" value="<?= $registro['nascimento'] ?>" required>

            <label for="telefone">Telefone</label>
            <input type="text" id="telefone" name="telefone" value="<?= $registro['telefone'] ?>" required>

            <label for="endereco">Endereço</label>
            <input type="text" id="endereco" name="endereco" value="<?= $registro['endereco'] ?>" required>

            <button type="submit">Atualizar</button>

        </form>
    </section>
</body>

</html>