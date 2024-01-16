// Variables globales para almacenar los valores actualizados
var updatedDate, updatedCategory, updatedDescription, updatedAmount;

async function editTransaction(id) {
    // Obtener la fila editable
    var row = document.querySelector('tr[data-id="' + id + '"]');

    // Obtener las celdas de la fila
    var cells = row.getElementsByTagName('td');

    // Convertir cada celda en un campo de texto o un elemento select
    for (var i = 0; i < 4; i++) {
        var cellValue = cells[i].innerText;

        if (i === 1) {
            // Crear un elemento select para la categoría
            var select = document.createElement('select');
            select.setAttribute('class', 'category-select');

            // Obtener las categorías de ingresos mediante AJAX de forma asíncrona
            await new Promise(function (resolve, reject) {
                $.ajax({
                    url: '../php/getIncomeCategories.php', // Asegúrate de que la URL sea correcta y accesible
                    method: 'GET',
                    success: function (response) {
                        var incomeCategories = JSON.parse(response);

                        // Llenar el select con las categorías
                        for (var j = 0; j < incomeCategories.length; j++) {
                            var option = document.createElement('option');
                            option.value = incomeCategories[j].id_category;
                            option.text = incomeCategories[j].name;
                            select.appendChild(option);
                        }

                        // Establecer el valor seleccionado
                        select.value = cellValue;

                        // Limpiar la celda y agregar el select
                        cells[i].innerHTML = '';
                        cells[i].appendChild(select);

                        // Almacenar el valor actualizado en la variable
                        updatedCategory = select.value;

                        resolve(); // Resolvemos la promesa una vez que hemos completado la operación
                    },
                    error: function (error) {
                        console.log('Error fetching income categories:', error);
                        reject(error);
                    }
                });
            });
        } else {
            // Crear un elemento input para las otras columnas
            var input = document.createElement('input');
            input.setAttribute('type', 'text');
            input.setAttribute('value', cellValue);

            // Limpiar la celda y agregar el campo de texto
            cells[i].innerHTML = '';
            cells[i].appendChild(input);

            // Almacenar el valor actualizado en la variable correspondiente
            switch (i) {
                case 0:
                    updatedDate = input.value;
                    break;
                case 2:
                    updatedDescription = input.value;
                    break;
                case 3:
                    updatedAmount = input.value;
                    break;
                // Agregar más casos según sea necesario
            }
        }
    }

    // Cambiar el botón de "Editar" a "Guardar"
    var editButton = row.querySelector('.btn-edit');
    editButton.innerText = 'Save';
    editButton.onclick = function () {
        saveTransaction(id, editButton.getAttribute('data-transaction-id'));
    };
}

function saveTransaction(id, transactionId) {
    // Resto del código...

    $.ajax({
        url: '../php/editIncomes.php',
        method: 'post',
        data: {
            newDate: updatedDate,
            newCategory: updatedCategory,
            newDescription: updatedDescription,
            newAmount: updatedAmount,
            transactionId: transactionId
        },
        success: function (response) {
            console.log(response);
        },
        error: function (error) {
            console.log('error:', error);
        }
    });

    // Resto del código...
}
