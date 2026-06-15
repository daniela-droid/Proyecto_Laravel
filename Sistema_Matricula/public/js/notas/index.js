$(document).ready(function() {
    window.NotasTablas.init();
    window.NotasHistorial.init();

    $(document).on('click', '.btn-reporte-grado', function() {
        window.NotasReportes.imprimirReporteGrado($(this).data('grado'));
    });
});
