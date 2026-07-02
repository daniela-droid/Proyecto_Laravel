window.NotasCalificaciones = (function() {
    function escapeHtml(value) {
        return String(value ?? '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    function calificacionCualitativa(nota) {
        const valor = Number(nota);

        if (Number.isNaN(valor)) {
            return '';
        }

        if (valor >= 90) {
            return 'AA';
        }

        if (valor >= 76) {
            return 'AS';
        }

        if (valor >= 60) {
            return 'AF';
        }

        return 'AI';
    }

    function notaConCualitativo(nota) {
        if (nota === null || nota === undefined || nota === '') {
            return '';
        }

        const cualitativa = calificacionCualitativa(nota);

        return `
            <span class="nota">${escapeHtml(nota)}</span>
            ${cualitativa ? `<div class="qualitative">${cualitativa}</div>` : ''}
        `;
    }

    function valorNota(nota) {
        return nota.nota_especial !== null && nota.nota_especial !== undefined && nota.nota_especial !== ''
            ? nota.nota_especial
            : nota.nota_normal;
    }

    function normalizarTexto(value) {
        return String(value || '')
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .toLowerCase();
    }

    function esAsignaturaCuantitativa(asignaturaOrNombre) {
        if (asignaturaOrNombre && typeof asignaturaOrNombre === 'object') {
            const tipo = asignaturaOrNombre?.tipo
                ?? asignaturaOrNombre?.horarios?.asignatura?.tipo
                ?? asignaturaOrNombre?.horarios?.tipo;

            if (tipo !== null && tipo !== undefined && String(tipo).trim() !== '') {
                return String(tipo).trim().toLowerCase() === 'cuantitativa';
            }

            const nombre = asignaturaOrNombre?.Nombre || asignaturaOrNombre?.nombre || '';
            return esAsignaturaCuantitativa(nombre);
        }

        const nombre = normalizarTexto(asignaturaOrNombre);
        const cuantitativas = [
            'lengua',
            'literatura',
            'matematica',
            'estudios sociales',
            'ciencias naturales',
            'ingles'
        ];

        return cuantitativas.some((termino) => nombre.includes(normalizarTexto(termino)));
    }

    function isNotaCuantitativa(nota) {
        const valor = valorNota(nota);
        return valor !== null && valor !== undefined && valor !== '' && !Number.isNaN(Number(valor));
    }
//esta funcion permite sacar el promedio por corte 
    function calcularPromediosPorCorte(notas) {
        const cortes = {};

        (notas || []).forEach((nota) => {
            const nombreAsignatura = nota.horarios?.asignatura?.Nombre;

            if (!esAsignaturaCuantitativa(nombreAsignatura) || !isNotaCuantitativa(nota)) {
                return;
            }

            const corte = nota.cortes?.nombre || 'Sin corte';

            if (!cortes[corte]) {
                cortes[corte] = [];
            }

            cortes[corte].push(Number(valorNota(nota)));
        });

        return Object.entries(cortes)
            .map(([corte, valores]) => ({
                corte,
                promedio: valores.reduce((sum, value) => sum + value, 0) / valores.length,
                cantidad: valores.length
            }))
            .sort((a, b) => String(a.corte).localeCompare(String(b.corte), 'es', { numeric: true }));
    }

    function calcularPromedioGeneralDesdeCortes(promediosCorte) {
        const valores = (promediosCorte || [])
            .map((item) => Number(item.promedio))
            .filter((valor) => !Number.isNaN(valor));

        if (!valores.length) {
            return null;
        }

        return valores.reduce((sum, value) => sum + value, 0) / valores.length;
    }

    function calcularPromedioMateria(notasMateria, nombreAsignatura = '') {
        if (!notasMateria.length) {
            return '';
        }

        const promedioGuardado = notasMateria.find((n) => n.promedio !== null && n.promedio !== undefined && n.promedio !== '');
        if (promedioGuardado) {
            const val = Number(promedioGuardado.promedio);
            if (!isNaN(val)) {
                // Si la asignatura es cuantitativa, devolver numérico con 2 decimales
                if (esAsignaturaCuantitativa(nombreAsignatura)) {
                    return val.toFixed(2);
                }

                // Para cualitativas, devolver la etiqueta cualitativa correspondiente
                return calificacionCualitativa(val);
            }
        }

        const valores = notasMateria
            .map((n) => {
                return isNotaCuantitativa(n) ? Number(valorNota(n)) : null;
            })
            .filter((v) => v !== null);

        if (!valores.length) {
            return '';
        }

        const promedio = valores.reduce((sum, value) => sum + value, 0) / valores.length;

        if (esAsignaturaCuantitativa(nombreAsignatura)) {
            return promedio.toFixed(2);
        }

        return calificacionCualitativa(promedio);
    }

    function construirTablaDetalleEstudiante(notasPorMateria) {
        const filas = Object.values(notasPorMateria).map((materia) => {
            const cortesOrdenados = materia.notas
                .slice()
                .sort((a, b) => String(a.cortes.nombre || '').localeCompare(String(b.cortes.nombre || ''), 'es', { numeric: true }));

            const celdasCortes = cortesOrdenados.map((n) => {
                const nota = valorNota(n) || '';
                return `<td class="text-center">${escapeHtml(nota)}</td>`;
            }).join('');

            const promedio = calcularPromedioMateria(cortesOrdenados, materia.nombre);
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

        if (!filas.trim()) {
            return `
                <div class="text-center text-muted py-4">
                    <i class="fas fa-clipboard-list fa-2x mb-2 d-block"></i>
                    Este estudiante aun no tiene notas registradas.
                </div>
            `;
        }

        return `
            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover mb-0">
                    <thead class="thead-light">
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
        `;
    }

    return {
        escapeHtml,
        calificacionCualitativa,
        notaConCualitativo,
        valorNota,
        esAsignaturaCuantitativa,
        isNotaCuantitativa,
        calcularPromediosPorCorte,
        calcularPromedioGeneralDesdeCortes,
        calcularPromedioMateria,
        construirTablaDetalleEstudiante
    };
})();
