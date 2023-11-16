window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

    const initializeDataTable = (elementId) => {
        const dataTableElement = document.getElementById(elementId);
        if (dataTableElement) {
            new simpleDatatables.DataTable(dataTableElement);
        }
    };
    initializeDataTable('datatablesSimple');
    initializeDataTable('users');
    initializeDataTable('hospitals');
    initializeDataTable('patients');
    initializeDataTable('drugs');
});
