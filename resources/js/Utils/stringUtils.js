function iniciaisNome(nome = "") {
    var nomes = nome.trim().split(" ");

    if (nomes.length == 0) return "--";

    if (nomes.length == 1) return nomes[0].substring(0, 2).toUpperCase();

    var primeira_inicial = nomes[0].substring(0, 1).toUpperCase();
    var ultima_inicial = nomes[nomes.length - 1].substring(0, 1).toUpperCase();

    return primeira_inicial + ultima_inicial;
}

export { iniciaisNome };
