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
      
body::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.88);
    z-index: -1;
}

.menu {
    position: fixed;
    width: 280px;
    height: 100%;
    overflow-y: auto;
    left: 0;
    top: 0;
    background: rgba(0, 51, 102, 0.92);
    backdrop-filter: blur(8px);
    color: white;
    z-index: 1000;
    padding: 20px 0;
    box-shadow: 2px 0 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.main-content {
    margin-left: 280px;
    padding: 30px;
    background: rgba(255, 255, 255, 0.85);
    min-height: 100vh;
    border-radius: 15px 0 0 15px;
}

#semestreActual {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    margin-bottom: 25px;
}

#materias-container {
    width: 100%;
    max-width: 420px;
    float: left;
    margin-left: 15px;
    background: white;
    padding: 20px;
    border-radius: 12px;
    max-height: 600px;
    overflow-y: auto;
    box-sizing: border-box;
    font-size: 14px;
    color: #003366;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.05);
}

#materias-container h3 {
    text-align: center;
    margin-top: 0;
    color: #003366;
    font-size: 18px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}

#materias-list {
    max-height: 300px;
    overflow-y: auto;
    border: 1px solid #e0e0e0;
    padding: 15px;
    background: white;
    border-radius: 8px;
    margin-bottom: 15px;
}

#materias-list label {
    display: block;
    margin-bottom: 12px;
    cursor: pointer;
    padding: 8px;
    border-radius: 6px;
    transition: all 0.2s;
}

#materias-list label:hover {
    background-color: #f5f9ff;
}

#autohorario-btn, .btn-descarga {
    background: linear-gradient(135deg, #003366, #1a5dc7);
    color: white;
    border: none;
    padding: 12px;
    border-radius: 8px;
    width: 100%;
    cursor: pointer;
    margin-bottom: 15px;
    font-size: 14px;
    transition: all 0.3s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

#autohorario-btn:hover, .btn-descarga:hover {
    background: linear-gradient(135deg, #1a5dc7, #003366);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

#autohorario-btn:disabled {
    background: #cccccc;
    cursor: not-allowed;
    transform: none;
}

#combinaciones {
    max-height: 200px;
    overflow-y: auto;
    background: white;
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    padding: 10px;
}

#combinaciones div {
    margin-bottom: 10px;
    cursor: pointer;
    padding: 10px;
    border-radius: 6px;
    background: #f8faff;
    transition: all 0.2s;
    border-left: 3px solid #2575fc;
}

#combinaciones div:hover {
    background-color: #e6f0ff;
    transform: translateX(3px);
}

#descargas-horario {
    float: right;
    margin-right: 25px;
    width: 220px;
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    display: none;
}

#descargas-horario h3 {
    margin-top: 0;
    color: #003366;
    text-align: center;
    font-size: 16px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}

