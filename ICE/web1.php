<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../INICIO_DE_SESION/web.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

  <meta charset="UTF-8">
  <title>SCENet</title>
  <link rel="stylesheet" href="estilo-alumno.css">
  <style>
    /* Contenedor para materias y autohorario al lado del menú */
    #materias-container {
      width: 260px;
      float: left;
      margin-left: 10px;
      background: #f1f1f1;
      padding: 10px;
      border-radius: 8px;
      max-height: 600px;
      overflow-y: auto;
      box-sizing: border-box;
      font-size: 14px;
      color: #003366;
    }
    #materias-container h3 {
      text-align: center;
      margin-top: 0;
    }
    #materias-list {
      max-height: 300px;
      overflow-y: auto;
      border: 1px solid #ccc;
      padding: 5px;
      background: white;
      border-radius: 4px;
      margin-bottom: 10px;
    }
    #materias-list label {
      display: block;
      margin-bottom: 5px;
      cursor: pointer;
    }
    #autohorario-btn {
      background-color: #003366;
      color: white;
      border: none;
      padding: 10px;
      border-radius: 6px;
      width: 100%;
      cursor: pointer;
      margin-bottom: 10px;
    }
    #autohorario-btn:hover {
      background-color: #2575fc;
    }
    #combinaciones {
      max-height: 150px;
      overflow-y: auto;
      background: white;
      border-radius: 4px;
      border: 1px solid #ccc;
      padding: 5px;
    }
    #combinaciones div {
      margin-bottom: 8px;
      cursor: pointer;
      padding: 5px;
      border-radius: 4px;
    }
    #combinaciones div:hover {
      background-color: #003366;
      color: white;
    }
  </style>
</head>
<body>

  <div class="menu">
    <button class="accordion">BIENVENIDA</button>
    <div class="panel">
      <button>Mensaje del director</button>
      <button>Reglamento</button>
    </div>

    <button class="accordion">GENERALES</button>
    <div class="panel">
      <button>Datos personales</button>
      <button>Contacto</button>
    </div>

    <button class="accordion">ACADEMICOS</button>
    <div class="panel">
      <button>Kardex</button>
      <button>Historial</button>
    </div>

    <button class="accordion">SEMESTRE ACTUAL</button>
    <div class="panel">
      <button id="btn-horario">Horario</button>
      <button id="btn-materias-semestre">Materias</button>
      <div id="semestre-actual" style="margin-top:10px; font-size:14px; color:#003366;"></div>
    </div>

    <button class="accordion">GLOBALES</button>
    <div class="panel">
      <button>Promedio</button>
      <button>Créditos</button>
    </div>

    <button class="accordion">REINSCRIPCION</button>
    <div class="panel">
      <button id="btn-formulario">Formulario</button>
      <button id="btn-pagos">Pagos</button>
      <!-- Aquí agregamos el subbotón Materias -->
      <button id="btn-materias-reinscripcion">Materias</button>
    </div>

    <button class="accordion">COMUNIDAD</button>
    <div class="panel">
      <button>Eventos</button>
      <button>Foro</button>
    </div>

    <button class="accordion">SERVICIO SOCIAL</button>
    <div class="panel">
      <button>Registro</button>
      <button>Empresas</button>
    </div>

    <button class="accordion">BECAS</button>
    <div class="panel">
      <button>Convocatorias</button>
      <button>Resultados</button>
    </div>

    <button class="accordion">SERVICIOS</button>
    <div class="panel">
      <button>Biblioteca</button>
      <button>Tutorías</button>
    </div>

    <button class="accordion">CERRAR SESION</button>
    <div class="panel">
      <a href="../INICIO_DE_SESION/logout.php">Salir</a>
    </div>
  </div>

  <!-- Contenedor para mostrar materias y autohorario -->
  <div id="materias-container" style="display:none;">
    <h3>Materias para reinscripción</h3>
    <div id="materias-list">Cargando materias...</div>
    <button id="autohorario-btn">Generar Autohorarios</button>
    <div id="combinaciones"></div>
  </div>

<script>
// Manejo de acordeón sin cambios
const accordions = document.querySelectorAll(".accordion");
accordions.forEach(btn => {
  btn.addEventListener("click", () => {
    const isActive = btn.classList.contains("active");

    accordions.forEach(otherBtn => {
      otherBtn.classList.remove("active");
      const otherPanel = otherBtn.nextElementSibling;
      otherPanel.style.display = "none";
    });

    if (!isActive) {
      btn.classList.add("active");
      const panel = btn.nextElementSibling;
      panel.style.display = "flex";
    }

    // Ocultar contenedor materias si no está REINSCRIPCION
    if(btn.textContent === "REINSCRIPCION" && !isActive) {
      document.getElementById('materias-container').style.display = "block";
      cargarMaterias();
    } else {
      document.getElementById('materias-container').style.display = "none";
      document.getElementById('combinaciones').innerHTML = "";
    }
  });
});

