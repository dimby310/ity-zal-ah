const baseUrl = "/consolidation-budgetaire";

function fetchAll(table) {
    return new Promise((resolve, reject) => {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", `${baseUrl}/rest/${table}/`, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    resolve(JSON.parse(xhr.responseText));
                } else {
                    reject("Error fetching data" + xhr.responseText);
                }
            }
        };
        xhr.send();
    });
}

function fetchById(table, id) {
    return new Promise((resolve, reject) => {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", `/${baseUrl}/rest/${table}/${id}`, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    resolve(JSON.parse(xhr.responseText));
                } else {
                    reject("Error fetching data" + xhr.responseText);
                }
            }
        };
        xhr.send();
    });
}

function fetchURL(url) {
    return new Promise((resolve, reject) => {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", `${baseUrl}/${url}`, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    console.log(xhr.responseText);
                    resolve(JSON.parse(xhr.responseText));
                } else {
                    reject("Error fetching data" + xhr.responseText);
                }
            }
        };
        xhr.send();
    });
}

function populateSelect(selectId, data, valueKey, textKey) {
    const select = document.getElementById(selectId);

    data.forEach(item => {
        const option = document.createElement("option");
        option.value = item[valueKey];
        option.textContent = item[textKey];
        select.appendChild(option);
    });
}