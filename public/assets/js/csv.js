function parseCSV(content, separator = ",") {
    const lines = content.trim().split("\n").map(line => line.trim()).filter(line => line !== "");

    const headers = lines.shift().split(separator).map(header => header.trim());

    const rows = lines.map(line => {
        const values = line.split(separator).map(value => value.trim());
        let rowObject = {};
        headers.forEach((header, index) => {
            let value = values[index] || "";
            if (value.startsWith("'") && value.endsWith("'")) {
                value = value.slice(1, -1);
            }
            rowObject[header] = value;
        });
        return rowObject;
    });

    return { headers, rows };
}