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
      <div id="semestreActual" style="margin-top:10px; font-size:14px; color:#003366;"></div>
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
      <!-- Subbotón Materias -->
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

    <button class="accordion">CALENDARIO ESCOLAR</button>
    <div class="panel">
      <button>Fechas Importantes</button>
      <button>Exámenes</button>
    </div>

    <button class="accordion">CONTACTO</button>
    <div class="panel">
      <button>Soporte</button>
      <button>Administración</button>
    </div>
    
    <button class="accordion">CERRAR SESION</button>
    <div class="panel">
      <a href="../INICIO_DE_SESION/logout.php">Salir</a>
    </div>
  </div>

  <!-- Contenedor de materias y autohorario para reinscripción -->
  <div id="materias-container" style="display:none;">
    <h3>Materias para Reinscripción</h3>
    <div id="materias-list">Cargando materias...</div>
    <button id="autohorario-btn" disabled>Generar Autohorarios</button>
    <div id="combinaciones"></div>
  </div>


  <div id="semestreActual">
    <!-- Aquí se mostrará el horario guardado -->
  </div>

<script>
// Código para acordeones menú (sin cambios)
var acc = document.getElementsByClassName("accordion");
for (let i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    let panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";

      // Si es el panel SEMESTRE ACTUAL y se cierra, limpiamos el horario
      if (this.textContent.trim() === "SEMESTRE ACTUAL") {
        document.getElementById('semestreActual').innerHTML = "";
      }

    } else {
      panel.style.display = "block";
    }
  });
}

const btnMateriasReinscripcion = document.getElementById('btn-materias-reinscripcion');
const materiasContainer = document.getElementById('materias-container');
const materiasList = document.getElementById('materias-list');
const autohorarioBtn = document.getElementById('autohorario-btn');
const combinacionesDiv = document.getElementById('combinaciones');

btnMateriasReinscripcion.onclick = () => {
  if (materiasContainer.style.display === 'none' || materiasContainer.style.display === '') {
    materiasContainer.style.display = 'block';
    cargarMaterias();
  } else {
    materiasContainer.style.display = 'none';
    materiasList.innerHTML = '';
    combinacionesDiv.innerHTML = '';
  }
};

function cargarMaterias() {
  materiasList.innerHTML = "Cargando materias...";
  combinacionesDiv.innerHTML = "";
  autohorarioBtn.disabled = true;

  fetch('get_materias.php')
    .then(res => res.json())
    .then(data => {
      if (!Array.isArray(data)) data = [];

      if (data.length === 0) {
        materiasList.innerHTML = "No hay materias disponibles.";
        return;
      }

      materiasList.innerHTML = "";
      data.forEach(m => {
        const label = document.createElement('label');
        label.innerHTML = `<input type="checkbox" value="${m.id}"> 
          ${m.nombre} (Grupo ${m.grupo}) - ${m.creditos} créditos - ${m.seriada ? 'Seriada' : 'No seriada'}<br>
          <small>Horario: ${m.horario}</small>`;
        materiasList.appendChild(label);
      });

      // Habilitar autohorario solo si hay selección
      const checkboxes = materiasList.querySelectorAll('input[type=checkbox]');
      checkboxes.forEach(cb => cb.addEventListener('change', () => {
        autohorarioBtn.disabled = !Array.from(checkboxes).some(c => c.checked);
        combinacionesDiv.innerHTML = "";
      }));
    })
    .catch(() => {
      materiasList.innerHTML = "Error cargando materias.";
    });
}

// Función para parsear horarios a minutos y día
function parseHorario(h) {
  const [dia, horas] = h.split(' ');
  const [inicio, fin] = horas.split('-');
  function toMinutes(t) {
    const [hh, mm] = t.split(':').map(Number);
    return hh * 60 + mm;
  }
  return { dia, inicio: toMinutes(inicio), fin: toMinutes(fin) };
}

// Comprobar si dos horarios empalman
function empalme(h1, h2) {
  if (h1.dia !== h2.dia) return false;
  return (h1.inicio < h2.fin && h2.inicio < h1.fin);
}

// genera combinaciones sin empalmes y sin repetir materias
autohorarioBtn.onclick = () => {
  const seleccionadas = Array.from(materiasList.querySelectorAll('input[type=checkbox]:checked'))
    .map(cb => {
      // Buscar materia completa por id en la lista
      const label = cb.parentElement.innerText;

      return {
        id: cb.value,
        nombre: label.split(' (Grupo')[0],
        horario: label.match(/Horario: (.+)/)[1].trim()
      };
    });

  const resultados = [];
  function backtrack(start, comb) {
    if (comb.length >= 2) {
      resultados.push([...comb]);
      if (resultados.length >= 2) return; // Solo 2 combinaciones
    }
    for (let i = start; i < seleccionadas.length; i++) {
      const mat = seleccionadas[i];
      // Verificar si mat empalma con alguna en comb
      const matHorario = parseHorario(mat.horario);
      const choque = comb.some(m => empalme(parseHorario(m.horario), matHorario));
      if (!choque) {
        comb.push(mat);
        backtrack(i + 1, comb);
        comb.pop();
      }
      if (resultados.length >= 2) return;
    }
  }

  resultados.length = 0;
  backtrack(0, []);

  combinacionesDiv.innerHTML = "";
  if (resultados.length === 0) {
    combinacionesDiv.innerHTML = "<i>No se encontraron combinaciones sin empalmes.</i>";
    return;
  }

  resultados.forEach((combo, idx) => {
    const div = document.createElement('div');
    div.textContent = `Opción ${idx + 1}: ` + combo.map(m => m.nombre + " (" + m.horario + ")").join(", ");
    div.onclick = () => {
      guardarHorarioUsuario(combo);
      alert("Horario guardado. Puedes verlo en SEMESTRE ACTUAL > Horario.");
      combinacionesDiv.innerHTML = "";
      materiasContainer.style.display = 'none';
    };
    combinacionesDiv.appendChild(div);
  });
};

function guardarHorarioUsuario(horario) {
  const usuario = "<?php echo $_SESSION['usuario']; ?>";
  localStorage.setItem('horario_' + usuario, JSON.stringify(horario));
}

const btnHorario = document.getElementById('btn-horario');
const divHorario = document.getElementById('semestreActual');

btnHorario.addEventListener('click', () => {
  if (divHorario.innerHTML.trim() !== "") {
    divHorario.innerHTML = "";
  } else {
    mostrarHorarioGuardado();
  }
});

function mostrarHorarioGuardado() {
  const usuario = "<?php echo $_SESSION['usuario']; ?>";
  let horario = localStorage.getItem('horario_' + usuario);
  if (!horario) {
    divHorario.innerHTML = "<i>No hay horario guardado.</i>";
    return;
  }
  horario = JSON.parse(horario);
  let html = "<h4>Horario guardado para " + usuario + ":</h4><ul>";
  horario.forEach(m => {
    html += `<li>${m.nombre} - Horario: ${m.horario}</li>`;
  });
  html += "</ul>";
  divHorario.innerHTML = html;
}
</script>

</body>
</html>
