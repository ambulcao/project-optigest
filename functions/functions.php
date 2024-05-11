<?php

require_once '../bdd.php';

/**
 * Função Buscar Employess
 */

function searchEmployeeData() {
  global $db; 
  //var_dump($db);
  
  try {
      if ($db !== null) {
          $sql = 'SELECT id, name as nome, age, job, salary, admission_date FROM employees';
          $stmt = $db->query($sql);

          $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

          return $employees;
      } else {
          throw new Exception("Conexão com o banco de dados não está estabelecida.");
      }
  } catch (PDOException $e) {
      echo "Erro ao buscar funcionários: " . $e->getMessage();
      return false;
  }
}

/**
 * Função Cadastrar Employees
 */

 function registerEmployee($nome, $idade, $cargo, $salario, $dataAdmissao, PDO $db) {
    try {
      // Validação básica de dados (opcional, mas recomendado)
      if (empty($nome) || !is_numeric($idade) || empty($cargo) || !is_numeric($salario) || !strtotime($dataAdmissao)) {
        throw new Exception("Dados inválidos para cadastro de funcionário.");
      }
  
      // Prepara a consulta SQL utilizando prepared statements
      $stmt = $db->prepare("INSERT INTO employees (name, age, job, salary, admission_date) VALUES (:name, :age, :job, :salary, :admission_date)");
  
      // Vincula os valores dos parâmetros aos marcadores de posição
      $stmt->bindParam(':name', $nome);
      $stmt->bindParam(':age', $idade);
      $stmt->bindParam(':job', $cargo);
      $stmt->bindParam(':salary', $salario);
      $stmt->bindParam(':admission_date', $dataAdmissao);
  
      // Executa a consulta para inserir o funcionário
      $stmt->execute();
  
      // Verifica se a inserção foi bem-sucedida
      if ($stmt->rowCount() > 0) {
        return true; // Retorna true em caso de sucesso
      } else {
        return false; // Retorna false em caso de falha
      }
    } catch (PDOException $e) {
      echo "Erro ao cadastrar funcionário: " . $e->getMessage(); // Exibe mensagem de erro em caso de exceção
      return false; // Retorna false em caso de exceção
    } catch (Exception $e) {
      echo "Erro: " . $e->getMessage(); // Exibe mensagem de erro de validação (opcional)
      return false; // Retorna false em caso de exceção
    }
  }

/**
 * Função Buscar Projetos
 */
function buscarDadosProjetos() {
    global $db;

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
