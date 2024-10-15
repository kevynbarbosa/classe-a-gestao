// Parse a date string to Date object
function parse2Date(date) {
    if (!date) {
        return null;
    }

    const [ano, mes, dia] = date.split("-").map(Number);
    const dateObj = new Date(ano, mes - 1, dia);

    return dateObj;
}

function parseDateTime(dateTime, timezone = -3) {
    const dateObj = new Date(dateTime);
    dateObj.setHours(dateObj.getHours() + timezone);

    return dateObj;
}

// Formata a data formato americano para brasileiro
function dateLocale(date, fuso = "-3") {
    const [ano, mes, dia] = date.split("-").map(Number);
    const dateObj = new Date(ano, mes - 1, dia);
    return dateObj.toLocaleDateString();
}

function dateTimeLocale(date, fuso = -3) {
    const dateObj = parseDateTime(date, fuso);

    return dateObj.toLocaleString();
}

export { dateLocale, dateTimeLocale, parse2Date, parseDateTime };