// Función para cargar materias desde PHP
function cargarMaterias() {
  fetch('get_materias.php')
    .then(res => res.json())
    .then(data => {
      const materiasList = document.getElementById('materias-list');
      materiasList.innerHTML = "";
      data.forEach(materia => {
        const label = document.createElement('label');
        label.innerHTML = `<input type="checkbox" value="${materia.id}" data-horario="${materia.horario}" data-nombre="${materia.nombre}"> 
          ${materia.nombre} - Grupo: ${materia.grupo} - Créditos: ${materia.creditos} - Horario: ${materia.horario}`;
        materiasList.appendChild(label);
      });
    })
    .catch(() => {
      document.getElementById('materias-list').innerHTML = "Error cargando materias.";
    });
}

// Función para detectar empalmes
function hayEmpalme(horario1, horario2) {
  // Horario ejemplo: "Lunes 8:00-10:00"
  function parseHorario(h) {
    const [dia, horas] = h.split(' ');
    const [inicio, fin] = horas.split('-');
    return { dia, inicio: parseInt(inicio.replace(':','')), fin: parseInt(fin.replace(':','')) };
  }
  const h1 = parseHorario(horario1);
  const h2 = parseHorario(horario2);

  if (h1.dia !== h2.dia) return false;
  return !(h1.fin <= h2.inicio || h2.fin <= h1.inicio);
}

// Función para generar autohorarios (2 combinaciones)
function generarAutohorarios() {
  const checkboxes = [...document.querySelectorAll('#materias-list input[type=checkbox]')];
  const materias = checkboxes.filter(c => c.checked);

  if (materias.length === 0) {
    alert('Selecciona al menos una materia para generar autohorarios.');
    return;
  }

  // Filtrar materias por sus horarios y evitar empalmes y repeticiones
  // Algoritmo simple: buscaremos combinaciones de materias sin empalmes
  const combinaciones = [];
  
  function backtrack(combinacion, start) {
    if (combinacion.length > 0) {
      combinaciones.push([...combinacion]);
      if (combinaciones.length >= 2) return; // Solo 2 combinaciones
    }
    for (let i = start; i < materias.length; i++) {
      const nueva = materias[i];
      // Verificar empalmes con materias en combinacion
      let empalme = false;
      for (const mat of combinacion) {
        if (hayEmpalme(mat.dataset.horario, nueva.dataset.horario) || mat.value === nueva.value) {
          empalme = true;
          break;
        }
      }
      if (!empalme) {
        combinacion.push(nueva);
        backtrack(combinacion, i + 1);
        combinacion.pop();
      }
    }
  }
  
  backtrack([], 0);

  // Mostrar combinaciones en #combinaciones
  const contenedor = document.getElementById('combinaciones');
  contenedor.innerHTML = "";
  if (combinaciones.length === 0) {
    contenedor.innerHTML = "<i>No se encontraron combinaciones sin empalmes.</i>";
    return;
  }
  combinaciones.forEach((combo, idx) => {
    const div = document.createElement('div');
    div.textContent = `Combinación ${idx + 1}: ` + combo.map(m => m.dataset.nombre).join(', ');
    div.onclick = () => seleccionarCombinacion(combo);
    contenedor.appendChild(div);
  });
}

// Guardar selección en servidor
function seleccionarCombinacion(combo) {
  const ids = combo.map(m => m.value);
  fetch('guardar_horario.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({ materias: ids })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert('Horario guardado correctamente.');
      mostrarHorarioGuardado();
    } else {
      alert('Error guardando horario.');
    }
  });
}

// Mostrar horario guardado en Semestre Actual
function mostrarHorarioGuardado() {
  fetch('get_horario.php')
    .then(res => res.json())
    .then(data => {
      const cont = document.getElementById('semestre-actual');
      if (!data || !data.length) {
        cont.innerHTML = "<b>No tienes materias seleccionadas para este semestre.</b>";
        return;
      }
      let html = "<b>Horario Guardado:</b><br>";
      data.forEach(m => {
        html += `${m.nombre} - Grupo: ${m.grupo} - Horario: ${m.horario}<br>`;
      });
      cont.innerHTML = html;
    });
}

// Event listeners
document.getElementById('btn-materias-reinscripcion').addEventListener('click', () => {
  // Mostrar el contenedor lateral y cargar materias
  document.getElementById('materias-container').style.display = "block";
  cargarMaterias();
});

document.getElementById('autohorario-btn').addEventListener('click', generarAutohorarios);

// Mostrar horario guardado al cargar la página y en Semestre Actual
window.onload = mostrarHorarioGuardado;
</script>

</body>
</html>
