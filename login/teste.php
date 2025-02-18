<?php
session_start();
include_once('config.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['email'])) {
  header('Location: login.html');
  exit();
}

$email = $_SESSION['email'];
$logado = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="pt-br"> 

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gerenciar Sessão - Funerária Agricultor</title>
  <style>
    /* Estilos gerais */
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      display: flex;
      background-color: #fafad2;
    }

    /* Menu Lateral */
    .menu-lateral {
      width: 150px;
      background-color: #45502c;
      color: white;
      height: 100vh;
      position: fixed;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 20px;
    }

    /* Estilo para a lista do menu lateral */
    .menu-lateral ul li {
      width: 100%;
      padding: 8px 0;
      /* Menos espaço entre as opções */
      margin: 4px 0;
      /* Menor margem entre as opções */
      display: flex;
      align-items: center;
      text-align: center;
      border-radius: 4px;
    }

    /* Estilo do link no menu */
    .menu-lateral ul li a {
      color: white;
      text-decoration: none;
      font-size: 16px;
      /* Tamanho de fonte ajustado para não ocupar tanto espaço */
      padding: 6px 16px;
      /* Menos padding */
      width: 100%;
      display: block;
      text-align: left;
      transition: color 0.3s;
    }

    /* Cor do link ao passar o mouse */
    .menu-lateral ul li a:hover {
      color: #5e6e3a;
      /* Cor do texto ao passar o mouse */
    }

    .logo-container img {
      max-width: 130px;
      border-radius: 50%;
    }

    .menu-lateral a {
      color: white;
      text-decoration: none;
      margin: 10px 0;
    }

    /* Conteúdo Principal */
    .conteudo-principal {
      margin-left: 200px;
      padding: 20px;
    }

    /* Estilos adicionais */
    .conteudo-principal h2 {
      font-size: 24px;
      margin-bottom: 20px;
    }

    .conteudo-principal p {
      font-size: 18px;
      margin-bottom: 10px;
    }

    .conteudo-principal a {
      color: #007BFF;
      font-size: 16px;
      text-decoration: none;
      font-weight: bold;
    }

    .conteudo-principal a:hover {
      text-decoration: underline;
    }

    .card {
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 20px;
      margin-bottom: 20px;
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .card:hover {
      transform: scale(1.05);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .card h3 {
      margin-top: 0;
    }

    .card p {
      margin: 10px 0;
    }

    .card a {
      display: inline-block;
      margin-top: 10px;
      padding: 10px 20px;
      background-color: #007BFF;
      color: white;
      border-radius: 5px;
      text-decoration: none;
      transition: background-color 0.3s;
    }

    .card a:hover {
      background-color: #0056b3;
    }
  </style>
</head>

<body>
  <div class="menu-lateral">
    <div class="logo-container">
      <img src="<?php echo htmlspecialchars($foto_perfil, ENT_QUOTES, 'UTF-8'); ?>" alt="Logo do Site" id="logo">
    </div>
    <nav>
      <ul>
        <li><a href="../sistemaConta/sistema.php">Voltar</a></li>
      </ul>
    </nav>
  </div>

  <div class="conteudo-principal">
    <section id="inicio">
      <div class="card">
        <h2>Bem-vindo à sua área de gerenciamento</h2>
        <p>Você está logado como: <?php echo htmlspecialchars($logado, ENT_QUOTES, 'UTF-8'); ?></p>
        <p>O que deseja fazer agora?</p>
        <a href="../login/sair.php">Sair da Sessão</a>
      </div>
      <div class="card">
        <h3>Gerenciar Perfil</h3>
        <p>Atualize suas informações pessoais e preferências.</p>
        <a href="perfil.php">Gerenciar Perfil</a>
      </div>
      <div class="card">
        <h3>Histórico de Pedidos</h3>
        <p>Veja o histórico de seus pedidos e serviços solicitados.</p>
        <a href="historico.php">Ver Histórico</a>
      </div>
      <div class="card">
        <h3>Configurações</h3>
        <p>Altere suas configurações de conta e preferências.</p>
        <a href="configuracoes.php">Configurações</a>
      </div>
    </section>
  </div>
</body>
<script>
  function changeTheme(theme) {
    if (theme === 'escuro') {
      document.body.style.backgroundColor = '#333';
      document.body.style.color = '#000';
    } else {
      document.body.style.backgroundColor = '#fafad2';
      document.body.style.color = '#000';
    }
  }

  // Define o tema inicial com base na preferência do usuário
  document.addEventListener('DOMContentLoaded', function() {
    changeTheme('<?php echo htmlspecialchars($tema_preferido, ENT_QUOTES, 'UTF-8'); ?>');
  });
</script>

</html>