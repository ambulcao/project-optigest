<?php

require_once '../functions/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Verifica se todos os campos do formulário foram preenchidos
  if (isset($_POST["nome"]) && isset($_POST["idade"]) && isset($_POST["cargo"]) && isset($_POST["salario"]) && isset($_POST["data_admissao"])) {
      // Obtém os valores dos campos do formulário
      $nome = $_POST["nome"];
      $idade = $_POST["idade"];
      $cargo = $_POST["cargo"];
      $salario = $_POST["salario"];
      $data_admissao = $_POST["data_admissao"];

      // Chama a função de cadastro de colaborador passando os parâmetros
      if (registerEmployee($nome, $idade, $cargo, $salario, $data_admissao, $db)) {
          $success_message = "Colaborador cadastrado com sucesso!";
      } else {
          echo "<p style='color: red;'>Erro ao cadastrar Colaborador.</p>";
      }
  } else {
      echo "<p style='color: red;'>Por favor, preencha todos os campos do formulário.</p>";
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
  <link rel="stylesheet" href="../assets/css/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
  <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.7/js/inputmask.min.js"></script>

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

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($success_message)) {
            echo "<p style='color: green;'>$success_message</p>";
        }
    }
    ?>
     <div class="mt-3 mb-3" style="margin-right: 0.4rem;">
          <input type="submit" class="btn btn-success" value="Cadastrar Colaborador">
        </div>

        </form>
        <div class="btn-group" role="group" aria-label="Botões de Ação">
       
      
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
            <div style="display: flex;">
              <input type="text" id="valor"  class="form-control" placeholder="Salário">
                <input type="text" id="porcentagem"  class="form-control" placeholder="Porcentagem">
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
    
</section>

<section class="Datatbl">
  <div class="container">
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



// Função para exibir os campos de entrada quando o botão "Calcular" é clicado
document.getElementById('calculateButton').addEventListener('click', function() {
            document.getElementById('inputFields').style.display = 'block';
        });

        // Função para calcular o novo salário
        function calcularSalario() {
            // Obter os valores dos campos de entrada
            var valor = parseInt(document.getElementById('valor').value);
            var porcentagem = parseFloat(document.getElementById('porcentagem').value);

            // Calcular o novo salário
            var novoSalario = valor * (1 + (porcentagem / 100));

            // Exibir o resultado
            document.getElementById('resultado').innerText = 'Novo Salário: ' + novoSalario.toFixed(2);
        }

        // Adicionar evento de clique ao botão "="
        document.getElementById('calculateResult').addEventListener('click', calcularSalario);







</script>

</body>

</html>