.tabla-horario {
    border-collapse: collapse;
    width: 100%;
    margin-top: 15px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.tabla-horario th, .tabla-horario td {
    border: 1px solid #e0e0e0;
    padding: 10px;
    text-align: center;
}

.tabla-horario th {
    background: linear-gradient(135deg, #003366, #1a5dc7);
    color: white;
}

.tabla-horario tr:nth-child(even) {
    background-color: #f9f9f9;
}

.tabla-horario tr:hover {
    background-color: #f5f9ff;
}

::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

.panel {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
    margin: 0 15px;
    border-radius: 0 0 8px 8px;
    background: rgba(0, 0, 0, 0.05);
}

.panel.show {
    max-height: 500px;
}

.accordion.active {
    background: rgba(37, 117, 252, 0.7);
}

#btn-salir {
    background: linear-gradient(135deg, #d9534f, #c9302c);
    color: white;
    border: none;
    padding: 12px;
    border-radius: 8px;
    width: 100%;
    cursor: pointer;
    margin: 10px 0;
    font-size: 14px;
    transition: all 0.3s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    text-align: center;
}

#btn-salir:hover {
    background: linear-gradient(135deg, #c9302c, #d9534f);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.accordion:last-child .panel {
    padding-bottom: 20px;
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
  <button id="btn-salir" onclick="window.location.href='../INICIO_DE_SESION/logout.php'">Salir</button>
</div>
  </div>

  <div class="main-content">
    <div id="semestreActual"></div>

    <div id="materias-container" style="display:none;">
      <h3>Materias para Reinscripción</h3>
      <div id="materias-list">Cargando materias...</div>
      <button id="autohorario-btn" disabled>Generar Autohorarios</button>
      <div id="combinaciones"></div>
    </div>

    <div id="descargas-horario">
      <h3>Descargar Horario</h3>
      <div id="botones-descarga"></div>
    </div>
  </div>

<script>

document.querySelectorAll('.accordion').forEach(button => {
    button.addEventListener('click', function() {

        document.querySelectorAll('.accordion').forEach(otherBtn => {
            if (otherBtn !== button) {
                otherBtn.classList.remove('active');
                otherBtn.nextElementSibling.classList.remove('show');
            }
        });

        this.classList.toggle('active');
        const panel = this.nextElementSibling;
        panel.classList.toggle('show');

        if (this.textContent.trim() === "SEMESTRE ACTUAL" && !panel.classList.contains('show')) {
            document.getElementById('semestreActual').innerHTML = "";
        }
    });
});

document.querySelectorAll('.panel button').forEach(button => {
    button.addEventListener('click', function() {
        document.querySelectorAll('.panel').forEach(panel => {
            if (panel !== this.parentElement) {
                panel.classList.remove('show');
                panel.previousElementSibling.classList.remove('active');
            }
        });
        
        document.getElementById('materias-container').style.display = 'none';
        document.getElementById('descargas-horario').style.display = 'none';
        
        if (this.id !== 'btn-horario') {
            document.getElementById('semestreActual').innerHTML = '';
        }
    });
});

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

      const checkboxes = materiasList.querySelectorAll('input[type=checkbox]');
      checkboxes.forEach(cb => cb.addEventListener('change', () => {
        const seleccionadas = Array.from(checkboxes).filter(c => c.checked);
        

        const nombresSeleccionados = seleccionadas.map(cb => {
          const label = cb.parentElement.innerText;
          return label.split(' (Grupo')[0].trim();
        });
        
        const nombresUnicos = [...new Set(nombresSeleccionados)];
        if (nombresSeleccionados.length !== nombresUnicos.length) {
          alert("No puedes seleccionar dos materias con el mismo nombre.");
          cb.checked = false;
          return;
        }
        
        autohorarioBtn.disabled = seleccionadas.length === 0;
        combinacionesDiv.innerHTML = "";
      }));
    })
    .catch(() => {
      materiasList.innerHTML = "Error cargando materias.";
    });
}

function parseHorario(h) {
  const [dia, horas] = h.split(' ');
  const [inicio, fin] = horas.split('-');
  function toMinutes(t) {
    const [hh, mm] = t.split(':').map(Number);
    return hh * 60 + mm;
  }
  return { dia, inicio: toMinutes(inicio), fin: toMinutes(fin) };
}

function empalme(h1, h2) {
  if (h1.dia !== h2.dia) return false;
  return (h1.inicio < h2.fin && h2.inicio < h1.fin);
}

autohorarioBtn.onclick = () => {
    const seleccionadas = Array.from(materiasList.querySelectorAll('input[type=checkbox]:checked'))
        .map(cb => {
            const label = cb.parentElement.innerText;
            const grupoMatch = label.match(/Grupo (\w+)/);
            const nombreMateria = label.split(' (Grupo')[0].trim();
            
            return {
                id: cb.value,
                nombre: nombreMateria,
                grupo: grupoMatch ? grupoMatch[1] : '',
                horario: label.match(/Horario: (.+)/)[1].trim(),
                creditos: label.match(/(\d+) créditos/)[1]
            };
        });
        
    const materiasSinEmpalmes = [];
    const materiasConEmpalmes = [];
    
    for (let i = 0; i < seleccionadas.length; i++) {
        let tieneEmpalme = false;
        const horario1 = parseHorario(seleccionadas[i].horario);
        
        for (let j = 0; j < seleccionadas.length; j++) {
            if (i === j) continue;
            const horario2 = parseHorario(seleccionadas[j].horario);
            if (empalme(horario1, horario2)) {
                tieneEmpalme = true;
                break;
            }
        }
        
        if (tieneEmpalme) {
            materiasConEmpalmes.push(seleccionadas[i]);
        } else {
            materiasSinEmpalmes.push(seleccionadas[i]);
        }
    }
    
    const materiasParaCombinar = materiasSinEmpalmes.length > 0 ? materiasSinEmpalmes : seleccionadas;
    
    const resultados = [];
    
    function backtrack(start, comb) {
        const tieneEmpalme = comb.some((m1, i) => {
            const horario1 = parseHorario(m1.horario);
            return comb.some((m2, j) => {
                if (i === j) return false;
                const horario2 = parseHorario(m2.horario);
                return empalme(horario1, horario2);
            });
        });
        
        if (!tieneEmpalme && comb.length > 0) {
            resultados.push([...comb]);
        }
        
        for (let i = start; i < materiasParaCombinar.length; i++) {
            comb.push(materiasParaCombinar[i]);
            backtrack(i + 1, comb);
            comb.pop();
        }
    }
    
    resultados.length = 0;
    backtrack(0, []);
    combinacionesDiv.innerHTML = "";
    
    if (resultados.length === 0) {
        combinacionesDiv.innerHTML = `
            <div style="padding: 10px; background: #fff8e1; border-radius: 6px;">
                No se encontraron combinaciones sin empalmes. Revisa los horarios.
            </div>
        `;
        return;
    }
    
    resultados.sort((a, b) => b.length - a.length);
    
    const combinacionesAMostrar = resultados.slice(0, 2);
    
    combinacionesAMostrar.forEach((combo, idx) => {
        const div = document.createElement('div');
        div.className = 'combinacion-item';
        div.innerHTML = `
            <strong>Opción ${idx + 1}:</strong><br>
            ${combo.map(m => `• ${m.nombre} (${m.horario})`).join('<br>')}
            <div style="margin-top: 5px; color: #00796b;">
                Total créditos: ${combo.reduce((sum, m) => sum + parseInt(m.creditos), 0)}
            </div>
        `;
        div.onclick = () => {
            const todasSinEmpalmes = resultados[0];
            guardarHorarioUsuario(todasSinEmpalmes);
            alert("Horario guardado exitosamente en: \nSEMESTRE ACTUAL -> HORARIO");
            combinacionesDiv.innerHTML = "";
            materiasContainer.style.display = 'none';
        };
        
        combinacionesDiv.appendChild(div);
    });
    
    if (materiasConEmpalmes.length > 0 && materiasSinEmpalmes.length > 0) {
        const advertencia = document.createElement('div');
        advertencia.style.padding = '10px';
        advertencia.style.background = '#fff3e0';
        advertencia.style.borderRadius = '6px';
        advertencia.style.marginTop = '10px';
        advertencia.innerHTML = `
            <strong>Nota:</strong> Se han ignorado ${materiasConEmpalmes.length} materias con empalmes horarios.
        `;
        combinacionesDiv.appendChild(advertencia);
    }
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
    document.getElementById('descargas-horario').style.display = 'none';
  } else {
    mostrarHorarioGuardado();
  }
});

