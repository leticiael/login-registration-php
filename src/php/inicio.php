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

$email = $_SESSION['email'];

$sql_dados_usuario = "SELECT nome, data_nascimento, foto_perfil FROM usuarios WHERE email='$email'";
$result_dados_usuario = $conn->query($sql_dados_usuario);

if ($result_dados_usuario->num_rows > 0) {
    $row = $result_dados_usuario->fetch_assoc();
    $nome = $row['nome'];
    $data_nascimento = $row['data_nascimento'];
    $foto_nome = $row['foto_perfil'];

    echo "<div style='text-align: center; font-family: Arial, sans-serif; color: #000000; padding: 35px;'>"; 
    echo "<h1 style='font-size: 40px; margin-bottom: 10px;'>Bem-vindo(a), $nome!</h1>"; 
    echo "<p style='font-size: 20px; margin-bottom: 10px;'>Data de Nascimento: $data_nascimento</p>"; 

    if (!empty($foto_nome)) {
        $foto_src = "../img/$foto_nome"; 
        echo "<img src='$foto_src' alt='Foto de Perfil' style='border-radius: 50%; width: 150px; height: 150px; object-fit: cover; margin-bottom: 20px;'>";
    } else {
        echo "Foto de perfil não encontrada.";
    }

    echo "<form action='logout.php' method='post'>";
    echo "<input type='submit' name='logout' value='Sair' style='padding: 10px; font-size: 16px; background-color: #AD88C6; color: #ffffff; border: none; border-radius: 5px; cursor: pointer;'>";
    echo "</form>";

    
    echo "<div style='margin-top: 50px;'>";
    echo "<h2 style='font-size: 24px; margin-bottom: 10px;'>Cadastro de Produto</h2>";
    echo "<form action='cadastrar_produto.php' method='post' style='text-align: left;'>";
    echo "<label for='nome_produto'>Nome do Produto:</label><br>";
    echo "<input type='text' id='nome_produto' name='nome_produto' required style='width: 100%; margin-bottom: 10px;'><br>";
    echo "<label for='quantidade'>Quantidade:</label><br>";
    echo "<input type='number' id='quantidade' name='quantidade' required style='width: 100%; margin-bottom: 10px;'><br>";
    echo "<label for='tipo'>Tipo:</label><br>";
    echo "<select id='tipo' name='tipo' required style='width: 100%; margin-bottom: 10px;'>";
    echo "<option value='eletronico'>Eletrônico</option>";
    echo "<option value='roupa'>Roupa</option>";
    echo "</select><br>";
    echo "<label for='valor'>Valor:</label><br>";
    echo "<input type='text' id='valor' name='valor' required style='width: 100%; margin-bottom: 10px;'><br>";
    echo "<input type='submit' value='Cadastrar Produto' style='padding: 10px; font-size: 16px; background-color: #4CAF50; color: #ffffff; border: none; border-radius: 5px; cursor: pointer;'>";
    echo "</form>";
    echo "</div>";


    echo "<h2 style='font-size: 24px; margin-top: 50px;'>Produtos Cadastrados</h2>";

    $sql_produtos = "SELECT * FROM produtos";
    $result_produtos = $conn->query($sql_produtos);

    if ($result_produtos->num_rows > 0) {
        echo "<div style='display: flex; flex-wrap: wrap; justify-content: space-around;'>";
        while ($row_produto = $result_produtos->fetch_assoc()) {
            echo "<div style='border: 1px solid #ccc; border-radius: 5px; width: 30%; margin: 10px; padding: 10px;'>";
            echo "<h3>" . $row_produto['nome'] . "</h3>";
            echo "<p>Quantidade: " . $row_produto['quantidade'] . "</p>";
            echo "<p>Tipo: " . $row_produto['tipo'] . "</p>";
            echo "<p>Valor: " . $row_produto['valor'] . "</p>";
           
            echo "<form action='excluir_produto.php' method='post'>";
            echo "<input type='hidden' name='produto_id' value='" . $row_produto['id'] . "'>";
            echo "<input type='submit' value='Excluir Produto' style='padding: 5px; font-size: 14px; background-color: #f44336; color: #ffffff; border: none; border-radius: 5px; cursor: pointer;'>";
            echo "</form>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<p>Nenhum produto cadastrado.</p>";
    }

    echo "</div>";
} else {
    echo "Dados do usuário não encontrados.";
}

$conn->close();
?>

