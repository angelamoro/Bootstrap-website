$(document).ready(function () {
    $('.btn-delete').on('click', function () {
        // Obtén el ID de la transacción desde el atributo data-transaction-id
        var transactionId = $(this).data('transaction-id');

        // Confirma si realmente deseas eliminar la transacción
        if (confirm("Are you sure you want to delete this transaction?")) {
            // Realiza una solicitud AJAX para ejecutar el script PHP de eliminación
            $.ajax({
                type: 'POST',
                url: '../functionality/deleteIncome.php', // Ajusta la URL según tu estructura de archivos
                data: { transactionId: transactionId },
                success: function (response) {
                    if (response.trim() === 'success') {
                        // Eliminación exitosa, puedes realizar acciones adicionales si es necesario
                        alert("Transaction deleted successfully");
                        // Actualiza la página o realiza otras acciones según tus necesidades
                        location.reload();
                    } else {
                        // Ocurrió un error en el servidor
                        alert("Error deleting transaction");
                    }
                },
                error: function () {
                    // Error de comunicación con el servidor
                    alert("Error communicating with the server");
                }
            });
        }
    });
});