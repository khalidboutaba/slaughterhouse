$(document).ready(function () {
    // Initialize DataTable only if it's not already initialized
    if (!$.fn.DataTable.isDataTable('#table1')) {
        let jquery_datatable = $("#table1").DataTable({
            responsive: true,
            order: [], // Disable default sorting
        });

        let jquery_datatable1 = $("#table11").DataTable({
            responsive: true,
            order: [], // Disable default sorting
        });

        let customized_datatable = $("#table2").DataTable({
            responsive: true,
            pagingType: 'simple',
            order: [], // Disable default sorting
            dom:
                "<'row'<'col-3'l><'col-9'f>>" +
                "<'row dt-row'<'col-sm-12'tr>>" +
                "<'row'<'col-4'i><'col-8'p>>",
            "language": {
                "info": "صفحة _PAGE_ من _PAGES_",
                "lengthMenu": "_MENU_ ",
                "search": "",
                "searchPlaceholder": "بحث.."
            }
        });

        const setTableColor = () => {
            document.querySelectorAll('.dataTables_paginate .pagination').forEach(dt => {
                dt.classList.add('pagination-primary');
            });
        }

        setTableColor();
        jquery_datatable.on('draw', setTableColor);
        jquery_datatable1.on('draw', setTableColor);
        customized_datatable.on('draw', setTableColor);
    }
});
