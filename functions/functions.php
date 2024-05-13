<?php

require_once '../bdd.php';

/**
 * Função Buscar Employess
 */

function searchEmployeeData()
{
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
 * Função listar EmployeeByJob
 */

 function listEmployeesByJob()
 {
   global $db;
 
   try {
     if ($db !== null) {
       // Consulta SQL para buscar os empregados e ordená-los por cargo em ordem crescente
       $sql = "SELECT name, age, job FROM employees ORDER BY job ASC";
 
       $stmt = $db->prepare($sql);
       $stmt->execute();
 
       $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
       // Retornar os dados no formato JSON
       return array('data' => $employees);
     } else {
       throw new Exception("Conexão com o banco de dados não está estabelecida.");
     }
   } catch (PDOException $e) {
     echo "Erro ao buscar empregados por cargo: " . $e->getMessage();
     return false;
   }
 }

/**
 * Função Cadastrar Employees
 */

 function registerEmployee($nome, $idade, $cargo, $salario, $data_admissao, PDO $db)
 {
     try {
         // Validação básica dos dados
         if (empty($nome) || empty($idade) || empty($cargo) || empty($salario) || empty($data_admissao)) {
             throw new Exception("Por favor, preencha todos os campos.");
         }
 
         // Prepara a consulta SQL para inserir o colaborador
         $stmt = $db->prepare("INSERT INTO employees (name, age, job, salary, admission_date) VALUES (:name, :age, :job, :salary, :admission_date)");
 
         // Vincula os valores dos parâmetros aos marcadores de posição
         $stmt->bindParam(':name', $nome);
         $stmt->bindParam(':age', $idade);
         $stmt->bindParam(':job', $cargo);
         $stmt->bindParam(':salary', $salario);
         $stmt->bindParam(':admission_date', $data_admissao);
 
         // Executa a consulta para inserir o colaborador
         $stmt->execute();
 
         // Verifica se a inserção foi bem-sucedida
         if ($stmt->rowCount() > 0) {
             return true; // Retorna true em caso de sucesso
         } else {
             return false; // Retorna false em caso de falha
         }
     } catch (PDOException $e) {
         echo "Erro ao cadastrar colaborador: " . $e->getMessage();
         return false; // Retorna false em caso de erro
     } catch (Exception $e) {
         echo "Erro: " . $e->getMessage(); // Exibe mensagem de erro de validação
         return false; // Retorna false em caso de erro de validação
     }
 }


/**
 * Função para cadastrar projetos
 */
function registerProject($id_employees, $description, $value, $status, $delivery_date, PDO $db)
{
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

function searchProjectData()
{
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
function getEmployeeById($employeeId)
{
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
function fecharConexao()
{
  global $db;
  $db = null;
}

/**
 * Função para calcular a iddade média
 */

function averageAge()
{
  global $db;

  $sql = "SELECT AVG(age) AS average_age FROM employees";
  $result = $db->query($sql);
  $row = $result->fetch(PDO::FETCH_ASSOC);
  $databaseAverageAge = $row['average_age'];

  return $databaseAverageAge;
}


// Função para buscar e formatar os projetos concluídos
function handleCompletedProjectsRequest()
{
  global $db;

  try {
    if ($db !== null) {
      // Obtém o ano corrente
      $currentYear = date('Y');

      // Consulta SQL para buscar os projetos concluídos durante o ano corrente e ordená-los por data de entrega ascendente
      $sql = "SELECT p.id, p.id_employees, e.name AS employee_name, p.description, p.value, p.status, p.delivery_date, DATE_FORMAT(p.created_date, '%Y-%m-%d') AS created_date 
                  FROM projects p
                  INNER JOIN employees e ON p.id_employees = e.id
                  WHERE p.status = 'concluido' AND YEAR(p.delivery_date) = :current_year
                  ORDER BY p.delivery_date DESC";

      $stmt = $db->prepare($sql);
      $stmt->bindParam(':current_year', $currentYear, PDO::PARAM_INT);
      $stmt->execute();

      $completedProjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

      // Verifique se há projetos concluídos e se os dados retornados não estão vazios
      if (!empty($completedProjects)) {
        // Formate os dados para o DataTables
        $data = array();

        foreach ($completedProjects as $project) {
          $data[] = array(
            $project['id'],
            $project['id_employees'],
            $project['employee_name'],
            $project['description'],
            $project['value'],
            $project['status'],
            $project['delivery_date'],
            $project['created_date']
          );
        }

        // Retorne os dados no formato JSON
        return array('data' => $data);
      } else {
        // Se não houver projetos concluídos ou os dados estiverem vazios, retorne uma mensagem de erro
        return array('error' => 'Não foi possível obter os projetos concluídos.');
      }
    } else {
      throw new Exception("Conexão com o banco de dados não está estabelecida.");
    }
  } catch (PDOException $e) {
    echo "Erro ao buscar projetos concluídos: " . $e->getMessage();
    return false;
  }
}