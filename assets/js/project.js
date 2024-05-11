$(document).ready(function() {
    $('#tabelaProjetos').DataTable();
});


// Adicionar evento para selecionar o nome do colaborador ao selecionar o ID
$(document).ready(function() {
    $('#id_employees').change(function() {
        var employeeId = $(this).val();
        // Requisição AJAX para buscar o nome do colaborador
        $.ajax({
            url: '../../functions/functions.php', // Arquivo PHP para buscar o nome do colaborador
            type: 'POST',
            data: { employee_id: employeeId },
            success: function(response) {
                $('#employee_name').val(response);
            }
        });
    });
});


$(document).ready(function() {
    $('#completed_projects_button').click(function() {
        $.ajax({
            url: '../../class/class-project.php',
            type: 'POST',
            data: { completed_projects_button: true },
            success: function(response) {
                // Limpar a tabela
                $('#tabelaProjetos').DataTable().clear().draw();
                // Adicionar os dados retornados à tabela
                $('#tabelaProjetos').DataTable().rows.add(response.data).draw();
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
});