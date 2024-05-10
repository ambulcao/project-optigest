<?php

require_once '../functions.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar se os parâmetros do formulário foram recebidos
    if (isset($_POST["nome"]) && isset($_POST["idade"]) && isset($_POST["cargo"]) && isset($_POST["salario"]) && isset($_POST["data_admissao"])) {
        // Obter os parâmetros do formulário
        $nome = $_POST["nome"];
        $idade = $_POST["idade"];
        $cargo = $_POST["cargo"];
        $salario = $_POST["salario"];
        $dataAdmissao = $_POST["data_admissao"];

        // Chamar a função para cadastrar o funcionário, passando a conexão como argumento
        if (registerEmployee($db, $nome, $idade, $cargo, $salario, $dataAdmissao)) {
            echo "Funcionário cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar funcionário.";
        }
    } else {
        echo "Por favor, preencha todos os campos do formulário.";
    }
}

// Buscar os funcionários
$funcionarios = searchEmployeeData();

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

</head>

<body>

<section>
  <h1>Cadastro de Funcionário</h1>
  <form method="post" >
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

    <input type="submit" value="Cadastrar Funcionário">
  </form>
</section>

  <div class="container centralizar-pagina">
    <h1>Cadastro e Visualização de Funcionários</h1>

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

  <script type="text/javascript">
    $(document).ready(function() {
      $('#tabelaFuncionarios').DataTable();
    });
  </script>

</body>

</html>