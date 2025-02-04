function votar(idProducto) {
    // Obtiene la valoración seleccionada por el usuario y la convierte a un número entero
    const valoracion = parseInt(document.getElementById(`select-${idProducto}`).value);

    // Verifica que el usuario haya seleccionado una valoración válida
    if (valoracion === "" || isNaN(valoracion)) {
        alert("Por favor, selecciona una valoración.");
        return;
    }

    // Envía la solicitud POST a 'votar.php' con los datos del voto usando Axios
    axios.post('../src/votar.php', {
        idProducto: idProducto,
        valoracion: valoracion
    })
    .then(function (response) {
        // Si la respuesta indica éxito, actualiza la interfaz del usuario
        if (response.data.success) {
            document.getElementById('valoracion-' + idProducto).innerHTML = response.data.estrellas; 
            document.getElementById('select-' + idProducto).disabled = true;
            alert("Voto registrado con éxito.");
        } else {
            alert(response.data.message || 'Error al registrar el voto');
        }
    })
    .catch(function (error) {
        console.error('Error:', error); 
        alert('Error al procesar el voto. Por favor, intenta de nuevo.'); 
    });
}
