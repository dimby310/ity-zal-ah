async function displayPeriodes() {
    let periodResponse = await fetchAll("periode");
    if (periodResponse.success) {
        populateSelect("choix-periode", periodResponse.data, "id_periode", "nom");
    } else {
        console.error(periodResponse.message);
    }
}

async function displayDepartements() {
    let permissionData = await fetchURL("rest/liaisondepartement/actual");
    let accessibleDepartments = [];

    if (permissionData.success) {
        accessibleDepartments = permissionData.data;
    } else {
        console.error(permissionData.message);
    }

    let departmentResponse = await fetchAll("departement");
    if (departmentResponse.success) {
        // Departements accessibles en fonction des permissions >=1
        let filteredDepartments = departmentResponse.data.filter(department =>
            accessibleDepartments.includes(department.id_departement)
        );

        populateSelect("choix-departement", filteredDepartments, "id_departement", "nom");
    } else {
        console.error(departmentResponse.message);
    }
}

displayPeriodes();
// displayDepartements();