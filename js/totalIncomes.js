// Código JavaScript para realizar una solicitud AJAX y calcular la suma

// Hacer una solicitud AJAX al servidor para obtener los datos de la tabla
fetch('income_transactions.php') 
  .then(response => response.json())
  .then(data => {
    // Obtener los valores de 'amount' de los datos obtenidos
    const amounts = data.map(item => item.amount);

    // Calcular la suma de los valores
    const totalAmount = amounts.reduce((accumulator, currentValue) => accumulator + currentValue, 0);

    // Mostrar la suma en un recuadro HTML
    const totalAmountBox = document.getElementById('totalAmount');
    totalAmountBox.textContent = `Total Amount: ${totalAmount}`;
  })
  .catch(error => {
    console.error('Error al obtener los datos:', error);
  });
