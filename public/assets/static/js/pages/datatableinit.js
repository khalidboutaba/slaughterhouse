$(document).ready(function () {
    // Show the spinners initially
    $('#loading-spinner1').show();
    $('#loading-spinner2').show();
    
    // Hide tables initially
    $('#default-table').hide();
    $('#secondary-table').hide();

    // Initialize the DataTable for the first table
    if (!$.fn.DataTable.isDataTable('#table1')) {
        let jquery_datatable1 = $("#table1").DataTable({
            responsive: true
        });

        // Hide spinner and show table once DataTable is initialized
        jquery_datatable1.on('init', function () {
            $('#loading-spinner1').hide(); // Hide the spinner
            $('#default-table').show();    // Show the table
        });
    } else {
        // If DataTable is already initialized, just show the table and hide the spinner
        $('#loading-spinner1').hide();
        $('#default-table').show();
    }

    // Initialize the DataTable for the second table
    if (!$.fn.DataTable.isDataTable('#table11')) {
        let jquery_datatable2 = $("#table11").DataTable({
            responsive: true
        });

        // Hide spinner and show table once DataTable is initialized
        jquery_datatable2.on('init', function () {
            $('#loading-spinner2').hide(); // Hide the spinner
            $('#secondary-table').show();  // Show the table
        });
    } else {
        // If DataTable is already initialized, just show the table and hide the spinner
        $('#loading-spinner2').hide();
        $('#secondary-table').show();
    }
});
