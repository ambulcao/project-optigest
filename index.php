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
  <section class="container">

  <div class="container centralizar-pagina">
    <h1 class="conteudo">Gerenciamento Integrado de Equipes e Projetos</h1>
    <div class="container-botoes-radio">

  <div class="row">

    <div class="col-md-6 text-center">
    <a href="./controllers/employee.php" class="nav-link">
      <label for="funcionario-radio" class="botao-radio">
        <img src="./assets/image/employee-preview.png" alt="Funcionário"></br>
       
      </label >
      Registar Colaborador</a>
    </div>

    <div class="col-md-6 text-center">
    <a href="./controllers/project.php" class="nav-link">
      <label for="projeto-radio" class="botao-radio">
        <img src="./assets/image/project-preview.png" alt="Projeto"></br>
      </label>
      Registrar Projeto</a>
    </div>

    <div class="text-center content-imagem">
    <img  src="https://media.licdn.com/dms/image/C4D12AQFki-utNj2flg/article-cover_image-shrink_600_2000/0/1600197417916?e=2147483647&v=beta&t=JdUwOBDQRd7FWGZ0qq6KXC21GbDOBExvyROq1wbdcXA"/>
  </div>
  </div>
</div>

  </div>

  

  </section>
  

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>