<?php

require_once 'bdd.php';
//global $db;

/**
 * Função Buscar Employess
 */

function searchEmployeeData() {
  $dbHost = "localhost";
  $dbName = "optigest"; 
  $dbUser = "root";  
  $dbPassword = ""; 

    try {
        $db = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'SELECT id, name as nome, age, job, salary, admission_date FROM employees';
        $stmt = $db->query($sql);

        $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $employees;
    } catch (PDOException $e) {
        die('Erro ao conectar ao banco de dados: ' . $e->getMessage());
    }
}


/**
 * Função Cadastrar Employees
 */



 function registerEmployee($db, $name, $age, $job, $salary, $admission_date) {
  try {
      $stmt = $db->prepare("INSERT INTO employees (name, age, job, salary, admission_date) VALUES (:name, :age, :job, :salary, :admission_date)");

      // Vincular os parâmetros da consulta aos valores fornecidos
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':age', $age); 
      $stmt->bindParam(':job', $job); 
      $stmt->bindParam(':salary', $salary); 
      $stmt->bindParam(':admission_date', $admission_date); 

      // Executar a instrução SQL para inserir o funcionário
      $stmt->execute();

      // Fechar a conexão com o banco de dados
      $db = null;

      // Verificar se a inserção foi bem-sucedida
      if ($stmt->rowCount() > 0) {
          return true; // Retornar verdadeiro se o funcionário foi inserido com sucesso
      } else {
          return false; // Retornar falso se não foi possível inserir o funcionário
      }
  } catch (PDOException $e) {
      // Em caso de erro, capturar a exceção e retornar falso
      echo "Erro ao cadastrar funcionário: " . $e->getMessage();
      return false;
  }
} 



/**
 * Função Buscar Projetos
 */


function buscarDadosProjetos() {
  $dbHost = "localhost";
  $dbName = "optigest"; 
  $dbUser = "root";  
  $dbPassword = ""; 

    try {
        $db = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'SELECT id, id_employees, description, value, status, delivery_date FROM projects';
        $stmt = $db->query($sql);

        $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $employees;
    } catch (PDOException $e) {
        die('Erro ao conectar ao banco de dados: ' . $e->getMessage());
    }
}



?>
