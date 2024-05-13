<?php

require_once '../functions/functions.php';

// Buscar os Projetos
$projects = searchProjectData();
$completedProjects = handleCompletedProjectsRequest();

// Verificar se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se todos os campos foram preenchidos
    if (isset($_POST["id_employees"]) && isset($_POST["descricao"]) && isset($_POST["valor"]) && isset($_POST["status"]) && isset($_POST["data_entrega"])) {
        // Obtém os valores dos campos
        $id_employees = $_POST["id_employees"];
        $descricao = $_POST["descricao"];
        $valor = $_POST["valor"];
        $status = $_POST["status"];
        $data_entrega = $_POST["data_entrega"];

        // Chama a função de cadastro de projeto passando os parâmetros corretos
        if (registerProject($id_employees, $descricao, $valor, $status, $data_entrega, $db)) {
            $success_message = "Projeto cadastrado com sucesso!";
        } else {
            $error_message = "Erro ao cadastrar Projeto.";
        }
    } else {
        $error_message = "Por favor, preencha todos os campos do formulário.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="../assets/css/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
  <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

</head>

<body>

<section class="text-center">
  <h1>Cadastro de Projetos</h1><br>
  <form method="post">
  <section class="form-section text-left">
        <div>
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
        </div>
        <br>
        <div>
            <label for="descricao">Descrição</label>
            <input type="text" id="descricao" name="descricao" required>
        </div>
        <br>
        <div>
            <label for="valor">Valor</label>
            <input type="text" id="valor" name="valor" required>
        </div>
        <br>
        <div>
            <label for="status">Status</label>
            <input type="text" id="status" name="status" required>
        </div>
        <br>
        <div>
            <label for="data_entrega">Data de Entrega</label>
            <input type="date" id="data_entrega" name="data_entrega" required>
        </div>
        <br>
        <input type="submit" class="btn btn-success" value="Cadastrar Projeto">
        <?php
        if (isset($success_message)) {
            echo "<p style='color: green;'>$success_message</p>";
        } elseif(isset($error_message) && $error_message !== "Por favor, preencha as datas inicial e final.") {
            echo "<p style='color: red;'>$error_message</p>";
        }
        ?>
    </section><br>

    

    <button type="button" class="btn btn-secondary" id="completed_projects_button">Projetos concluídos</button>

    <button type="button" id="reloadButton" class="btn btn-primary">Reload</button>

    <a href="../index.php" class="btn btn-info">Voltar a Home</a>

    <section class="text-center">
        <br><h1 class="text-center">Listagem de Projetos a Entregar</h1><br>
        <button type="button" class="btn btn-primary"id="projects_to_deliver_button">Projetos a Entregar</button>
        <div id="date_input_fields" style="display: none;">
        <br><label for="start_date">Data Inicial:</label>
            <input type="date" id="start_date" name="start_date">
            <label for="end_date">Data Final:</label>
            <input type="date" id="end_date" name="end_date">
            <button type="button" class="btn btn-secondary" id="fetch_projects_button">Buscar Projetos</button>
        </div>
    </section>
  </form>
</section class="text-center">
<section class="tblDataProject">
<div class="">
    <br><h1 class="text-center">Visualização dos Projetos</h1>

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
            <td><?php echo $project['employee_name']; ?></td>
            <td><?php echo isset($project['description']) ? $project['description'] : ''; ?></td>
            <td><?php echo isset($project['value']) ? $project['value'] : ''; ?></td>
            <td><?php echo isset($project['status']) ? $project['status'] : ''; ?></td>
            <td><?php echo isset($project['delivery_date']) ? $project['delivery_date'] : ''; ?></td>
            <td><?php echo isset($project['created_date']) ? $project['created_date'] : ''; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  </section>

  <div id="employeeTableContainer" style="margin-top: 20px; display: none;">
    <table id="novaTabelaProject" class="display">
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
            <?php foreach ($projectsToDeliver as $project) : ?>
                <tr>
                    <td><?php echo $project['id']; ?></td>
                    <td><?php echo isset($project['id_employees']) ? $project['id_employees'] : ''; ?></td>
                    <td><?php echo $project['employee_name']; ?></td>
                    <td><?php echo isset($project['description']) ? $project['description'] : ''; ?></td>
                    <td><?php echo isset($project['value']) ? $project['value'] : ''; ?></td>
                    <td><?php echo isset($project['status']) ? $project['status'] : ''; ?></td>
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

    document.getElementById("reloadButton").addEventListener("click", function() {
    location.reload();
});

    $('#projects_to_deliver_button').click(function() {
        $('#date_input_fields').toggle();
    });

    $(document).ready(function() {
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
                // Ocultar a tabela atual
                $('.tblDataProject').hide();

                // Limpar a tabela de projetos a entregar
                $('#novaTabelaProject').DataTable().clear().draw();

                // Adicionar os dados retornados à nova tabela
                $.each(response, function(key, value) {
                    $.each(value.projects, function(index, project) {
                        $('#novaTabelaProject').DataTable().row.add([
                            project.id,
                            project.id_employees,
                            project.employee_name,
                            project.description,
                            project.value,
                            project.status,
                            project.delivery_date,
                            project.created_date
                        ]).draw();
                    });
                });

                // Mostrar a nova tabela
                $('#employeeTableContainer').show();
            }
        }, 'json').fail(function(xhr, status, error) {
            console.error(error);
        });
    });
});
});
  </script>
</body>
</html>
