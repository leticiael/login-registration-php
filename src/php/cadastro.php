<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistemalogin_cad";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $data_nascimento = $_POST['data_nascimento'];
    $foto_tmp = $_FILES['foto']['tmp_name'];
    $foto_nome = $_FILES['foto']['name'];
    $foto_destino = "../img/" . $foto_nome; 
    
    if (move_uploaded_file($foto_tmp, $foto_destino)) {
        // Hash da senha
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
       
        $sql_inserir = "INSERT INTO usuarios (nome, email, senha, data_nascimento, foto_perfil) VALUES ('$nome', '$email', '$senha_hash', '$data_nascimento', '$foto_nome')";

        if ($conn->query($sql_inserir) === TRUE) {
            echo "Cadastro realizado com sucesso. Faça login <a href='../login.html'>aqui</a>.";
        } else {
            echo "Erro ao cadastrar: " . $conn->error;
        }
    } else {
        echo "Erro ao fazer upload da foto.";
    }
}

$conn->close();
?>


