// useCounter.js
import { ref } from "vue";

export function useTableMenu() {
    const menu = ref();

    const linhaSelecionado = ref();

    function abrirMenu(event, data) {
        menu.value.toggle(event);
        linhaSelecionado.value = data;
    }

    return { menu, abrirMenu };
}