function mostrarHorarioGuardado() {
  const usuario = "<?php echo $_SESSION['usuario']; ?>";
  let horario = localStorage.getItem('horario_' + usuario);
  const descargasDiv = document.getElementById('descargas-horario');
  
  if (!horario) {
    divHorario.innerHTML = "<i>No hay horario guardado.</i>";
    descargasDiv.style.display = 'none';
    return;
  }
  
  horario = JSON.parse(horario);
  let html = "<h4>Horario guardado:</h4><ul>";
  horario.forEach(m => {
    html += `<li>${m.nombre} - Grupo ${m.grupo} - ${m.horario}</li>`;
  });
  html += "</ul>";
  divHorario.innerHTML = html;
  
  document.getElementById('botones-descarga').innerHTML = `
    <button class="btn-descarga" onclick="generarPDF('${usuario}')">Descargar PDF</button>
    <button class="btn-descarga" onclick="mostrarTablaCompleta()">Ver Tabla Completa</button>
  `;
  descargasDiv.style.display = 'block';
}

function generarPDF(usuario) {
  const horario = JSON.parse(localStorage.getItem('horario_' + usuario));
  
  fetch('generar_pdf.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      horario: horario,
      usuario: usuario
    })
  })
  .then(response => {
    if (!response.ok) {
      throw new Error('Error en la respuesta del servidor: ' + response.status);
    }
    return response.blob();
  })
  .then(blob => {
    if (blob.size === 0) {
      throw new Error('El archivo PDF generado está vacío');
    }
    
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `horario_${usuario}.pdf`;
    document.body.appendChild(a);
    a.click();
    
    setTimeout(() => {
      document.body.removeChild(a);
      window.URL.revokeObjectURL(url);
    }, 100);
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Error al generar el PDF: ' + error.message);
  });
}

function mostrarTablaCompleta() {
  const usuario = "<?php echo $_SESSION['usuario']; ?>";
  const horario = JSON.parse(localStorage.getItem('horario_' + usuario));
  
  let html = `
    <h4>Horario Completo</h4>
    <table class="tabla-horario">
      <tr>
        <th>Materia</th>
        <th>Grupo</th>
        <th>Horario</th>
        <th>Créditos</th>
      </tr>
  `;
  
  horario.forEach(m => {
    html += `
      <tr>
        <td>${m.nombre}</td>
        <td>${m.grupo || ''}</td>
        <td>${m.horario}</td>
        <td>${m.creditos || ''}</td>
      </tr>
    `;
  });
  
  html += `</table>`;
  divHorario.innerHTML = html;
}
</script>
</body>
</html>