<?php
session_start();
if (isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha'])) {

    include_once('config.php');

    // Coleta os dados do formulário
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    // Verifica se o email existe no banco de dados
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    

    // Verifica se um registro foi encontrado
    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();

        // Verifica se a senha fornecida corresponde à hash armazenada
        if ($senha === $usuario['senha'] or password_verify($senha, $usuario['senha'])) {
            $_SESSION['email'] = $email;
            $_SESSION['senha'] = $senha;
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['nivel_usuario'] = $usuario['nivel_usuario'];
            $_SESSION['tema'] = $usuario['tema'];

            // Redireciona para diferentes páginas com base no nível do usuário
            if ($usuario['nivel_usuario'] === 'Administrador') {
                header("Location: ../admin/admin.php");
            } elseif ($usuario['nivel_usuario'] === 'Fornecedor') {
                header("Location: ../fornecedor/fornecedor.php");
            } elseif ($usuario['nivel_usuario'] === 'Vendedor') {
                header("Location: ../vendedor/vendedor.php");
            } elseif ($usuario['nivel_usuario'] === 'CEO') {
                header("Location: ../index.php");
            }
            exit();
        } else {
            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            echo "<script>alert('Senha incorreta!');</script>";
            header("Location: login.html");
            exit();
        }
    } else {
        echo "<script>alert('Usuário não encontrado!');</script>";
        header("Location: login.html");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    header('Location: login.html');
    exit();
}
