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

        if (valor >= 80) {
            return 'AA';
        }

        if (valor >= 70) {
            return 'AE';
        }

        if (valor >= 60) {
            return 'AS';
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

    function calcularPromedioMateria(notasMateria) {
        if (!notasMateria.length) {
            return '';
        }

        const promedioGuardado = notasMateria.find((n) => n.promedio !== null && n.promedio !== undefined && n.promedio !== '');
        if (promedioGuardado) {
            return Number(promedioGuardado.promedio).toFixed(2);
        }

        const valores = notasMateria
            .map((n) => {
                const valor = Number(valorNota(n));
                return Number.isFinite(valor) ? valor : null;
            })
            .filter((v) => v !== null);

        if (!valores.length) {
            return '';
        }

        return (valores.reduce((sum, value) => sum + value, 0) / valores.length).toFixed(2);
    }

    function construirTablaDetalleEstudiante(notasPorMateria) {
        const filas = Object.values(notasPorMateria).map((materia) => {
            const cortesOrdenados = materia.notas
                .slice()
                .sort((a, b) => String(a.cortes.nombre || '').localeCompare(String(b.cortes.nombre || ''), 'es', { numeric: true }));

            const celdasCortes = cortesOrdenados.map((n) => {
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
        calcularPromedioMateria,
        construirTablaDetalleEstudiante
    };
})();
