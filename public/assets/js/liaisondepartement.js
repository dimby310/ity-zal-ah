{
  // Mijery resaka permission
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "/consolidation-budgetaire/public/conf/permission.json", true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      let response = JSON.parse(xhr.responseText);
      let select = document.getElementById('permission');

      let option_na = document.createElement('option');
      option_na.value = response.na
      option_na.textContent = 'Ne peut rien faire'
      select.appendChild(option_na);

      let option_r = document.createElement('option');
      option_r.value = response.r
      option_r.textContent = 'Peut lire'
      select.appendChild(option_r)

      let option_rw = document.createElement('option');
      option_rw.value = response.rw
      option_rw.textContent = 'Peut lire et ecrire';
      select.appendChild(option_rw)

      console.log(response);
    }
  };
  xhr.send();
}
{
  // Manamboatra an'ilay departement
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "/consolidation-budgetaire/rest/departement/", true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      let response = JSON.parse(xhr.responseText);
      let select_source = document.getElementById('source');
      let select_destinataire = document.getElementById('destinataire');
      response['data'].forEach(element => {
        let option_source = document.createElement('option');
        let option_destinataire = document.createElement('option');

        option_source.value = element.id_departement;
        option_destinataire.value = element.id_departement;
        option_source.textContent = element.nom;
        option_destinataire.textContent = element.nom;

        select_source.appendChild(option_source);
        select_destinataire.appendChild(option_destinataire);
      });
    }
  };
  xhr.send();
}
{
  let button = document.getElementById('buttonmodif');
  let form = document.getElementById('liaisonform');
  form.addEventListener('submit', (e) => {
    e.preventDefault();
  })
  button.addEventListener('click', () => {
    let xhr = new XMLHttpRequest();
    let formData = new FormData(form);
    xhr.open("POST", "/consolidation-budgetaire/liaisondepartement/modif", true);
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        let response = JSON.parse(xhr.responseText);
        displayResult(response)
        updateTable();
      }
    };
    xhr.send(formData);
  })

  function displayResult(response) {
    const result = document.getElementById("result");
    result.textContent = response.message;
  }

  function updateTable() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "/consolidation-budgetaire/rest/liaisondepartement", true);
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        let response = JSON.parse(xhr.responseText);
        console.log(response);

        let tableBody = document.querySelector('table tbody');
        tableBody.innerHTML = ''; 

        Object.keys(response).forEach(function (source_nom) {
          let tr = document.createElement('tr');

          let tdSource = document.createElement('td');
          tdSource.textContent = source_nom;
          tr.appendChild(tdSource);

          Object.keys(response[source_nom]).forEach(function (dest_nom) {
            let td = document.createElement('td');
            td.textContent = response[source_nom][dest_nom];
            tr.appendChild(td);
          });

          tableBody.appendChild(tr);
        });
      }
    };
    xhr.send();
  }
}
