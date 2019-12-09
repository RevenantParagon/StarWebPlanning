<?php
$connect = mysqli_connect('127.0.0.1', 'newuser', 'toor');
$db = mysqli_select_db($connect, 'projeto');

$pdo = new PDO('mysql:host=localhost;dbname=projeto', 'newuser', 'toor');

function primeiroAcesso()
{
  $verifica = mysqli_query($GLOBALS['connect'], "SELECT * FROM tb_usuario") or die("erro ao selecionar");

  if (mysqli_num_rows($verifica) == 0) {
    header("Location:./register.php");
  }
}

function verificaAcesso($caminho)
{
  if ($_SESSION['tipo'] != 1 && $caminho != "./index.php") {
    echo "<script>window.location.href='./index.php'</script>";
  }
}

function verificacaoChave($chave)
{
  if (!empty($chave)) {
    $select = "SELECT * FROM tb_usuario WHERE usrChave = :chave";

    $stmt = $GLOBALS['pdo']->prepare($select);

    $stmt->bindValue(":chave", $chave);

    $stmt->execute();

    if ($stmt->rowcount() == 1)
      return true;
  }
  return false;
}

function verifica_registro()
{
  $verifica = mysqli_query($GLOBALS['connect'], "SELECT * FROM tb_usuario") or die("erro ao selecionar");

  if (mysqli_num_rows($verifica) > 0)
    header("Location:./login.php");
}

function verifica_campus($id)
{
  $select = "select camId from tb_usuario where usrId=:id";

  $stmt = $GLOBALS['pdo']->prepare($select);

  $stmt->bindValue(":id", $id);

  $stmt->execute();

  if ($stmt->rowcount() == 1) {
    return true;
  }
  return false;
}


function telaInicial()
{
  if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }
  ?>
  <div class="wrapper">
    <div class="float-right">
      <a href="../back/login_back.php?logout=1"><i class="fas fa-sign-out-alt">Logout</i></a>
    </div>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href=<?php echo "../src/users.php?funcao=1&id=" . $_SESSION["id"] . ""; ?> class="nav-link">Perfil</a>
        </li>
      </ul>
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index.php" class="brand-link">
          <img src="../img/Title.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">Star Web Planning</span>
        </a>
        <?php
          if ($_SESSION["tipo"] == "1") {
            ?>
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fa fa-user-circle"></i>
                  <p>
                    Usuário
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./users.php?funcao=cadastrar" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Cadastrar</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./visualiza_users.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Pesquisar</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fa fa-graduation-cap"></i>
                  <p>
                    Campus
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./campus.php?funcao=cadastrar" class="nav-link">
                      <i alt="Cadastro de Campus" class="far fa-circle nav-icon"></i>
                      <p>Cadastrar</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./visualiza_campus.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Pesquisar</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fab fa-chromecast"></i>
                  <p>
                    Equipamentos
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./equip.php?funcao=cadastrar" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Cadastrar</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./visualiza_equip.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Pesquisar</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </nav>
        <?php } else { ?>
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

              <li class="nav-item">
                <a href="./visualiza_campus.php" class="nav-link">
                  <i class="nav-icon fa fa-graduation-cap"></i>
                  <p>
                    Campus
                  </p>
                </a>
              </li>
            </ul>
          </nav>
        <?php } ?>
        <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
  </aside>

<?php
}
?>