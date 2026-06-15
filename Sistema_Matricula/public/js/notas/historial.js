window.NotasHistorial = (function() {
    let detalleActual = null;

    function getDetalleActual() {
        return detalleActual;
    }

    function agruparNotasPorMateria(notas) {
        const notasPorMateria = {};

        notas.forEach(function(n) {
            const key = n.id_horario || n.horarios.asignatura.Nombre;

            if (!notasPorMateria[key]) {
                notasPorMateria[key] = {
                    idHorario: n.id_horario,
                    nombre: n.horarios.asignatura.Nombre,
                    docente: n.horarios.docente.Nombre,
                    notas: []
                };
            }

            notasPorMateria[key].notas.push(n);
        });

        return notasPorMateria;
    }

    function renderBloqueMateria(materia, idMatricula) {
        materia.notas.sort(function(a, b) {
            return String(a.cortes.nombre).localeCompare(String(b.cortes.nombre), 'es', { numeric: true });
        });

        const collapseId = `materia-${materia.idHorario}-${String(idMatricula).replace(/[^a-zA-Z0-9_-]/g, '')}`;
        const filasMateria = materia.notas.map(function(n) {
            const colorNormal = n.nota_normal < 60 ? 'text-danger' :
                n.nota_normal >= 70 ? 'text-success' : 'text-warning';
            const notaPrincipal = n.nota_especial || n.nota_normal;
            const colorPrincipal = n.nota_especial ?
                (n.nota_especial < 60 ? 'text-danger' : 'text-success') :
                colorNormal;

            return `
                <tr>
                    <td>
                        <span class="badge badge-primary">${n.cortes.nombre}</span>
                        <br><small class="text-muted">${n.created_at}</small>
                        ${n.observacion ? `<br><small class="text-info"><i class="fas fa-comment-dots mr-1"></i>${n.observacion}</small>` : ''}
                    </td>
                    <td class="text-center">
                        <div class="h5 mb-1 ${colorPrincipal} font-weight-bold">${notaPrincipal}</div>
                        ${n.nota_especial ? `<small class="text-muted">Especial</small>` : ''}
                        ${n.nota_normal !== n.nota_especial && n.nota_normal ? `<div class="small ${colorNormal}">Normal: ${n.nota_normal}</div>` : ''}
                    </td>
                    <td class="text-right align-middle">
                        <div class="btn-group btn-group-sm">
                            <a href="/notas/${n.id}/edit" class="btn btn-outline-primary" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-outline-danger btn-delete-ajax"
                                    data-id="${n.id}" data-materia="${materia.nombre}"
                                    title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');

        return `
            <div class="card border mb-3 materia-notas" data-id-horario="${materia.idHorario}">
                <div class="card-header py-2 bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="button" class="btn btn-link text-left p-0 text-decoration-none flex-grow-1" data-toggle="collapse" data-target="#${collapseId}" aria-expanded="false" aria-controls="${collapseId}">
                            <strong class="text-navy">${materia.nombre}</strong>
                            <div class="small text-muted">Docente: ${materia.docente}</div>
                        </button>
                        <div class="text-right ml-2">
                            <span class="badge badge-info">${materia.notas.length} cortes</span>
                            <div class="small text-muted mt-1">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-2">
                    <div id="${collapseId}" class="collapse">
                        <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Corte</th>
                                    <th class="text-center">Calificación</th>
                                    <th class="text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>${filasMateria}</tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    function renderHistorial(data, idMatricula) {
        const { escapeHtml, valorNota } = window.NotasCalificaciones;
        const config = window.NotasIndex || {};
        const notasPorMateria = agruparNotasPorMateria(data.notas);

        let bloquesMaterias = Object.values(notasPorMateria)
            .map((materia) => renderBloqueMateria(materia, idMatricula))
            .join('');

        const promedioGuardado = data.notas.find(function(n) {
            return Number(n.promedio) > 0;
        })?.promedio;
        const asignaturasConNotas = new Set();

        data.notas.forEach(function(n) {
            const nota = valorNota(n);

            if (nota !== null && nota !== undefined && nota !== '' && !Number.isNaN(Number(nota))) {
                asignaturasConNotas.add(n.id_horario || n.horarios.asignatura.Nombre);
            }
        });

        const puedePromediar = asignaturasConNotas.size > 0;

        if (!bloquesMaterias) {
            bloquesMaterias = `
                <div class="text-center text-muted py-4">
                    <i class="fas fa-clipboard-list fa-2x mb-2 d-block"></i>
                    Este estudiante esta matriculado, pero aun no tiene notas registradas.
                </div>
            `;
        }

        return `
            <div class="mb-3 pb-2 border-bottom">
                <h5 class="text-navy font-weight-bold mb-1">${escapeHtml(detalleActual.estudiante.nombre)}</h5>
                <div class="small text-muted">
                    Código: ${escapeHtml(detalleActual.estudiante.codigo)}<br>
                    Grado: ${escapeHtml(detalleActual.estudiante.grado)} | Grupo: ${escapeHtml(detalleActual.estudiante.grupo)}
                </div>
                <span class="badge ${data.count > 0 ? 'badge-success' : 'badge-warning'}">${data.count} calificaciones registradas</span>
            </div>
            <div class="border rounded p-2 mb-3 bg-light">
                <div class="d-flex align-items-center flex-wrap">
                    <button type="button" class="btn btn-primary btn-sm mr-2 mb-1 btn-sacar-promedio-general" ${puedePromediar ? '' : 'disabled'}>
                        <i class="fas fa-calculator mr-1"></i>Sacar promedio general
                    </button>
                    <input type="text" class="form-control form-control-sm text-center font-weight-bold promedio-general mr-2 mb-1" style="max-width: 110px;" readonly value="${promedioGuardado !== null && promedioGuardado !== undefined ? promedioGuardado : ''}" placeholder="0.00">
                    <span class="badge estado-promedio-general ${Number(promedioGuardado) > 85 ? 'badge-success' : 'badge-secondary'}">
                        ${Number(promedioGuardado) > 85 ? 'Excelencia' : (puedePromediar ? 'Listo para calcular' : 'Faltan notas')}
                    </span>
                </div>
            </div>
            ${bloquesMaterias}
            <div class="mt-3 text-right">
                <a href="${config.notasCreateUrl}" class="btn btn-primary btn-sm mr-1">
                    <i class="fas fa-plus-circle mr-1"></i>Agregar notas
                </a>
                <button type="button" id="btnImprimirDetalle" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-print mr-1"></i>Imprimir expediente
                </button>
            </div>
        `;
    }

    function cargarHistorial(idMatricula, nombre) {
        const { escapeHtml } = window.NotasCalificaciones;
        const config = window.NotasIndex || {};

        $('#contenidoDetalle').html(`
            <div class="text-center py-4">
                <i class="fas fa-spinner fa-spin fa-2x text-primary mb-2"></i>
                <p>Cargando historial de ${escapeHtml(nombre)}...</p>
            </div>
        `);

        $.ajax({
            url: `/notas/matricula/${idMatricula}/historial`,
            method: 'GET',
            success: function(data) {
                detalleActual = {
                    nombre: data.estudiante?.nombre || nombre,
                    notas: data.notas,
                    count: data.count,
                    centro: config.nombreCentro,
                    estudiante: data.estudiante || {
                        nombre: nombre,
                        codigo: '',
                        grado: '',
                        grupo: ''
                    }
                };

                $('#contenidoDetalle').html(renderHistorial(data, idMatricula));
            },
            error: function(xhr) {
                $('#contenidoDetalle').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Error: ${xhr.status} - ${xhr.statusText}
                    </div>
                `);
            }
        });
    }

    function calcularPromedioGeneral() {
        const config = window.NotasIndex || {};
        const idMatricula = $('#panelDetalle').attr('data-matricula');
        const boton = $(this);

        if (!idMatricula) {
            alert('Seleccione un estudiante antes de calcular el promedio.');
            return;
        }

        boton.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i>Calculando');

        $.ajax({
            url: `/notas/matricula/${idMatricula}/promedio`,
            method: 'POST',
            data: {
                _token: config.csrfToken
            },
            success: function(data) {
                $('.promedio-general').val(data.promedio);
                $('.estado-promedio-general')
                    .removeClass('badge-secondary badge-success')
                    .addClass(data.excelencia ? 'badge-success' : 'badge-secondary')
                    .text(data.message);
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.message || 'No se pudo calcular el promedio.');
            },
            complete: function() {
                boton.prop('disabled', false).html('<i class="fas fa-calculator mr-1"></i>Sacar promedio general');
            }
        });
    }

    function init() {
        $(document).on('click', '#btnImprimirDetalle', function() {
            window.NotasReportes.imprimirDetalleEstudiante(detalleActual);
        });

        $(document).on('click', '.btn-ver-detalles', function() {
            const nombre = $(this).data('nombre');
            const idMatricula = $(this).data('id-matricula');
            $('#panelDetalle').attr('data-matricula', idMatricula);
            cargarHistorial(idMatricula, nombre);
        });

        $(document).on('click', '.btn-delete-ajax', function() {
            const notaId = $(this).data('id');
            $('#modalDelete-' + notaId).modal('show');
        });

        $(document).on('click', '.btn-sacar-promedio-general', calcularPromedioGeneral);
    }

    return {
        init,
        cargarHistorial,
        getDetalleActual
    };
})();
