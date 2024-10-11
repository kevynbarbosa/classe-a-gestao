function dateLocale(date, fuso = "-3") {
    const [ano, mes, dia] = date.split("-").map(Number);
    const dateObj = new Date(ano, mes - 1, dia);
    return dateObj.toLocaleDateString();
}

function parse2Date(date) {
    const [ano, mes, dia] = date.split("-").map(Number);
    const dateObj = new Date(ano, mes - 1, dia);

    return dateObj;
}

export { dateLocale, parse2Date };
