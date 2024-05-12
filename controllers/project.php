<?php

require_once '../functions/functions.php';

// Buscar os Projetos
$projects = searchProjectData();
$completedProjects = handleCompletedProjectsRequest();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["id_employees"]) && isset($_POST["descricao"]) && isset($_POST["valor"]) && isset($_POST["status"]) && isset($_POST["data_entrega"])) {
        $id_employees = $_POST["id_employees"];
        $description = $_POST["descricao"];
        $value = $_POST["valor"];
        $status = $_POST["status"];
        $delivery_date = $_POST["data_entrega"];

        if (registerProject($id_employees, $description, $value, $status, $delivery_date, $db)) {
            echo "Projeto cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar Projeto.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
<meta charset="UTF-8">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
  <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

</head>

<body>

<section>
  <h1>Cadastro de Projetos</h1>
  <form method="post">
    <label for="id_employees">ID Colaborador</label>
    <select id="id_employees" name="id_employees" required>
        <option value="">Selecione um colaborador</option>
        <?php
        $employees = searchEmployeeData();
        if ($employees !== false) {
            foreach ($employees as $employee) {
                echo "<option value='{$employee['id']}' data-employee-name='{$employee['nome']}'>{$employee['id']} - " . utf8_encode($employee['nome']) . "</option>";
            }
        }
        ?>
    </select>
    <br><br>
    <label for="descricao">Descrição</label>
    <input type="text" id="descricao" name="descricao" required><br><br>

    <label for="valor">Valor</label>
    <input type="text" id="valor" name="valor" required><br><br>

    <label for="status">Status</label>
    <input type="text" id="status" name="status" required><br><br>

    <label for="data_entrega">Data de Entrega</label>
    <input type="date" id="data_entrega" name="data_entrega" required><br><br>

    <input type="submit" value="Cadastrar Projeto">

    <button type="button" id="completed_projects_button">Projetos concluídos</button>

    <section>
        <h1>Listagem de Projetos a Entregar</h1>
        <button type="button" id="projects_to_deliver_button">Projetos a Entregar</button>
        <div id="date_input_fields" style="display: none;">
            <label for="start_date">Data Inicial:</label>
            <input type="date" id="start_date" name="start_date">
            <label for="end_date">Data Final:</label>
            <input type="date" id="end_date" name="end_date">
            <button type="button" id="fetch_projects_button">Buscar Projetos</button>
        </div>
    </section>
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
          <th>Data Atual</th>
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
            <td><?php echo isset($project['created_date']) ? $project['created_date'] : ''; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <script>
    $(document).ready(function() {

    // Criação do DataTables
    $('#tabelaProjetos').DataTable();

    $('#completed_projects_button').click(function() {
        $('#tabelaProjetos').DataTable().clear().draw();
        $('#tabelaProjetos').DataTable().rows.add(<?php echo json_encode($completedProjects['data']); ?>).draw();
    });

    $('#projects_to_deliver_button').click(function() {
        $('#date_input_fields').toggle();
    });

    $('#fetch_projects_button').click(function() {
    var startDate = $('#start_date').val();
    var endDate = $('#end_date').val();

    // Enviar uma requisição AJAX para buscar os projetos a entregar
    $.post('../functions/functions.php', {
        start_date: startDate,
        end_date: endDate
    }, function(response) {
        // Verificar se há um erro
        if (response.error) {
            alert(response.error); // Exibir mensagem de erro
        } else {
            // Limpar a tabela
            $('#tabelaProjetos').DataTable().clear().draw();
            // Adicionar os dados retornados à tabela
            $.each(response, function(key, value) {
                $.each(value.projects, function(index, project) {
                    $('#tabelaProjetos').DataTable().row.add([
                        project.id,
                        project.employee_name,
                        project.description,
                        project.value,
                        project.status,
                        project.delivery_date,
                        project.created_date
                    ]).draw();
                });
            });
        }
    }, 'json').fail(function(xhr, status, error) {
        console.error(error);
    });
});

});
  </script>
</body>
</html>
