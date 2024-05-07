<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistemalogin_cad";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['produto_id'])) {
    $produto_id = $_POST['produto_id'];

    // Excluir o produto do banco de dados
    $sql_excluir = "DELETE FROM produtos WHERE id = $produto_id";

    if ($conn->query($sql_excluir) === TRUE) {
        echo "Produto excluído com sucesso.";
    } else {
        echo "Erro ao excluir o produto: " . $conn->error;
    }
} else {
    echo "Parâmetros inválidos para a exclusão do produto.";
}

$conn->close();
?>
