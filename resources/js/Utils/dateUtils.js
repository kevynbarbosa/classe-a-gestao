// Parse a date string to Date object
function parse2Date(date) {
    if (!date) {
        return null;
    }

    const [ano, mes, dia] = date.split("-").map(Number);
    const dateObj = new Date(ano, mes - 1, dia);

    return dateObj;
}

// Formata a data formato americano para brasileiro
function dateLocale(date, fuso = "-3") {
    const [ano, mes, dia] = date.split("-").map(Number);
    const dateObj = new Date(ano, mes - 1, dia);
    return dateObj.toLocaleDateString();
}

export { dateLocale, parse2Date };
