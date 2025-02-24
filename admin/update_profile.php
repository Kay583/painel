<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: ../login/login.html');
    exit();
}

include_once('config.php');

// Coleta os dados do formulário
$senha = trim($_POST['senha']);
$foto = $_FILES['foto_perfil'];

// Verifica se o email atual está na sessão
$email_atual = $_SESSION['email'];

// Atualiza os dados do usuário no banco de dados
if (!empty($senha)) {
    // Criptografa a nova senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    $sql = "UPDATE usuarios SET senha = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $senhaHash, $email_atual);
    $stmt->execute();
    $stmt->close();
}

// Processa o upload da foto de perfil
if ($foto['error'] == UPLOAD_ERR_OK) {
    $foto_binario = file_get_contents($foto['tmp_name']); // Converte o arquivo em binário

    // Prepara o SQL para inserir a foto
    $sql_foto = "UPDATE usuarios SET foto_perfil = ? WHERE email = ?";
    $stmt_foto = $conn->prepare($sql_foto);
    $null = NULL;
    $stmt_foto->bind_param("bs", $null, $email_atual);
    $stmt_foto->send_long_data(0, $foto_binario);

    // Executa a query
    if ($stmt_foto->execute()) {
        $_SESSION['foto_perfil'] = $foto_binario;
        echo "Foto de perfil atualizada!";
    } else {
        echo "Erro ao atualizar foto de perfil: " . $stmt_foto->error;
    }
    $stmt_foto->close();
} else {
    echo "Erro ao enviar arquivo.";
    exit();
}

echo "<script>alert('Perfil atualizado com sucesso!'); window.location.href = 'vendedor.php';</script>";
exit();
