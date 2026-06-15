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

    function esAsignaturaMatematica(nombreAsignatura) {
        return String(nombreAsignatura || '')
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .toLowerCase()
            .includes('matematica');
    }

    function notasCualitativas(notasMateria) {
        const { escapeHtml, calificacionCualitativa, valorNota } = window.NotasCalificaciones;

        if (!notasMateria.length) {
            return '<span class="text-muted">-</span>';
        }

        const nota = notasMateria[notasMateria.length - 1];
        const principal = valorNota(nota) ?? '';
        const cualitativa = calificacionCualitativa(principal);

        return cualitativa ? escapeHtml(cualitativa) : '<span class="text-muted">-</span>';
    }

    function notaReporteAsignatura(asignatura, notasMateria) {
        if (esAsignaturaMatematica(asignatura.nombre)) {
            return notasCuantitativas(notasMateria);
        }

        return notasCualitativas(notasMateria);
    }

    function promedioAsignaturaReporte(notasMateria) {
        const { valorNota } = window.NotasCalificaciones;
        const calificaciones = notasMateria
            .map((nota) => Number(valorNota(nota)))
            .filter((valor) => !Number.isNaN(valor));

        if (!calificaciones.length) {
            return null;
        }

        return calificaciones.reduce((total, nota) => total + nota, 0) / calificaciones.length;
    }

    function promedioGeneralReporte(fila, asignaturas) {
        const { escapeHtml } = window.NotasCalificaciones;
        const promedios = asignaturas
            .map((asignatura) => promedioAsignaturaReporte(fila.asignaturas[asignatura.key] || []))
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
                    body { font-family: Arial, sans-serif; color: #222; margin: 24px; }
                    h1 { font-size: 20px; margin: 0 0 4px; text-transform: uppercase; }
                    h2 { font-size: 16px; margin: 22px 0 8px; color: #001f3f; }
                    .report-header { position: relative; border-bottom: 2px solid #001f3f; padding: 8px 230px 10px 0; margin-bottom: 14px; min-height: 92px; }
                    .report-logos { position: absolute; top: 0; right: 0; display: flex; align-items: flex-start; justify-content: flex-end; }
                    .report-logo { width: 210px; height: 82px; object-fit: contain; }
                    .report-title { text-align: center; line-height: 1.3; }
                    .report-title .country { font-size: 13px; font-weight: bold; text-transform: uppercase; }
                    .report-title .ministry { font-size: 12px; text-transform: uppercase; }
                    .report-title .document { font-size: 18px; font-weight: bold; margin-top: 6px; text-transform: uppercase; }
                    .report-title .school { font-size: 14px; font-weight: bold; margin-top: 4px; }
                    .report-subtitle { font-size: 11px; color: #444; margin-top: 5px; text-align: center; }
                    .meta { color: #555; font-size: 12px; margin-bottom: 14px; }
                    .badge { display: inline-block; border: 1px solid #001f3f; color: #001f3f; padding: 3px 8px; border-radius: 10px; font-size: 11px; margin-right: 4px; }
                    table { border-collapse: collapse; width: 100%; margin-bottom: 18px; font-size: 12px; }
                    th, td { border: 1px solid #aaa; padding: 6px; vertical-align: top; }
                    th { background: #e9eef5; text-align: left; }
                    thead .subject-head { text-align: center; background: #dbe6f4; }
                    thead .sub-head { text-align: center; font-size: 11px; background: #f2f5f9; }
                    .text-center { text-align: center; }
                    .text-muted { color: #666; font-size: 11px; }
                    .nota { font-weight: bold; font-size: 13px; }
                    .qualitative { font-weight: bold; color: #333; }
                    .page-break { page-break-before: always; }
                    @media print {
                        body { margin: 12mm; }
                        button { display: none; }
                    }
                </style>
            </head>
            <body>
                ${contenido}
                <script>
                    window.onload = function() {
                        window.print();
                    };
                <\/script>
            </body>
            </html>
        `);
        ventana.document.close();
    }

    function encabezadoReporte(nombreCentro, documento, extra = '') {
        const { escapeHtml } = window.NotasCalificaciones;
        const config = window.NotasIndex || {};

        return `
            <header class="report-header">
                <div class="report-title">
                    <div class="country">República de Nicaragua</div>
                    <div class="ministry">Ministerio de Educación</div>
                    <div class="school">${escapeHtml(nombreCentro || 'Centro educativo no especificado')}</div>
                    ${extra ? `<div class="report-subtitle">${extra}</div>` : ''}
                    <div class="document">${escapeHtml(documento)}</div>
                </div>
                <div class="report-logos">
                    <img class="report-logo" src="${config.sloganUrl}" alt="Slogan 2026" onerror="this.style.visibility='hidden'">
                </div>
            </header>
        `;
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
                const nota = n.nota_especial || n.nota_normal || '';
                return `<td class="text-center">${escapeHtml(nota)}</td>`;
            }).join('');

            const promedio = calcularPromedioMateria(cortesOrdenados);
            const notasFaltantes = 4 - cortesOrdenados.length;
            const espaciosVacios = notasFaltantes > 0 ? '<td class="text-center text-muted">-</td>'.repeat(notasFaltantes) : '';

            return `
                <tr>
                    <td>${escapeHtml(materia.nombre)}</td>
                    <td>${escapeHtml(materia.docente)}</td>
                    ${celdasCortes}${espaciosVacios}
                    <td class="text-center font-weight-bold">${escapeHtml(promedio)}</td>
                </tr>
            `;
        }).join('');

        imprimirDocumento(`Expediente de ${detalleActual.estudiante.codigo || detalleActual.nombre}`, `
            ${encabezadoReporte(detalleActual.centro, 'Expediente de calificaciones')}
            <div class="meta">
                Estudiante: <strong>${escapeHtml(detalleActual.estudiante.nombre)}</strong> |
                Código: <strong>${escapeHtml(detalleActual.estudiante.codigo)}</strong> |
                Grado: <strong>${escapeHtml(detalleActual.estudiante.grado)}</strong> |
                Grupo: <strong>${escapeHtml(detalleActual.estudiante.grupo)}</strong> |
                Total de calificaciones: ${escapeHtml(detalleActual.count)} |
                Fecha: ${new Date().toLocaleDateString('es-NI')}
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
        `);
    }

    function imprimirReporteGrado(grado) {
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
                const notasMateria = fila.asignaturas[asignatura.key] || [];

                return `<td class="text-center">${notaReporteAsignatura(asignatura, notasMateria)}</td>`;
            }).join('');
            const promedioGeneral = promedioGeneralReporte(fila, reporte.asignaturas);

            return `
                <tr>
                    <td>${escapeHtml(fila.codigo)}</td>
                    <td><strong>${escapeHtml(fila.estudiante)}</strong></td>
                    ${celdasAsignaturas}
                    <td class="text-center">${promedioGeneral}</td>
                </tr>
            `;
        }).join('');

        imprimirDocumento(`Reporte de notas por grado ${grado}`, `
            ${encabezadoReporte(
                reporte.centro,
                'Reporte de notas por grado',
                `Turno: ${escapeHtml(reporte.turno)} | Modalidad: ${escapeHtml(reporte.modalidad)} | Docente: ${escapeHtml(reporte.docentes)}`
            )}
            <div class="meta">
                Grado: <strong>${escapeHtml(reporte.grado)}</strong> |
                Corte evaluativo: <strong>${escapeHtml(reporte.corte || 'Sin corte')}</strong> |
                Fecha: ${new Date().toLocaleDateString('es-NI')}
            </div>
            <table>
                <thead>
                    <tr>
                        <th style="width: 90px;">Código</th>
                        <th>Nombre</th>
                        ${encabezadosAsignaturas}
                        <th class="text-center">Promedio general</th>
                    </tr>
                </thead>
                <tbody>${filas}</tbody>
            </table>
        `);
    }

    return {
        imprimirDetalleEstudiante,
        imprimirReporteGrado
    };
})();
