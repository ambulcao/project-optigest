<?php

require_once 'bdd.php';

/**
 * Função Buscar Employess
 */

function searchEmployeeData() {
  global $db; // Importante para usar a conexão definida em bdd.php

  try {
      // Verificar se a conexão está estabelecida
      if ($db !== null) {
          $sql = 'SELECT id, name as nome, age, job, salary, admission_date FROM employees';
          $stmt = $db->query($sql);

          $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

          return $employees;
      } else {
          throw new Exception("Conexão com o banco de dados não está estabelecida.");
      }
  } catch (PDOException $e) {
      // Em caso de erro, capturar a exceção
      echo "Erro ao buscar funcionários: " . $e->getMessage();
      return false;
  }
}

/**
 * Função Cadastrar Employees
 */
function registerEmployee($name, $age, $job, $salary, $admission_date) {
  global $db; // Importante para usar a conexão definida em bdd.php

  try {
      if ($db !== null) {
          $stmt = $db->prepare("INSERT INTO employees (name, age, job, salary, admission_date) VALUES (:name, :age, :job, :salary, :admission_date)");

          // Vincular os parâmetros da consulta aos valores fornecidos
          $stmt->bindParam(':name', $name);
          $stmt->bindParam(':age', $age); 
          $stmt->bindParam(':job', $job); 
          $stmt->bindParam(':salary', $salary); 
          $stmt->bindParam(':admission_date', $admission_date); 

          // Executar a instrução SQL para inserir o funcionário
          $stmt->execute();

          // Verificar se a inserção foi bem-sucedida
          if ($stmt->rowCount() > 0) {
              return true; 
          } else {
              return false; 
          }
      } else {
          throw new Exception("Conexão com o banco de dados não está estabelecida.");
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
    global $db; // Importante para usar a conexão definida em bdd.php

    try {
        $sql = 'SELECT id, id_employees, description, value, status, delivery_date FROM projects';
        $stmt = $db->query($sql);

        $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $employees;
    } catch (PDOException $e) {
        
        echo "Erro ao buscar projetos: " . $e->getMessage();
        return false;
    }
}

/**
 * Função para fechar a conexão com o banco de dados
 */
function fecharConexao() {
    global $db; 
    $db = null;
}

?>
