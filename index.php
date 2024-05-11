<?php

require_once('./routes/route.php');

// Obtendo a URI da requisição
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

//var_dump("minha uri" . $uri . "esta aqui");

// Verificando se a URI existe no array de rotas e se o método HTTP corresponde
if (isset($routes[$uri]) && (empty($routes[$uri]['method']) || $routes[$uri]['method'] === $_SERVER['REQUEST_METHOD'])) {
    //var_dump("minha route" . $routes . "esta aqui");
    // Se existir, incluindo o arquivo PHP correspondente
    require_once($routes[$uri]['file']);
    //var_dump("Check" , $routes[$uri]['file']);
} else {
    //echo "Page Not Found! $uri";
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>EPM</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
  <div class="container centralizar-pagina">
    <h1 class="conteudo">Employee and Project Management</h1>
    <div class="container-botoes-radio">
  <div class="row">
    <div class="col-md-6">
    <a href="./controllers/employee.php" class="nav-link">
      <label for="funcionario-radio" class="botao-radio">
        <img src="https://cdn.iconscout.com/icon/premium/png-512-thumb/about-1568812-1326392.png?f=webp&w=256" alt="Funcionário"></br>
       
      </label>
      Register Employee</a>
    </div>
    <div class="col-md-6">
      
      <label for="projeto-radio" class="botao-radio">
        <img src="./assets/image/project-preview.png" alt="Projeto"></br>
        <span>Registrar Projeto</span>
      </label>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <label for="alocar-radio" class="botao-radio">
        <img src="https://cdn.iconscout.com/icon/premium/png-512-thumb/about-1568812-1326392.png?f=webp&w=256" alt="Alocar"></br>
        <span>Alocar Funcionário ao Projeto</span>
      </label>
    </div>
    <div class="col-md-6">
      <label for="sobre-radio" class="botao-radio">
        <img src="https://cdn.iconscout.com/icon/premium/png-512-thumb/about-1568812-1326392.png?f=webp&w=256" alt="Sobre"></br>
        <span>Sobre</span>
      </label>
    </div>
  </div>
</div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>