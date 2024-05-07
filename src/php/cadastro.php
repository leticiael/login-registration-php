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
    
    if (!empty(trim($_POST['nome'])) && !empty(trim($_POST['email'])) && !empty($_POST['senha']) && !empty($_POST['data_nascimento']) && !empty($_FILES['foto']['name'])) {
        $nome = trim($_POST['nome']);
        $email = trim($_POST['email']);
        $senha = $_POST['senha'];
        $data_nascimento = $_POST['data_nascimento'];
        $foto_tmp = $_FILES['foto']['tmp_name'];
        $foto_nome = $_FILES['foto']['name'];
        $foto_destino = "../img/" . $foto_nome; 
        
       
        if (strlen($senha) >= 8 && $senha !== trim($senha)) {
            if (move_uploaded_file($foto_tmp, $foto_destino)) {
                
                $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

                // Instrução preparada para evitar injeção SQL
                $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, data_nascimento, foto_perfil) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $nome, $email, $senha_hash, $data_nascimento, $foto_nome);

                if ($stmt->execute()) {
                    echo "Cadastro realizado com sucesso. Faça login <a href='../login.html'>aqui</a>.";
                } else {
                    echo "Erro ao cadastrar: " . $stmt->error;
                }
            } else {
                echo "Erro ao fazer upload da foto.";
            }
        } else {
            echo "A senha deve ter no mínimo 8 caracteres e não pode conter apenas espaços em branco.";
        }
    } else {
        echo "Todos os campos são obrigatórios.";
    }
}

$conn->close();
?>

$conn->close();
?>


