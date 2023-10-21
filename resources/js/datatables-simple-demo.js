window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

    const datatablesSimple = document.getElementById('datatablesSimple');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple);
    }
    const usersDataTable = document.getElementById('users');
    if (usersDataTable) {
        new simpleDatatables.DataTable(usersDataTable);
    }
});
