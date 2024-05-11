<?php

require_once '../bdd.php';

class Project {
  public $id;
  public $id_employee;
  public $description;
  public $value;
  public $status;
  public $delivery_date;
  
  public function __construct($id, $id_employee, $description, $value, $status, $delivery_date) {
      $this->id = $id;
      $this->id_employee = $id_employee;
      $this->description = $description;
      $this->value = $value;
      $this->status = $status;
      $this->delivery_date = $delivery_date;
  }
  
  // Getters
  public function getId() {
      return $this->id;
  }
  
  public function getIdEmployee() {
      return $this->id_employee;
  }
  
  public function getDescription() {
      return $this->description;
  }
  
  public function getValue() {
      return $this->value;
  }
  
  public function getStatus() {
      return $this->status;
  }
  
  public function getDeliveryDate() {
      return $this->delivery_date;
  }
  
  // Setters
  public function setId($id) {
      $this->id = $id;
  }
  
  public function setIdEmployee($id_employee) {
      $this->id_employee = $id_employee;
  }
  
  public function setDescription($description) {
      $this->description = $description;
  }
  
  public function setValue($value) {
      $this->value = $value;
  }
  
  public function setStatus($status) {
      $this->status = $status;
  }
  
  public function setDeliveryDate($delivery_date) {
      $this->delivery_date = $delivery_date;
  }


  public static function getCompletedProjectsForCurrentYear() {
    global $db;
  
    try {
        if ($db !== null) {
            // Obtém o ano corrente
            $currentYear = date('Y');
  
            // Consulta SQL para buscar os projetos concluídos durante o ano corrente e ordená-los por data de entrega ascendente
            $sql = "SELECT * FROM projects WHERE status = 'concluído' AND YEAR(delivery_date) = :current_year ORDER BY delivery_date ASC";
  
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':current_year', $currentYear, PDO::PARAM_INT);
            $stmt->execute();
  
            $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
            return $projects;
        } else {
            throw new Exception("Conexão com o banco de dados não está estabelecida.");
        }
    } catch (PDOException $e) {
        echo "Erro ao buscar projetos concluídos: " . $e->getMessage();
        return false;
    }
  }


  public static function handleCompletedProjectsRequest() {
    if (isset($_POST['completed_projects_button'])) {
        // Obtenha os projetos concluídos para o ano atual
        $completedProjects = self::getCompletedProjectsForCurrentYear();

        // Verifique se há projetos concluídos
        if ($completedProjects !== false) {
            // Formate os dados para o DataTables
            $data = array();
            foreach ($completedProjects as $project) {
                $data[] = array(
                    $project['id'],
                    $project['description'],
                    $project['value'],
                    $project['delivery_date']
                );
            }

            // Retorne os dados no formato JSON para o DataTables
            echo json_encode(array('data' => $data));
        } else {
            // Se não houver projetos concluídos, retorne uma mensagem de erro
            echo json_encode(array('error' => 'Não foi possível obter os projetos concluídos.'));
        }
    }
  }
}
