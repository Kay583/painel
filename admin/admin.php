<?php
session_start();
include_once('config.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['email'])) {
  header('Location: ./login/login.html');
  exit();
}

// Obtém o email do usuário logado
$email = $_SESSION['email'];


// Verifica se a requisição é para atualizar o tema
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tema'])) {
  $novoTema = $_POST['tema'];

  // Atualiza o tema no banco de dados
  $sql = "UPDATE usuarios SET tema = ? WHERE email = ?";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("ss", $novoTema, $email);
    $stmt->execute();
    $stmt->close();
    $_SESSION['tema'] = $novoTema; // Atualiza o tema na sessão
    echo "Tema atualizado com sucesso!";
  } else {
    echo "Erro ao preparar a consulta: " . $conn->error;
  }
  exit();
}

// Lida com atualização de configurações
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_settings'])) {
  $new_setting = $_POST['new_setting'];
  $sql = "UPDATE usuarios SET setting = ? WHERE email = ?";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("ss", $new_setting, $email);
    $stmt->execute();
    $stmt->close();
    echo "Configurações atualizadas com sucesso!";
  } else {
    echo "Erro ao preparar a consulta: " . $conn->error;
  }
  exit();
}

// Busca a foto do banco
$sql = "SELECT foto_perfil FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
  $foto = $row['foto_perfil'];
} else {
  $foto = "../uploads/default.png";
}

// Lida com atualização de senha
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_password'])) {
  $new_password = $_POST['new_password'];
  $sql = "UPDATE usuarios SET senha = ? WHERE email = ?";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("ss", $new_password, $email);
    $stmt->execute();
    $stmt->close();
    $_SESSION['senha'] = $new_password;
    echo "Senha atualizada com sucesso!";
  } else {
    echo "Erro ao preparar a consulta: " . $conn->error;
  }
  exit();
}

// Conecta ao banco e busca a preferência de tema e status do usuário
$sql = "SELECT tema, usuario_ativo, foto_perfil FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($tema, $usuario_ativo, $foto_perfil);
$stmt->fetch();
$stmt->close();

// Define a preferência de tema na sessão
$_SESSION['tema'] = $tema ? $tema : 'claro';
$_SESSION['usuario_ativo'] = $usuario_ativo;
$_SESSION['foto_perfil'] = $foto_perfil;

$logado = $_SESSION['email'];

// Verifica o nome do usuário e imprime ele do lado da foto de perfil
$nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : 'Usuário';

// Verifica se o usuário já tem uma preferência de tema
$tema_preferido = $_SESSION['tema'];

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AssisTec</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@48,400,0,0" />
  <link rel="stylesheet" href="admin.css">
</head>

