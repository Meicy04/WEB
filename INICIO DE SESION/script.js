
function mostrarAvisos() {
    document.getElementById('avisoModal').style.display = 'flex';
}

function cerrarModal() {
    document.getElementById('avisoModal').style.display = 'none';
}

window.onclick = function(event) {
    if (event.target === document.getElementById('avisoModal')) {
        cerrarModal();
    }
}
