<?php

require_once '../functions/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber os parâmetros do form
    if (isset($_POST["id_employees"]) && isset($_POST["description"]) && isset($_POST["value"]) && isset($_POST["status"]) && isset($_POST["delivery_date"])) {
        // Obter os parâmetros do formulário
        $id_employees = $_POST["id_employees"];
        $descricao = $_POST["descricao"];
        $valor = $_POST["valor"];
        $status = $_POST["status"];
        $data_entrega = $_POST["data_entrega"];

        // Chamando a função como cadastro e passando a conexão como argumento
        if (registerEmployee($db, $id_employees, $idade, $cargo, $salario, $dataAdmissao)) {
            echo "Projeto cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar Projeto.";
        }
    } else {
        echo "Por favor, preencha todos os campos do formulário.";
    }
}

if (isset($_POST['completed_projects_button'])) {
    $completedProjects = getCompletedProjectsForCurrentYear();
    if ($completedProjects !== false) {
        // Processar os projetos encontrados
        foreach ($completedProjects as $project) {
            // Exibir as informações de cada projeto
            echo "ID: " . $project['id'] . ", Descrição: " . $project['description'] . ", Valor: " . $project['value'] . "<br>";
        }
    } else {
        echo "Não foi possível obter os projetos concluídos.";
    }
}

// Buscar os Projetos
$projects = searchProjectData();


?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
<meta charset="UTF-8">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

</head>

<body>

<section>
  <h1>Cadastro de Projetos</h1>
  <form method="post" >
  <label for="id_employees">ID Colaborador</label>
    <input type="text" id="id_employees" name="id_employees" required><br><br>

    <label for="descricao">Descrição</label>
    <input type="number" id="descricao" name="descricao" required><br><br>

    <label for="valor">Valor</label>
    <input type="text" id="valor" name="valor" required><br><br>

    <label for="status">Status</label>
    <input type="number" id="status" name="status" required><br><br>

    <label for="data_entrega">Data de Entrega</label>
    <input type="date" id="data_entrega" name="data_entrega" required><br><br>

    <input type="submit" value="Cadastrar Projeto">

    <form method="post">
    <button type="submit" name="completed_projects_button">Projetos concluídos</button>
</form>
  </form>
</section>

  <div class="container centralizar-pagina">
  <h1>Visualização dos Projetos</h1>


    <table id="tabelaProjetos" class="display">
      <thead>
        <tr>
          <th>ID</th>
          <th>ID Colaborador</th>
          <th>Nome Colaborador</th>
          <th>Descrição do Projeto</th>
          <th>Valor</th>
          <th>Status</th>
          <th>Data de Entrega</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($projects as $project) : ?>
          <tr>
            <td><?php echo $project['id']; ?></td>
            <td><?php echo isset($project['id_employees']) ? $project['id_employees'] : ''; ?></td>
            <td><?php echo utf8_encode($project['employee_name']); ?></td>
            <td><?php echo isset($project['description']) ? utf8_encode($project['description']) : ''; ?></td>
            <td><?php echo isset($project['value']) ? $project['value'] : ''; ?></td>
            <td><?php echo isset($project['status']) ? utf8_encode($project['status']) : ''; ?></td>
            <td><?php echo isset($project['delivery_date']) ? $project['delivery_date'] : ''; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#tabelaProjetos').DataTable();
    });
  </script>

</body>

</html>