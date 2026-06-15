window.NotasTablas = (function() {
    function plegarGrados() {
        $('.grade-card .collapse').collapse('hide');
        $('.grade-card [data-toggle="collapse"]').addClass('collapsed').attr('aria-expanded', 'false');
        $('.grade-card [data-toggle="collapse"] i')
            .removeClass('fa-chevron-down')
            .addClass('fa-chevron-right');
    }

    function initAccordions() {
        plegarGrados();
        window.addEventListener('pageshow', plegarGrados);

        $(document).on('show.bs.collapse', '.grade-card .collapse', function() {
            const boton = $('[data-target="#' + this.id + '"]');
            boton.find('i').removeClass('fa-chevron-right').addClass('fa-chevron-down');
        });

        $(document).on('hide.bs.collapse', '.grade-card .collapse', function() {
            const boton = $('[data-target="#' + this.id + '"]');
            boton.find('i').removeClass('fa-chevron-down').addClass('fa-chevron-right');
        });
    }

    function initGradeTables() {
        const buscador = $('#buscadorInput');
        const limpiar = $('#btnLimpiar');
        const dataTables = [];

        if (!($.fn.DataTable || $.fn.dataTable)) {
            return;
        }

        $('.tabla-grado').each(function() {
            const table = $(this).DataTable({
                pageLength: 10,
                lengthChange: false,
                info: false,
                searching: true,
                ordering: false,
                paging: true,
                dom: 'tp',
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
                }
            });
            dataTables.push({
                table,
                card: $(this).closest('.grade-card')
            });
        });

        const refreshCards = () => {
            const texto = buscador.val().toLowerCase().trim();

            dataTables.forEach(({ table, card }) => {
                table.search(texto).draw();
                const visibleRows = table.rows({ filter: 'applied' }).data().length;
                card.toggle(visibleRows > 0);
            });
        };

        buscador.on('input', refreshCards);
        limpiar.on('click', function() {
            buscador.val('');
            refreshCards();
        });

        refreshCards();
    }

    function init() {
        initAccordions();
        initGradeTables();
    }

    return {
        init,
        plegarGrados
    };
})();
