<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistemalogin_cad";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_produto = $_POST['nome_produto'];
    $quantidade = $_POST['quantidade'];
    $tipo = $_POST['tipo'];
    $valor = $_POST['valor'];

    // Insere os dados na tabela de produtos
    $sql_insert = "INSERT INTO produtos (nome, quantidade, tipo, valor) VALUES ('$nome_produto', $quantidade, '$tipo', $valor)";

    if ($conn->query($sql_insert) === TRUE) {
        echo "Produto cadastrado com sucesso.";
    } else {
        echo "Erro ao cadastrar o produto: " . $conn->error;
    }
}

$conn->close();
?>
