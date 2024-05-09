<?php
// incluir conexao na pagina e todo o seu conteudo
include_once 'BD/conexao.php';
include_once 'funcoes.php';



if (isset($_GET['acao']) && $_GET['acao'] == 'excluir') {

    $id = $_GET['id'];

    if ($id > 0) {
        //abrir conexao com o banco de dados
        $conexaoComBanco = abrirBD();

        //prepara a consula SQL para selecionaar dados
        $sql = "DELETE from telefones where idpessoa = $id;";

        if ($result = $conexaoComBanco->query($sql) === true) {

            $sql = "DELETE from enderecos where idpessoa = $id";

            if ($result = $conexaoComBanco->query($sql) === true) {

                $sql = "DELETE from pessoas where id = $id;";


                if ($result = $conexaoComBanco->query($sql) === true) {

?>
        <script>
            alert("deu certo!");
        </script>
<?php



                }
            }
        }
    }
}

//tentativa de formatar telefone


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/estilo_index.css">
    <title>Home</title>
</head>

<body>
    <div class="conteiner">
        <header class="navegador">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="cadastrar.php">Cadastrar</a></li>
            </ul>
        </header>

        <main class="conteudo">
            <section class="sessao">
                <h2 class="titulo">Lista de Contato</h2>
                <table class="tabela">
                    <thead class="cabecario">
                        <tr>
                            <td>ID</td>
                            <td>Nome</td>
                            <td>Sobrenome</td>
                            <td>Nascimento</td>
                            <td>Endereço</td>
                            <td>Telefone</td>
                            <td>Ações</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //abrir conexao com o banco de dados
                        $conexaoComBanco = abrirBD();

                        //prepara a consula SQL para selecionaar dados
                        $sql = "SELECT p.*, t.telefone, e.endereco from pessoas as p 
                            join enderecos as e on p.id = e.idpessoa
                            join telefones as t on p.id = t.idpessoa";

                        //executar a query (o sql no banco)
                        $result = $conexaoComBanco->query($sql);
                        // $registros = $result->fetch_assoc();
                        if ($result->num_rows > 0) {

                            while ($registros = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?= $registros['id'] ?></td>
                                    <td><?= $registros['nome'] ?></td>
                                    <td><?= $registros['sobrenome'] ?></td>
                                    <td><?= date("d/m/Y", strtotime($registros['nascimento'])) ?></td>
                                    <td><?= $registros['endereco'] ?></td>
                                    <td><?= $registros['telefone'] ?></td>
                                    <td>
                                        <a href="?acao=excluir&id=<?= $registros['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir contato de <?= $registros['nome'] ?>?')">
                                            <button>
                                                <img src="img/3817209.png" width="20">
                                            </button>
                                        </a>

                                        <a href="editar.php?acao=editar&id=<?= $registros['id'] ?>">
                                            <button>
                                                <img src="img/1486564394-edit_81508.png" width="20">
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            // echo "<tr><td colspan = '7'>tem não rapaz</td></tr>";
                            ?>

                            <tr>
                                <td colspan="7">Tem não rapaz</td>
                            </tr>

                        <?php
                        }
                        ?>


                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>

</html>