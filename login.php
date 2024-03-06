<?php
  include "config.php";

  if (isset($_SESSION['login'])){
    header('Location: admin_page.php');
    exit;
  }

  // set cookie
  $usernameCookie ='';
  $passwordCookie= '';
  if (isset($_COOKIE['login']) && isset($_COOKIE['password'])){
    $usernameCookie = $_COOKIE['login'];
    $passwordCookie = $_COOKIE['password'];
  }

  $msg = '';
  if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $check_admin = "SELECT * FROM `data_admin` WHERE username = ? AND password = ?";
    $check_admin = $connect->prepare($check_admin);
    $check_admin->execute([
      $username,
      $password,
    ]);

    if ($check_admin->rowCount() == 0){
      $msg = '<div class="alert alert-danger">Email atau Password tidak sesuai!</div>';
    }
    else{
      // jika remember me di centang maka set cookie
      if(isset($_POST['remember'])){
        setcookie('login', $username, time() + (60*60*24));
        setcookie('password', $password, time() + (60*60*24));
      }
      // jika tidak maka set cookie menjadi kosong
      else{
        setcookie('login', '', time() - (60*60*24));
        setcookie('password', '', time() - (60*60*24));
      }

      $_SESSION['login'] = true;
      header('location: admin_page.php');
      exit;
    }
  }
?>

<!-- HTML -->
<!DOCTYPE HTML>
<html>
<head>
    <title>Login</title>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
</head>
<style>
    body{
      background-image: url("pexels-fauxels-3183132.jpg");background-size:100%
    }
    .container{
      margin: auto;
      position: absolute;
      width: 100%;
      top: 50%;
      left: 53%;
      transform: translate(-50%, -50%);
    }
    .tombol_login{
      width: 140px;
      height: 45px;
      font-size: 23px;
      cursor: pointer;
      border: none;
      outline: none;
      background: transparent;
      color: black;
      font-family: 'Times New Roman', Times, serif;
      font-weight: 700;
      position: relative;
      transition: all 0.5s;
      z-index: 1;
    }

    .tombol_login::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 5px;
    height: 100%;
    background-color: black;
    z-index: -1;
    transition: all 0.5s;
    }

    .tombol_login:hover::before {
    width: 150%;
    }

    .tombol_login:hover {
    color: white;
    }

    .tombol_login:active:before {
    background: #b9b9b9;
    }
</style>


<body>
<nav class="navbar navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Login Admin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Welcome</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">ViewReport</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
        </ul>
        <form class="d-flex mt-3" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </div>
</nav>

<div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active" data-bs-interval="2000">
      <img src="pexels-fauxels-3183132.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item" data-bs-interval="2000">
      <img src="dom-fou-YRMWVcdyhmI-unsplash.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item" data-bs-interval="2000">
      <img src="changbok-ko-F8t2VGnI47I-unsplash.jpg" class="d-block w-100" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
    
<div class="container">
  <div class="row justify-content-center">
    <div class="col-sm-4">
      <div class="card border-dark mb-3" style="max-width: 18rem;">
        <div class="card-header bg-dark text-white text-center"><h3>Login Admin</h3></div>
        <div class="card-body">
          <?=(isset($msg) ? $msg : '') ?>
          <form action="" method="POST" class="form-horizontal">
            <div class="form-group">
              <label for="username" class="control-label"><b>Username</b></label>
              <!--add value username jika cookie ada -->
              <input type="text" name="username" value="<?php echo $usernameCookie ?>" class="form-control" required> 
            </div>
            <div class="form-group">
              <label for="password" class="control-label"><b>Password</b></label>
              <!--add value password jika cookie ada -->
              <input type="password" name="password"  value="<?php echo $passwordCookie ?>" class="form-control" required>
            </div>

            <label for="remember"><b>Remember me</b></label>
            <input type="checkbox" name="remember" <?php if(isset($_COOKIE['login'])) ?> checked <?php ?>>
            <br>
            <button class="tombol_login" type="submit" name="login">
            <span>Login</span>
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
