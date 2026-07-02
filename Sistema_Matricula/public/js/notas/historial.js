window.NotasHistorial = (function() {
    let detalleActual = null;

    const escapeHtml = (window.NotasCalificaciones && typeof window.NotasCalificaciones.escapeHtml === 'function')
        ? window.NotasCalificaciones.escapeHtml
        : function(value) {
            return String(value ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        };

    function getDetalleActual() {
        return detalleActual;
    }

    function filtrarNotasPorCorte(notas, corteSeleccionado) {
        if (!corteSeleccionado) {
            return notas;
        }

        return notas.filter(function(n) {
            return String(n.cortes?.nombre ?? '').trim() === String(corteSeleccionado).trim();
        });
    }

    function construirFiltroCorteHtml(cortes, corteSeleccionado) {
        const opciones = [{ id: '', nombre: 'Todos los cortes' }].concat(cortes || []);

        return `
            <div class="form-inline mb-3">
                <label for="selectFiltroCorte" class="mr-2 small text-muted">Filtrar por corte:</label>
                <select id="selectFiltroCorte" class="form-control form-control-sm">
                    ${opciones.map(function(corte) {
                        const seleccionado = corte.nombre === corteSeleccionado ? 'selected' : '';
                        return `<option value="${corte.nombre}" ${seleccionado}>${corte.nombre}</option>`;
                    }).join('')}
                </select>
            </div>
        `;
    }

    function renderPromediosCortes(promediosCorte) {
        const { escapeHtml } = window.NotasCalificaciones;

        if (!promediosCorte || !promediosCorte.length) {
            return `
                <div class="promedios-cortes small text-muted mt-2">
                    Calcule primero los promedios por corte para las asignaturas cuantitativas.
                </div>
            `;
        }

        return `
            <div class="promedios-cortes d-flex flex-wrap mt-2">
                ${promediosCorte.map((item) => `
                    <span class="badge badge-light border mr-1 mb-1">
                        ${escapeHtml(item.corte)}: <strong>${escapeHtml(Number(item.promedio).toFixed(2))}</strong>
                    </span>
                `).join('')}
            </div>
        `;
    }

    function agruparNotasPorMateria(notas) {
        const notasPorMateria = {};

        notas.forEach(function(n) {
            // Validar que la nota tenga datos válidos
            if (!n || !n.horarios || !n.horarios.asignatura || !n.horarios.asignatura.Nombre) {
                return;
            }

            const key = n.id_horario || n.horarios.asignatura.Nombre;

            if (!notasPorMateria[key]) {
                notasPorMateria[key] = {
                    idHorario: n.id_horario,
                    nombre: n.horarios.asignatura.Nombre,
                    docente: n.horarios.docente ? n.horarios.docente.Nombre : 'Sin docente',
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
            let esCuantitativa = false;
            if (n.horarios?.asignatura?.tipo) {
                esCuantitativa = String(n.horarios.asignatura.tipo).toLowerCase() === 'cuantitativa';
            } else if (window.NotasCalificaciones && typeof window.NotasCalificaciones.esAsignaturaCuantitativa === 'function') {
                esCuantitativa = window.NotasCalificaciones.esAsignaturaCuantitativa(n.horarios?.asignatura?.Nombre || '');
            }

            let valorMostrar = '<span class="text-muted">-</span>';
            if (notaPrincipal !== null && notaPrincipal !== undefined && notaPrincipal !== '') {
                if (esCuantitativa) {
                    // Para asignaturas cuantitativas mostrar sólo el valor numérico
                    valorMostrar = escapeHtml(notaPrincipal);
                } else {
                    // Para asignaturas cualitativas mostrar solo la escala cualitativa
                    if (window.NotasCalificaciones && typeof window.NotasCalificaciones.calificacionCualitativa === 'function') {
                        const cual = window.NotasCalificaciones.calificacionCualitativa(notaPrincipal);
                        valorMostrar = cual ? `<div class="qualitative">${escapeHtml(cual)}</div>` : '<span class="text-muted">-</span>';
                    } else {
                        valorMostrar = escapeHtml(notaPrincipal);
                    }
                }
            }

            return `
                <tr>
                    <td>
                        <span class="badge badge-primary">${n.cortes.nombre}</span>
                        <br><small class="text-muted">${n.created_at}</small>
                        ${n.observacion ? `<br><small class="text-info"><i class="fas fa-comment-dots mr-1"></i>${n.observacion}</small>` : ''}
                    </td>
                    <td class="text-center">
                        <div class="h5 mb-1 ${colorPrincipal} font-weight-bold d-inline-block">${valorMostrar}</div>
                        ${n.nota_especial ? `<small class="text-muted d-block">Especial</small>` : ''}
                    </td>
                    <td class="text-right align-middle">
                        ${(() => {
                            // Por defecto mostrar el botón de eliminar para las notas mostradas,
                            // salvo que la página establezca `window.NotasIndex.allowDelete === false`.
                            const allowDelete = !(window.NotasIndex && window.NotasIndex.allowDelete === false);
                            if (allowDelete) {
                                return `
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-danger btn-delete-ajax"
                                                data-id="${n.id}" data-materia="${materia.nombre}"
                                                title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                `;
                            }

                            return '';
                        })()}
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

    function renderHistorial(data, idMatricula, corteSeleccionado) {
        const { escapeHtml, valorNota, esAsignaturaCuantitativa } = window.NotasCalificaciones;
        const config = window.NotasIndex || {};
        const notasValidas = data.notas.filter(function(n) {
            if (!n || typeof n !== 'object') return false;
            if (!n.horarios || typeof n.horarios !== 'object') return false;
            if (!n.horarios.asignatura || typeof n.horarios.asignatura !== 'object') return false;
            if (!n.horarios.asignatura.Nombre || String(n.horarios.asignatura.Nombre).trim() === '') return false;
            return true;
        });
        const notasFiltradas = filtrarNotasPorCorte(notasValidas, corteSeleccionado);
        const notasPorMateria = agruparNotasPorMateria(notasFiltradas);

        let bloquesMaterias = Object.values(notasPorMateria)
            .sort((a, b) => String(a.nombre || '').localeCompare(String(b.nombre || ''), 'es', { numeric: true }))
            .map((materia) => renderBloqueMateria(materia, idMatricula))
            .join('');

        const promedioGuardado = notasValidas.find(function(n) {
            return esAsignaturaCuantitativa(n) && Number(n.promedio) > 0;
        })?.promedio;
        const asignaturasCuantitativasConNotas = new Set();

        notasValidas.forEach(function(n) {
            const nota = valorNota(n);
            const nombreAsignatura = n.horarios.asignatura.Nombre;

            if (esAsignaturaCuantitativa(nombreAsignatura) && nota !== null && nota !== undefined && nota !== '' && !Number.isNaN(Number(nota))) {
                asignaturasCuantitativasConNotas.add(n.id_horario || nombreAsignatura);
            }
        });

        const promediosCorte = detalleActual.promediosCorte || [];
        const puedePromediarCortes = asignaturasCuantitativasConNotas.size > 0;
        const puedePromediarGeneral = promediosCorte.length > 0;
        const filtroCorteHtml = construirFiltroCorteHtml(config.cortes || [], corteSeleccionado);

        if (!bloquesMaterias) {
            bloquesMaterias = `
                <div class="text-center text-muted py-4">
                    <i class="fas fa-clipboard-list fa-2x mb-2 d-block"></i>
                    Este estudiante esta matriculado, pero aun no tiene notas registradas para el filtro seleccionado.
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
                <span class="badge ${notasFiltradas.length > 0 ? 'badge-success' : 'badge-warning'}">${notasFiltradas.length} calificaciones mostradas</span>
            </div>
            <div class="border rounded p-2 mb-3 bg-light">
                ${filtroCorteHtml}
                <div class="d-flex align-items-center flex-wrap">
                    <button type="button" class="btn btn-outline-primary btn-sm mr-2 mb-1 btn-sacar-promedios-corte" ${puedePromediarCortes ? '' : 'disabled'}>
                        <i class="fas fa-layer-group mr-1"></i>Promedios por corte
                    </button>
                    <button type="button" class="btn btn-primary btn-sm mr-2 mb-1 btn-sacar-promedio-general" ${puedePromediarGeneral ? '' : 'disabled'}>
                        <i class="fas fa-calculator mr-1"></i>Promedio general
                    </button>
                    <input type="text" class="form-control form-control-sm text-center font-weight-bold promedio-general mr-2 mb-1" style="max-width: 110px;" readonly value="${promedioGuardado !== null && promedioGuardado !== undefined ? promedioGuardado : ''}" placeholder="0.00">
                    <span class="badge estado-promedio-general ${Number(promedioGuardado) > 85 ? 'badge-success' : 'badge-secondary'}">
                        ${Number(promedioGuardado) > 85 ? 'Excelencia' : (puedePromediarGeneral ? 'Listo para promedio general' : 'Primero promedios por corte')}
                    </span>
                </div>
                ${renderPromediosCortes(promediosCorte)}
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
            url: `/notas/matricula/${idMatricula}/historial2`,
            method: 'GET',
            success: function(data) {
                const estudianteData = (data.estudiante && !Array.isArray(data.estudiante)) ? data.estudiante : null;
                detalleActual = {
                    idMatricula: idMatricula,
                    nombre: estudianteData?.nombre || nombre,
                    notas: data.notas,
                    count: data.count,
                    centro: config.nombreCentro,
                    selectedCorte: '',
                    promediosCorte: [],
                    estudiante: estudianteData || {
                        nombre: nombre,
                        codigo: '',
                        grado: '',
                        grupo: ''
                    }
                };

                $('#contenidoDetalle').html(renderHistorial(detalleActual, idMatricula, ''));
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

    function calcularPromediosCorte() {
        if (!detalleActual) {
            alert('Seleccione un estudiante antes de calcular los promedios por corte.');
            return;
        }

        const { calcularPromediosPorCorte } = window.NotasCalificaciones;
        const promediosCorte = calcularPromediosPorCorte(detalleActual.notas);

        if (!promediosCorte.length) {
            alert('Este estudiante no tiene notas cuantitativas para promediar por corte.');
            return;
        }

        detalleActual.promediosCorte = promediosCorte;
        $('#contenidoDetalle').html(renderHistorial(detalleActual, detalleActual.idMatricula, detalleActual.selectedCorte || ''));
    }

    function calcularPromedioGeneral() {
        const config = window.NotasIndex || {};
        const idMatricula = $('#panelDetalle').attr('data-matricula');
        const boton = $(this);

        if (!idMatricula) {
            alert('Seleccione un estudiante antes de calcular el promedio.');
            return;
        }

        if (!detalleActual?.promediosCorte?.length) {
            alert('Primero calcule los promedios por corte.');
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
                detalleActual.promedioGeneral = data.promedio;
                detalleActual.promediosCorte = data.promedios_cortes || detalleActual.promediosCorte || [];
                $('.estado-promedio-general')
                    .removeClass('badge-secondary badge-success')
                    .addClass(data.excelencia ? 'badge-success' : 'badge-secondary')
                    .text(data.message);
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.message || 'No se pudo calcular el promedio.');
            },
            complete: function() {
                boton.prop('disabled', false).html('<i class="fas fa-calculator mr-1"></i>Promedio general');
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

        $(document).on('change', '#selectFiltroCorte', function() {
            if (!detalleActual) {
                return;
            }

            detalleActual.selectedCorte = $(this).val() || '';
            $('#contenidoDetalle').html(renderHistorial(detalleActual, detalleActual.idMatricula, detalleActual.selectedCorte));
        });

        $(document).on('click', '.btn-sacar-promedios-corte', calcularPromediosCorte);
        $(document).on('click', '.btn-sacar-promedio-general', calcularPromedioGeneral);
    }

    return {
        init,
        cargarHistorial,
        getDetalleActual
    };
})();
