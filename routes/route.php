<?php

/**
 * Criação das Rotas
 */



 $routes = array(
  '/' => array('file' => '../index.php', 'method' => 'GET'),
  '/employee' => array('file' => '../controllers/employee.php', 'method' => 'GET'),
  '/project' => array('file' => '../controllers/project.php', 'method' => 'GET'),
  '/allocate-employee-project' => array('file' => '../controllers/allocate-employee-project.php', 'method' => 'POST'),
);

