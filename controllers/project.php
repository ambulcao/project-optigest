<?php

require_once '../functions/functions.php';


// Buscar os Projetos
$projects = searchProjectData();
$completedProjects = handleCompletedProjectsRequest();
//var_dump("Dados retornados da função handle: ", $completedProjects);



// Dados para cadastro do projeto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber os parâmetros do form
    if (isset($_POST["id_employees"]) && isset($_POST["descricao"]) && isset($_POST["valor"]) && isset($_POST["status"]) && isset($_POST["data_entrega"])) {
        // Obter os parâmetros do formulário
        $id_employees = $_POST["id_employees"];
        $description = $_POST["descricao"];
        $value = $_POST["valor"];
        $status = $_POST["status"];
        $delivery_date = $_POST["data_entrega"];

        // Chamando a função de cadastro e passando a conexão como argumento
        if (registerProject($id_employees, $description, $value, $status, $delivery_date, $db)) {
            echo "Projeto cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar Projeto.";
        }
    } else {
       // echo "Por favor, preencha todos os campos do formulário.";
    }
}

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
    <!--<input type="text" id="id_employees" name="id_employees" required><br><br>-->
    <select id="id_employees" name="id_employees" required>
        <option value="">Selecione um colaborador</option>
        <?php
        // Buscar os dados dos funcionários
        $employees = searchEmployeeData();
        // Verificar se a busca foi bem-sucedida
        if ($employees !== false) {
            // Iterar sobre os funcionários e exibir as opções do select
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
    $('#tabelaProjetos').DataTable();

    $('#completed_projects_button').click(function() {
        // Limpar a tabela
        $('#tabelaProjetos').DataTable().clear().draw();

        // Adicionar os dados diretamente da variável PHP à tabela DataTables
        var completedProjectsData = <?php echo json_encode($completedProjects['data']); ?>;
        $('#tabelaProjetos').DataTable().rows.add(completedProjectsData).draw();

        // Exibir a variável no console
        console.log(completedProjectsData);
    });

});
  </script>
</body>
</html>