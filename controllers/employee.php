<?php

require_once '../functions/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Receber os parâmetros do form
  if (isset($_POST["nome"]) && isset($_POST["idade"]) && isset($_POST["cargo"]) && isset($_POST["salario"]) && isset($_POST["data_admissao"])) {
    // Obter os parâmetros do formulário
    $nome = $_POST["nome"];
    $idade = $_POST["idade"];
    $cargo = $_POST["cargo"];
    $salario = $_POST["salario"];
    $dataAdmissao = $_POST["data_admissao"];

    // Chamando a função como cadastro e passando a conexão como argumento
    if (registerEmployee($db, $nome, $idade, $cargo, $salario, $dataAdmissao)) {
      echo "Empregado cadastrado com sucesso!";
    } else {
      echo "Erro ao cadastrar Empregado.";
    }
  } else {
    echo "Por favor, preencha todos os campos do formulário.";
  }
}

// Buscar os funcionários
$funcionarios = searchEmployeeData();
$averageAge = averageAge();
$employeesJob = listEmployeesByJob();

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

<section class="text-center">
    <h1>Cadastro de Colaborador</h1>
    <form method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="idade">Idade:</label>
        <input type="number" id="idade" name="idade" required><br><br>

        <label for="cargo">Cargo:</label>
        <input type="text" id="cargo" name="cargo" required><br><br>

        <label for="salario">Salário:</label>
        <input type="number" id="salario" name="salario" required><br><br>

        <label for="data_admissao">Data de Admissão:</label>
        <input type="date" id="data_admissao" name="data_admissao" required><br><br>

        <div class="btn-group" role="group" aria-label="Botões de Ação">
    <div class="mt-3 mb-3" style="margin-right: 0.4rem;">
        <input type="submit" class="btn btn-success" value="Cadastrar Colaborador">
    </div>
    <div class="mt-3 mb-3" style="margin-right: 0.4rem;">
        <button type="button" id="averageAgeButton" class="btn btn-secondary">Idade/Média Colaborador</button>
    </div>
    <div class="mt-3 mb-3" style="margin-right: 0.4rem;">
        <button type="button" id="listEmployeeJob" class="btn btn-secondary">Listar Funções</button>
    </div>

    <section>
    <div class="mt-3 mb-3" role="group" aria-label="Botões de Ação" style="margin-right: 0.4rem;">
        <!-- Botão para revelar os campos de entrada -->
        <button type="button" id="calculateButton" class="btn btn-secondary">Calcular</button>
    </div>

    <div id="inputFields" style="display: none; width: 100%">
        <div>
            <div>
                <input type="text" id="salario"  class="form-control" placeholder="Salário" required>
            </div>
            <div style="display: flex;">
                <input type="text" id="porcentagem"  class="form-control" placeholder="Porcentagem" required>
                <button type="button" id="calculateResult" class="btn btn-secondary ml-2">=</button>
            </div>
        </div>

        <div>
            <span id="resultado"></span>
        </div>
    </div>
</section>



    <div class="mt-3 mb-3" style="margin-right: 0.4rem;">
        <button type="button" id="reloadButton" class="btn btn-primary">Reload</button>
    </div>
    <div class="mt-3 mb-3" style="margin-right: 0.4rem;">
        <a href="../index.php" class="btn btn-info">Voltar a Home</a>
    </div>
</div>


        <div class="text-center mb-2">
            <span id="averageAge" style="display: none; font-size: 40px; color: red; font-weight: bold; margin-right: 10rem;"><?php echo number_format($averageAge, 1); ?></span>
        </div>
    </form>
</section>

<section class="Datatbl">
  <div class="container centralizar-pagina">
    <h1 class="text-center">Visualização de Colaboradores</h1>

    <table id="tabelaFuncionarios" class="display">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Age</th>
          <th>Job</th>
          <th>Salary</th>
          <th>Admission Date</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($funcionarios as $funcionario) : ?>
          <tr>
            <td><?php echo $funcionario['id']; ?></td>
            <td><?php echo isset($funcionario['nome']) ? $funcionario['nome'] : ''; ?></td>
            <td><?php echo isset($funcionario['age']) ? $funcionario['age'] : ''; ?></td>
            <td><?php echo isset($funcionario['job']) ? $funcionario['job'] : ''; ?></td>
            <td><?php echo isset($funcionario['salary']) ? $funcionario['salary'] : ''; ?></td>
            <td><?php echo isset($funcionario['admission_date']) ? $funcionario['admission_date'] : ''; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>

<div id="employeeTableContainer" style="margin-top: 20px; display: none;">
    <table id="novaTabelaFuncionarios" class="display">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Idade</th>
          <th>Cargo</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Verifique se há dados retornados
        if (!empty($employeesJob['data'])) {
            // Itere sobre os dados e crie as linhas da tabela
            foreach ($employeesJob['data'] as $funcionario) {
                echo '<tr>';
                echo '<td>' . $funcionario['name'] . '</td>';
                echo '<td>' . $funcionario['age'] . '</td>';
                echo '<td>' . $funcionario['job'] . '</td>';
                echo '</tr>';
            }
        } else {
            // Se não houver dados, exiba uma mensagem na tabela
            echo '<tr><td colspan="3">Nenhum funcionário encontrado.</td></tr>';
        }
        ?>
      </tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
      $('#tabelaFuncionarios').DataTable();
      $('#novaTabelaFuncionarios').DataTable();
    });

    $(document).ready(function() {
    $("#averageAgeButton").click(function() {
        $("#averageAge").show();
    });
});

document.getElementById("reloadButton").addEventListener("click", function() {
    location.reload();
});

$('#listEmployeeJob').click(function() {
    $('.Datatbl').hide();
    $('#employeeTableContainer').show();
});

document.getElementById("calculateButton").addEventListener("click", function() {
    // Mostrar os campos de entrada quando o botão é clicado
    document.getElementById("inputFields").style.display = "block";
});

document.getElementById("calculateButton").addEventListener("click", function() {
    // Mostrar os campos de entrada quando o botão é clicado
    document.getElementById("inputFields").style.display = "block";
});

document.getElementById("calculateResult").addEventListener("click", function() {
    // Obter os valores dos campos de entrada
    var salario = parseFloat(document.getElementById("salario").value);
    var porcentagem = parseFloat(document.getElementById("porcentagem").value);

    // Verificar se os valores são válidos
    if (isNaN(salario) || isNaN(porcentagem) || salario <= 0 || porcentagem <= 0) {
        document.getElementById("resultado").textContent = "Erro: Valores inválidos";
    } else {
        // Calcular o novo salário
        var novoSalario = salario * (1 + (porcentagem / 100));
        document.getElementById("resultado").textContent = "=" + novoSalario.toFixed(2);
    }
});







</script>

</body>

</html>
