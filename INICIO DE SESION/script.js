// Función para mostrar el modal
function mostrarAvisos() {
    document.getElementById('avisoModal').style.display = 'flex';
}

// Función para cerrar el modal
function cerrarModal() {
    document.getElementById('avisoModal').style.display = 'none';
}

// Detectar clics fuera del modal para cerrarlo
window.onclick = function(event) {
    if (event.target === document.getElementById('avisoModal')) {
        cerrarModal();
    }
}
