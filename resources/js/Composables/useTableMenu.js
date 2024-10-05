// useCounter.js
import { ref } from "vue";

export function useTableMenu() {
    const menu = ref();

    const item_selecionado = ref();

    function abrirMenu(event, data) {
        menu.value.toggle(event);
        item_selecionado.value = data;
    }

    return { menu, item_selecionado, abrirMenu };
}
