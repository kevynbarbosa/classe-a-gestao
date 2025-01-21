<template>
    <div class="card mt-4 border border-slate-300">
        <TituloCard titulo="Serviços"></TituloCard>

        <div class="text-right">
            <Button label="Adicionar" icon="mdi mdi-plus" severity="info" size="small" outlined @click="add" />
        </div>

        <table class="mt-4 w-full">
            <thead>
                <tr>
                    <th class="text-left">Descrição</th>
                    <th class="text-right">Valor</th>
                    <th class="text-right"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in servicos">
                    <td class="text-left">{{ item.descricao }}</td>
                    <td class="text-right">{{ item.valor }}</td>
                    <td class="text-right"><Button label="Remover" severity="danger" size="small"></Button></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import CurrencyInput from "@/Components/Form/CurrencyInput.vue";
import TituloCard from "@/Components/TituloCard.vue";
import { useForm } from "@inertiajs/vue3";

const model = defineModel();

const servicos = ref([
    {
        descricao: "teste",
        valor: "10,00",
    },
]);
</script>
