'use strict';
$(function () {
    $('#deposit-table').DataTable({
        searching: false,
        dom: 'Bfrtip', // Show only the buttons
        buttons: []
    });
    $('#transfer-table').DataTable({
        searching: false,
        dom: 'Bfrtip', // Show only the buttons
        buttons: []
    });
    $('#receiver-table').DataTable({
        searching: false,
        dom: 'Bfrtip', // Show only the buttons
        buttons: []
    });
    $('#c-withdraw-table').DataTable({
        searching: false,
        dom: 'Bfrtip', // Show only the buttons
        buttons: []
    });
    $('#investment-table').DataTable({
        searching: false,
        dom: 'Bfrtip', // Show only the buttons
        buttons: []
    });
    // Initialize DataTable for Other Data if needed
});
