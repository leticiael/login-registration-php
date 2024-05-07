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

    echo "<div style='text-align: center; font-family: Roboto, sans-serif; color: #000000; padding: 35px;'>"; 
    echo "<h1 style='font-size: 40px; margin-bottom: 20px;'>Bem-vindo(a), $nome!</h1>"; 
    echo "<p style='font-size: 30px; margin-bottom: 20px;'>Data de Nascimento: $data_nascimento</p>"; 

   
    if (!empty($foto_nome)) {
        $foto_src = "../img/$foto_nome"; 

        echo "<img src='$foto_src' alt='Foto de Perfil' style='border-radius: 50%; width: 200px; height: 200px; object-fit: cover; margin-bottom: 20px;'>";
    } else {
        echo "Foto de perfil não encontrada.";
    }

    echo "<form action='logout.php' method='post'>";
    echo "<input type='submit' name='logout' value='Sair' style='padding: 20px; font-size: 20px; background-color: #AD88C6; color: #ffffff; border: none; border-radius: 5px; cursor: pointer;'>";
    echo "</form>";
    echo "</div>";
} else {
    echo "Dados do usuário não encontrados.";
}

$conn->close();
?>
