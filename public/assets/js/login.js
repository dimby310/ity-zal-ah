var xhr = new XMLHttpRequest();
xhr.open("GET", "/consolidation-budgetaire/rest/departement/", true);
xhr.onreadystatechange = function () {
  if (xhr.readyState === 4 && xhr.status === 200) {
    var response = JSON.parse(xhr.responseText);
    response = response.data;
    console.log(response);
    var select = document.getElementById('choix-departement');

    response.forEach(element => {
      var option = document.createElement('option');
      option.value = element.id_departement;
      option.textContent = element.nom;
      select.appendChild(option)
    });
  }
};
xhr.send();
