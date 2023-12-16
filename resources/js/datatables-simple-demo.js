window.addEventListener('DOMContentLoaded', event => {
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
    initializeDataTable('consultations');
    initializeDataTable('prescriptions');
    initializeDataTable('pharmacies');
    initializeDataTable('stocks');
    initializeDataTable('dispensary');
    initializeDataTable('prescriptions_global');
});
