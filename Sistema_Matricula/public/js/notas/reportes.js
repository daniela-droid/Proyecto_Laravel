window.NotasReportes = (function() {
    function notasCuantitativas(notasMateria) {
        const { escapeHtml, valorNota } = window.NotasCalificaciones;

        if (!notasMateria.length) {
            return '<span class="text-muted">-</span>';
        }

        const nota = notasMateria[notasMateria.length - 1];
        const principal = valorNota(nota) ?? '';
        const especial = nota.nota_especial ? ' <span class="text-muted">(Esp.)</span>' : '';

        return `${escapeHtml(principal)}${especial}`;
    }

    function notasCualitativas(notasMateria) {
        const { escapeHtml, notaConCualitativo, valorNota } = window.NotasCalificaciones;

        if (!notasMateria.length) {
            return '<span class="text-muted">-</span>';
        }

        const nota = notasMateria[notasMateria.length - 1];
        const principal = valorNota(nota) ?? '';

        // Mostrar el valor numérico y la calificación cualitativa (ej. "85" y "AS").
        if (notaConCualitativo && typeof notaConCualitativo === 'function') {
            return notaConCualitativo(principal);
        }

        return principal !== '' ? escapeHtml(principal) : '<span class="text-muted">-</span>';
    }

    function notaReporteAsignatura(asignatura, notasMateria) {
        const { escapeHtml, calificacionCualitativa, valorNota } = window.NotasCalificaciones;

        if (!notasMateria || !notasMateria.length) {
            return '<span class="text-muted">-</span>';
        }

        const nota = notasMateria[notasMateria.length - 1];
        const valor = valorNota(nota);

        if (valor === null || valor === undefined || valor === '') {
            return '<span class="text-muted">-</span>';
        }

        if (window.NotasCalificaciones.esAsignaturaCuantitativa(asignatura)) {
            return escapeHtml(valor);
        }

        const cualitativa = calificacionCualitativa(valor);
        return escapeHtml(cualitativa || valor);
    }

    function promedioAsignaturaReporte(notasMateria) {
        if (!notasMateria || !notasMateria.length) {
            return null;
        }

        const notaConPromedio = notasMateria.find((nota) => nota.promedio !== null && nota.promedio !== undefined && nota.promedio !== '');
        if (notaConPromedio) {
            return Number(notaConPromedio.promedio);
        }

        const valores = notasMateria
            .map((nota) => {
                if (!window.NotasCalificaciones.isNotaCuantitativa(nota)) {
                    return null;
                }
                const valor = Number(window.NotasCalificaciones.valorNota(nota));
                return Number.isNaN(valor) ? null : valor;
            })
            .filter((valor) => valor !== null);

        if (!valores.length) {
            return null;
        }

        return valores.reduce((total, value) => total + value, 0) / valores.length;
    }

    function promedioGeneralReporte(fila, asignaturas, corteSeleccionado = '') {
        const { escapeHtml } = window.NotasCalificaciones;
        const promedios = asignaturas
            .filter((asignatura) => window.NotasCalificaciones.esAsignaturaCuantitativa(asignatura))
            .map((asignatura) => {
                const notasMateria = (fila.asignaturas[asignatura.key] || []).filter((n) => {
                    return !corteSeleccionado || String(n.cortes?.nombre || '').trim() === String(corteSeleccionado).trim();
                });
                return promedioAsignaturaReporte(notasMateria);
            })
            .filter((promedio) => promedio !== null);

        if (!promedios.length) {
            return '<span class="text-muted">-</span>';
        }

        const promedio = promedios.reduce((total, value) => total + value, 0) / promedios.length;

        return escapeHtml(promedio.toFixed(2));
    }

    function imprimirDocumento(titulo, contenido) {
        const { escapeHtml } = window.NotasCalificaciones;
        const ventana = window.open('', '_blank');

        if (!ventana) {
            alert('El navegador bloqueó la ventana de impresión. Permita ventanas emergentes para generar el reporte.');
            return;
        }

        ventana.document.write(`
            <!doctype html>
            <html lang="es">
            <head>
                <meta charset="utf-8">
                <title>${escapeHtml(titulo)}</title>
                <style>
                    @page { size: landscape; margin: 10mm; }
                    body { font-family: Arial, sans-serif; color: #222; margin: 18px; }
                    h1 { font-size: 22px; margin: 0 0 4px; text-transform: uppercase; }
                    h2 { font-size: 16px; margin: 16px 0 8px; color: #001f3f; }
                    .report-header { position: relative; border-bottom: 2px solid #001f3f; padding: 12px 230px 14px 0; margin-bottom: 18px; min-height: 100px; }
                    .report-logos { position: absolute; top: 0; right: 0; display: flex; align-items: flex-start; justify-content: flex-end; }
                    .report-logo { width: 220px; height: 90px; object-fit: contain; }
                    .report-title { text-align: center; line-height: 1.3; max-width: 100%; margin: 0 auto; }
                    .report-title .country { font-size: 13px; font-weight: bold; text-transform: uppercase; }
                    .report-title .ministry { font-size: 12px; text-transform: uppercase; letter-spacing: 0.04em; }
                    .report-title .school { font-size: 14px; font-weight: bold; margin-top: 8px; }
                    .report-title .document { font-size: 22px; font-weight: bold; margin-top: 10px; text-transform: uppercase; }
                    .report-subtitle { font-size: 11px; color: #444; margin-top: 6px; text-align: center; }
                    .meta { color: #333; font-size: 12px; margin-bottom: 16px; }
                    .meta strong { color: #111; }
                    .badge { display: inline-block; border: 1px solid #001f3f; color: #001f3f; padding: 4px 10px; border-radius: 12px; font-size: 11px; margin-right: 6px; margin-bottom: 4px; }
                    table { border-collapse: collapse; width: 100%; margin-bottom: 18px; font-size: 12px; }
                    th, td { border: 1px solid #999; padding: 7px 8px; vertical-align: middle; }
                    th { background: #e7eef7; text-align: center; font-weight: 600; }
                    td { text-align: center; }
                    td.left { text-align: left; }
                    .text-center { text-align: center; }
                    .text-left { text-align: left; }
                    .text-muted { color: #666; font-size: 11px; }
                    .nota { font-weight: bold; font-size: 13px; }
                    .qualitative { font-weight: bold; color: #333; }
                    .signature-block { margin-top: 28px; display: flex; justify-content: space-between; }
                    .signature-line { border-top: 1px solid #444; width: 260px; padding-top: 8px; text-align: center; font-size: 12px; color: #333; }
                    .page-break { page-break-before: always; }
                    @media print {
                        body { margin: 12mm; }
                        button { display: none; }
                        .report-logos { position: absolute; top: 0; right: 0; }
                    }
                </style>
            </head>
            <body>
                ${contenido}
                <script>
                    window.onload = function() {
                        const images = document.images;
                        let remaining = images.length;

                        if (remaining === 0) {
                            window.print();
                            return;
                        }

                        function checkPrint() {
                            remaining -= 1;
                            if (remaining <= 0) {
                                window.print();
                            }
                        }

                        for (const img of images) {
                            if (img.complete) {
                                checkPrint();
                            } else {
                                img.addEventListener('load', checkPrint);
                                img.addEventListener('error', checkPrint);
                            }
                        }
                    };
                <\/script>
            </body>
            </html>
        `);
        ventana.document.close();
    }

    function encabezadoReporte(nombreCentro, documento, extra = '', docente = '') {
        const { escapeHtml } = window.NotasCalificaciones;
        const config = window.NotasIndex || {};
        const logoUrl = config.sloganUrl || `${window.location.origin}/img/reportes/Slogan 2026.png`;

        return `
            <header class="report-header">
                <div class="report-logos">
                    <img class="report-logo" src="${encodeURI(logoUrl)}" alt="Logo" onerror="this.onerror=null;this.src='${encodeURI(window.location.origin + '/img/reportes/logo1.png')}';">
                </div>
                <div class="report-title">
                    <div class="document">${escapeHtml(documento)}</div>
                    <div class="school">${escapeHtml(nombreCentro || 'Centro educativo no especificado')}</div>
                    ${docente ? `<div class="report-subtitle"><strong>Docente:</strong> ${escapeHtml(docente)}</div>` : ''}
                    ${extra ? `<div class="report-subtitle">${escapeHtml(extra)}</div>` : ''}
                </div>
            </header>
        `;
    }

    function obtenerDocentesDetalle(detalleActual) {
        const docentes = new Set();

        detalleActual.notas.forEach(function(n) {
            const nombreDocente = n.horarios?.docente?.Nombre;
            if (nombreDocente) {
                docentes.add(nombreDocente);
            }
        });

        return Array.from(docentes).join(', ') || 'Sin docente asignado';
    }

    function imprimirDetalleEstudiante(detalleActual) {
        const { escapeHtml, calcularPromedioMateria } = window.NotasCalificaciones;

        if (!detalleActual) {
            alert('Seleccione un estudiante antes de imprimir el expediente.');
            return;
        }

        const notasPorMateria = {};
        detalleActual.notas.forEach(function(n) {
            const key = n.id_horario || n.horarios.asignatura.Nombre;
            if (!notasPorMateria[key]) {
                notasPorMateria[key] = {
                    nombre: n.horarios.asignatura.Nombre || 'Sin asignatura',
                    docente: n.horarios.docente.Nombre || 'Sin docente',
                    notas: []
                };
            }
            notasPorMateria[key].notas.push(n);
        });

        const filas = Object.values(notasPorMateria).map(function(materia) {
            const cortesOrdenados = materia.notas
                .slice()
                .sort(function(a, b) {
                    return String(a.cortes.nombre || '').localeCompare(String(b.cortes.nombre || ''), 'es', { numeric: true });
                });

            const celdasCortes = cortesOrdenados.map(function(n) {
                const valor = window.NotasCalificaciones.valorNota(n) ?? '';

                // Mostrar numérico si la asignatura es cuantitativa,
                // o el valor cualitativo si es cualitativa.
                if (window.NotasCalificaciones.esAsignaturaCuantitativa(materia.nombre)) {
                    return `<td class="text-center">${escapeHtml(valor)}</td>`;
                }

                const cual = window.NotasCalificaciones.calificacionCualitativa(valor);
                return `<td class="text-center">${escapeHtml(cual || valor)}</td>`;
            }).join('');

            const promedio = calcularPromedioMateria(cortesOrdenados, materia.nombre);
            const notasFaltantes = 4 - cortesOrdenados.length;
            const espaciosVacios = notasFaltantes > 0 ? '<td class="text-center text-muted">-</td>'.repeat(notasFaltantes) : '';

            return `
                <tr>
                    <td class="text-left">${escapeHtml(materia.nombre)}</td>
                    <td class="text-left">${escapeHtml(materia.docente)}</td>
                    ${celdasCortes}${espaciosVacios}
                    <td class="text-center font-weight-bold">${escapeHtml(promedio)}</td>
                </tr>
            `;
        }).join('');

        const docentes = obtenerDocentesDetalle(detalleActual);

        imprimirDocumento(`Expediente de ${detalleActual.estudiante.codigo || detalleActual.nombre}`, `
            ${encabezadoReporte(detalleActual.centro, `Expediente de calificaciones de ${escapeHtml(detalleActual.estudiante.nombre)}`, '', `Docente(s): ${escapeHtml(docentes)}`)}
            <div class="meta">
                Estudiante: <strong>${escapeHtml(detalleActual.estudiante.nombre)}</strong> |
                Código: <strong>${escapeHtml(detalleActual.estudiante.codigo)}</strong> |
                Grado: <strong>${escapeHtml(detalleActual.estudiante.grado)}</strong> |
                Grupo: <strong>${escapeHtml(detalleActual.estudiante.grupo)}</strong> |
                Fecha: <strong>${new Date().toLocaleDateString('es-NI')}</strong>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Materia</th>
                            <th>Docente</th>
                            <th class="text-center">Corte 1</th>
                            <th class="text-center">Corte 2</th>
                            <th class="text-center">Corte 3</th>
                            <th class="text-center">Corte 4</th>
                            <th class="text-center">Promedio</th>
                        </tr>
                    </thead>
                    <tbody>${filas}</tbody>
                </table>
            </div>
            <div class="signature-block">
                <div class="signature-line">Firma del docente</div>
                <div class="signature-line">Firma del directivo</div>
            </div>
        `);
    }

    function imprimirReporteGrado(grado, corteSeleccionado = '') {
        const { escapeHtml } = window.NotasCalificaciones;
        const config = window.NotasIndex || {};
        const reporte = config.reportesPorGrado[grado];

        if (!reporte || !reporte.filas || reporte.filas.length === 0) {
            alert('No hay datos disponibles para este grado.');
            return;
        }

        const encabezadosAsignaturas = reporte.asignaturas.map((asignatura) => `
            <th class="subject-head">${escapeHtml(asignatura.nombre)}</th>
        `).join('');

        const filas = reporte.filas.map((fila) => {
            const celdasAsignaturas = reporte.asignaturas.map((asignatura) => {
                const notasMateria = (fila.asignaturas[asignatura.key] || []).filter((n) => {
                    return !corteSeleccionado || String(n.cortes?.nombre || '').trim() === String(corteSeleccionado).trim();
                });

                return `<td class="text-center">${notaReporteAsignatura(asignatura, notasMateria)}</td>`;
            }).join('');
            const promedioGeneral = promedioGeneralReporte(fila, reporte.asignaturas, corteSeleccionado);

            return `
                <tr>
                    <td>${escapeHtml(fila.codigo)}</td>
                    <td><strong>${escapeHtml(fila.estudiante)}</strong></td>
                    ${celdasAsignaturas}
                    <td class="text-center">${promedioGeneral}</td>
                </tr>
            `;
        }).join('');

        const tituloCorte = corteSeleccionado ? `${corteSeleccionado}` : 'Todos los cortes';
        const etiquetaPromedio = corteSeleccionado ? `Promedio ${corteSeleccionado}` : 'Promedio General';

        imprimirDocumento(`Reporte de calificaciones - Grado ${grado} - ${tituloCorte}`, `
            ${encabezadoReporte(
                reporte.centro,
                'Reporte de calificaciones',
                `Grado: ${escapeHtml(reporte.grado)} | Corte: ${escapeHtml(tituloCorte)}`,
                reporte.docentes
            )}
            <div class="meta">
                Turno: <strong>${escapeHtml(reporte.turno)}</strong> |
                Modalidad: <strong>${escapeHtml(reporte.modalidades)}</strong> |
                Fecha: <strong>${new Date().toLocaleDateString('es-NI')}</strong>
            </div>
            <table>
                <thead>
                    <tr>
                        <th style="width: 90px;">Código</th>
                        <th>Nombre</th>
                        ${encabezadosAsignaturas}
                        <th class="text-center">${escapeHtml(etiquetaPromedio)}</th>
                    </tr>
                </thead>
                <tbody>${filas}</tbody>
            </table>
            <div class="signature-block">
                <div class="signature-line">Docente responsable</div>
                <div class="signature-line">Firma de dirección</div>
            </div>
        `);
    }

    return {
        imprimirDetalleEstudiante,
        imprimirReporteGrado
    };
})();
