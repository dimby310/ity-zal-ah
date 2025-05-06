<?php
$baseUrl = Flight::get("flight.base_url");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import data</title>
</head>

<body>
    <div>
        <input type="file" id="csvFile" accept=".csv" />
        <input type="text" id="tableName" placeholder="Entrez le nom de la table" value="periode">
        <input type="text" id="separator" placeholder="Separateur" value=",">
        <button id="import-btn">Importer CSV</button>
        <pre id="result"></pre>
    </div>

    <div>
        <h1>File Content</h1>
        <pre id="output"></pre>
    </div>

    <div id="confirmation-dialog" style="display: none;">
        <p>Est-ce le contenu attendu?</p>
        <button id="confirm-import">Oui, importer</button>
        <button id="cancel-import">Non, annuler</button>
    </div>

    <script src="<?= $baseUrl ?>/public/assets/js/main.js"></script>
    <script src="<?= $baseUrl ?>/public/assets/js/csv.js"></script>

    <script>
        const importBtn = document.getElementById("import-btn");
        importBtn.addEventListener("click", async () => {
            const tableName = document.getElementById("tableName").value.trim();
            const separator = document.getElementById("separator").value.trim();

            if (!tableName) {
                alert("Please enter a table name.");
                return;
            }

            const fileContent = await getCSVContent();
            if (fileContent) {
                display(fileContent);
            }
        });

        async function getCSVContent() {
            let fileInput = document.getElementById("csvFile");
            let file = fileInput.files[0];

            if (!file) {
                alert("Please select a file.");
                return null;
            }

            return new Promise((resolve, reject) => {
                let reader = new FileReader();

                reader.onload = function(event) {
                    resolve(event.target.result);
                };

                reader.onerror = function(error) {
                    reject(error);
                };

                reader.readAsText(file);
            });
        }

        function display(content) {
            const {
                headers,
                rows
            } = parseCSV(content);

            let htmlContent = `<h3>Apercu du fichier CSV</h3>`;
            htmlContent += `<table border="1"><thead><tr>`;

            // Headers
            headers.forEach(header => {
                htmlContent += `<th>${header}</th>`;
            });

            htmlContent += `</tr></thead><tbody>`;

            // Rows
            rows.forEach(row => {
                htmlContent += `<tr>`;
                headers.forEach(header => {
                    htmlContent += `<td>${row[header]}</td>`;
                });
                htmlContent += `</tr>`;
            });

            htmlContent += `</tbody></table>`;

            document.getElementById("output").innerHTML = htmlContent;

            // Confirmation
            const confirmDialog = document.getElementById("confirmation-dialog");
            confirmDialog.style.display = "block";

            document.getElementById("confirm-import").addEventListener("click", () => {
                document.getElementById("result").textContent = "Proceeding with import...";
                confirmDialog.style.display = "none";
                const tableName = document.getElementById("tableName").value.trim();
                const separator = document.getElementById("separator").value.trim();
                sendToServer(tableName, content, separator);
            });

            document.getElementById("cancel-import").addEventListener("click", () => {
                document.getElementById("result").textContent = "Import canceled.";
                confirmDialog.style.display = "none";
            });
        }

        function sendToServer(table, content, separator) {
            const xhr = new XMLHttpRequest();
            const url = `${baseUrl}/import/${table}/`;

            xhr.open("POST", url, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        document.getElementById("result").textContent = "Import successful! " + xhr.responseText;
                    } else {
                        console.error("Error:", xhr.status, xhr.responseText);
                        document.getElementById("result").textContent = "Import failed. " + xhr.responseText;
                    }
                }
            };

            xhr.send(`content=${content}&table=${table}&separator=${separator}`);
        }
    </script>
</body>

</html>