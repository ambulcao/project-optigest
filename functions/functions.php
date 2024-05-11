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
 * Função para cadastrar projetos
 */
function registerProject($id_employees, $description, $value, $status, $delivery_date, PDO $db) {
  try {
      // Validação básica de dados (opcional, mas recomendado)
      if (empty($id_employees) || empty($description) || empty($value) || empty($status) || empty($delivery_date)) {
          throw new Exception("Dados inválidos para cadastro de projeto.");
      }
  
      // Prepara a consulta SQL utilizando prepared statements
      $stmt = $db->prepare("INSERT INTO projects (id_employees, description, value, status, delivery_date) VALUES (:id_employees, :description, :value, :status, :delivery_date)");
  
      // Vincula os valores dos parâmetros aos marcadores de posição
      $stmt->bindParam(':id_employees', $id_employees);
      $stmt->bindParam(':description', $description);
      $stmt->bindParam(':value', $value);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':delivery_date', $delivery_date);
  
      // Executa a consulta para inserir o projeto
      $stmt->execute();
  
      // Verifica se a inserção foi bem-sucedida
      if ($stmt->rowCount() > 0) {
          return true; // Retorna true em caso de sucesso
      } else {
          return false; // Retorna false em caso de falha
      }
  } catch (PDOException $e) {
      echo "Erro ao cadastrar projeto: " . $e->getMessage(); // Exibe mensagem de erro em caso de exceção
      return false; // Retorna false em caso de exceção
  } catch (Exception $e) {
      echo "Erro: " . $e->getMessage(); // Exibe mensagem de erro de validação (opcional)
      return false; // Retorna false em caso de exceção
  }
}



/**
 * Função Buscar Projetos
 */

function searchProjectData() {
    global $db;

    try {
        $sql = 'SELECT p.id, p.id_employees, e.name AS employee_name, p.description, p.value, p.status, p.delivery_date, DATE_FORMAT(p.created_date, "%Y-%m-%d") AS created_date 
        FROM projects p
        INNER JOIN employees e ON p.id_employees = e.id';
        $stmt = $db->query($sql);

        $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $projects;
    } catch (PDOException $e) {
        
        echo "Erro ao buscar projetos: " . $e->getMessage();
        return false;
    }
}


/**
 * Função para buscar dados do funcionário pelo ID
 */
function getEmployeeById($employeeId) {
  global $db;

  try {
      $sql = 'SELECT id, name as nome FROM employees WHERE id = :id';
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':id', $employeeId);
      $stmt->execute();

      $employee = $stmt->fetch(PDO::FETCH_ASSOC);

      return $employee;
  } catch (PDOException $e) {
      echo "Erro ao buscar dados do funcionário: " . $e->getMessage();
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

/**
 * Função para calcular a iddade média
 */

function averageAge($employees) {
  $totalAge = 0;
  $count = count($employees);

  // Soma das idades de todos os funcionários
  foreach ($employees as $employee) {
      $totalAge += $employee->age;
  }

  // Calcula a média das idades
  if ($count > 0) {
      return $totalAge / $count;
  } else {
      return 0; // Retorna 0 se não houver funcionários
  }
}

/**
 * Função para simular o incremento de salário dada a uma porcentagem
 */


function simulateSalaryIncrement($employees, $incrementPercentage) {
  foreach ($employees as $employee) {
      // Calcula o novo salário incrementado para cada funcionário
      $incrementedSalary = $employee->salary * (1 + ($incrementPercentage / 100));
      // Define o novo salário para o funcionário
      $employee->salary = $incrementedSalary;
  }
  return $employees;
}


?>