<body class="<?php echo $_SESSION['tema'] === 'escuro' ? 'dark-theme-variables' : ''; ?>">
  <div class="container">
    <aside>

      <div class="top">
        <div class="logo">
          <h2>Dash<span class="danger">Board</span></h2>
        </div>
        <div class="close" id="close_btn">
          <span class="material-symbols-sharp">
            close
          </span>
        </div>
      </div>
      <!-- end top -->
      <div class="sidebar">

        <a href="#">
          <span class="material-symbols-sharp">grid_view </span>
          <h3>Fornecedor</h3>
        </a>
        <a href="#" class="active">
          <span class="material-symbols-sharp">person_outline </span>
          <h3>Clientes</h3>
        </a>
        <a href="#" id="analise_link">
          <span class="material-symbols-sharp">insights </span>
          <h3>Análise</h3>
        </a>
        <a href="#">
          <span class="material-symbols-sharp">receipt_long </span>
          <h3>Produtos</h3>
        </a>
        <a href="#" id="settings_link">
          <span class="material-symbols-sharp">settings </span>
          <h3>Configurações</h3>
        </a>
        <a href="#">
          <span class="material-symbols-sharp">add </span>
          <h3>Add Produto</h3>
        </a>
        <a href="../login/sair.php">
          <span class="material-symbols-sharp">logout </span>
          <h3>Sair</h3>
        </a>

      </div>

    </aside>

    <main>
      <h1>Assis<span style="color: blue;">Tec</span></h1>

      <div class="date">
        <input type="date">
      </div>

      <div class="insights">

        <!-- start seling -->
        <div class="sales">
          <span class="material-symbols-sharp">trending_up</span>
          <div class="middle">

            <div class="left">
              <h3>Total de vendas</h3>
              <h1>$25,024</h1>
            </div>
            <div class="progress">
              <svg>
                <circle r="30" cy="40" cx="40"></circle>
              </svg>
              <div class="number">
                <p>80%</p>
              </div>
            </div>

          </div>
          <small>Todo o período</small>
        </div>
        <!-- end seling -->
        <!-- start expenses -->
        <div class="expenses">
          <span class="material-symbols-sharp">local_mall</span>
          <div class="middle">

            <div class="left">
              <h3>Total de vendas</h3>
              <h1>$25,024</h1>
            </div>
            <div class="progress">
              <svg>
                <circle r="30" cy="40" cx="40"></circle>
              </svg>
              <div class="number">
                <p>80%</p>
              </div>
            </div>

          </div>
          <small>Todo o período</small>
        </div>
        <!-- end seling -->
        <!-- start seling -->
        <div class="income">
          <span class="material-symbols-sharp">stacked_line_chart</span>
          <div class="middle">

            <div class="left">
              <h3>Total de vendas</h3>
              <h1>$25,024</h1>
            </div>
            <div class="progress">
              <svg>
                <circle r="30" cy="40" cx="40"></circle>
              </svg>
              <div class="number">
                <p>80%</p>
              </div>
            </div>

          </div>
          <small>Todo o período</small>
        </div>
        <!-- end seling -->

      </div>
      <!-- end insights -->

      <!-- Falta criar as funçoes do Js para funcionar todos os gráficos-->
      <!-- Criar uma tabela para produtos que serão cadastrados-->
      <!-- Criar uma nova página para mostrar os produtos disponíveis-->

      <div class="recent_order">
        <h2>Últimos pedidos</h2>
        <div id="chartContainer" style="display:none;">
          <canvas id="analiseChart"></canvas>
        </div>
        <table>
          <thead>
            <tr>
              <th>Produto</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Mini USB</td>
              <td>4563</td>
              <td>Due</td>
              <td class="warning">Pending</td>
            </tr>
            <tr>
              <td>Mini USB</td>
              <td>4563</td>
              <td>Due</td>
              <td class="warning">Pending</td>
            </tr>
            <tr>
              <td>Mini USB</td>
              <td>4563</td>
              <td>Due</td>
              <td class="warning">Pending</td>
            </tr>
            <tr>
              <td>Mini USB</td>
              <td>4563</td>
              <td>Due</td>
              <td class="warning">Pending</td>
            </tr>
          </tbody>
        </table>
        <a href="#">Mostrar tudo</a>
      </div>

    </main>
    <!------------------
         end main
        ------------------->

    <!----------------
        start right main 
      ---------------------->
    <div class="right">

      <div class="top">
        <button id="menu_bar">
          <span class="material-symbols-sharp">menu</span>
        </button>

        <div class="theme-toggler">
          <span class="material-symbols-sharp active">light_mode</span>
          <span class="material-symbols-sharp">dark_mode</span>
        </div>
        <div class="profile">
          <div class="info">
            <p><b><?php echo $_SESSION['nome']; ?></b></p>
            <p><?php echo $_SESSION['nivel_usuario']; ?></p>
            <small class="text-muted"></small>
          </div>
          <div class="profile-photo">
            <?php if ($foto): ?>
              <img src="data:image/jpeg;base64,<?php echo base64_encode($foto); ?>" alt="foto de perfil" />
            <?php else: ?>
              <img src="../uploads/default.png" alt="foto de perfil" />
            <?php endif; ?>
          </div>
        </div>
        <div class="settings">
          <div class="settings-menu" id="settings_menu">
            <div class="settings-header">
              <h2 class="config">Configurações</h2>
              <button id="close_settings" class="close-btn">X</button>
            </div>
            <form method="POST" action="update_profile.php" enctype="multipart/form-data">
              <label for="profile_picture">Mudar Foto de Perfil:</label>
              <input type="file" id="profile_picture" name="foto_perfil">
              <label for="new_password">Mudar Senha:</label>
              <input type="password" id="new_password" name="senha">
              <input type="submit" name="submit" value="Salvar Alterações">
            </form>
            <p>Nível do Usuário: <b><?php echo $_SESSION['nivel_usuario']; ?></b></p>
            <p>Status: <b><?php echo $_SESSION['usuario_ativo'] ? 'Ativo' : 'Inativo'; ?></b></p>
          </div>
        </div>
      </div>



      <div class="sales-analytics">
        <h2>Analítico de Vendas</h2>

        <div class="item onlion">
          <div class="icon">
            <span class="material-symbols-sharp">shopping_cart</span>
          </div>
          <div class="right_text">
            <div class="info">
              <h3>Vendedor vendas</h3>
              <small class="text-muted">Vendas da semana/mês</small>
            </div>
            <h5 class="danger">-17%</h5>
            <h3>3849</h3>
          </div>
        </div>
        <div class="item onlion">
          <div class="icon">
            <span class="material-symbols-sharp">shopping_cart</span>
          </div>
          <div class="right_text">
            <div class="info">
              <h3>Vendas da equipe: Supervisor</h3>
              <small class="text-muted">Vendas da semana/mês</small>
            </div>
            <h5 class="success">-17%</h5>
            <h3>3849</h3>
          </div>
        </div>

      </div>

      <div class="item add_product">
        <div>
          <span class="material-symbols-sharp">add</span>
        </div>
      </div>
    </div>


  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    let chart = null;

    document.getElementById('analise_link').addEventListener('click', function(event) {
      event.preventDefault();
      document.getElementById('chartContainer').style.display = 'block';
      const ctx = document.getElementById('analiseChart').getContext('2d');

      if (chart) {
        chart.destroy();
      }

      chart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
          datasets: [{
            label: 'Sales',
            data: [12, 19, 3, 5, 2, 3, 7],
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    });
  </script>
  <script src="admin.js"></script>
</body>

</html>