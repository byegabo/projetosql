<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manipular Produtos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['inserir'])) {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $categoria = $_POST['categoria'];

    if ($nome && $descricao && $preco && $categoria) {
        $sql = "INSERT INTO produtos (Nome_do_Produto, Descrição, Preço, Categoria) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssds", $nome, $descricao, $preco, $categoria);

        if ($stmt->execute()) {
            echo "Produto inserido com sucesso!";
        } else {
            echo "Erro ao inserir o produto: " . $stmt->error;
        }
    } else {
        echo "Preencha todos os campos!";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['excluir'])) {
    $nome_excluir = $_POST['nome_excluir'];

    if ($nome_excluir) {
        $sql = "DELETE FROM produtos WHERE Nome_do_Produto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nome_excluir);

        if ($stmt->execute()) {
            echo "Produto excluído com sucesso!";
        } else {
            echo "Erro ao excluir o produto: " . $stmt->error;
        }
    } else {
        echo "Informe o nome do produto para excluir!";
    }
}

function listar_produtos($conn) {
    $sql = "SELECT * FROM produtos";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Nome do Produto</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Categoria</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['ID'] . "</td>
                    <td>" . $row['Nome_do_Produto'] . "</td>
                    <td>" . $row['Descrição'] . "</td>
                    <td>" . $row['Preço'] . "</td>
                    <td>" . $row['Categoria'] . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "Nenhum produto encontrado!";
    }
}

function contar_produtos($conn) {
    $sql = "SELECT COUNT(*) AS total FROM produtos";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manipular Produtos</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>

<h2>Inserir Produto</h2>
<form action="" method="POST">
    <label for="nome">Nome do Produto:</label>
    <input type="text" name="nome" required><br>

    <label for="descricao">Descrição:</label>
    <textarea name="descricao" required></textarea><br>

    <label for="preco">Preço:</label>
    <input type="text" name="preco" required><br>

    <label for="categoria">Categoria:</label>
    <input type="text" name="categoria" required><br>

    <input type="submit" name="inserir" value="Inserir Produto">
</form>

<h2>Excluir Produto</h2>
<form action="" method="POST">
    <label for="nome_excluir">Nome do Produto para Excluir:</label>
    <input type="text" name="nome_excluir" required><br>

    <input type="submit" name="excluir" value="Excluir Produto">
</form>

<h2>Listagem de Produtos</h2>
<?php
    listar_produtos($conn);
    $total_produtos = contar_produtos($conn);
    echo "<p><strong>Total de produtos cadastrados:</strong> $total_produtos</p>";
?>

</body>
</html>

<?php
$conn->close();
?>
