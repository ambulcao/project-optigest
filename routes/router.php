<?php

$routes = [
  '/employees' => '../components/employee.php',  
  '/projects' => '../components/project.php',   
  '/allocate' => '../components/allocate-employee-project.php',  
];


$requestedUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (array_key_exists($requestedUri, $routes)) {
  require $routes[$requestedUri];
  exit(); 
} else {
  echo "Page not found!";
}

