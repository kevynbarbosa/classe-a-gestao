<template>
    <div class="text-lg font-bold">Dados do contratante</div>

    <table class="w-full table-auto">
        <tbody>
            <tr>
                <td>Nome:</td>
                <td>{{ evento.contratante?.nome_completo }}</td>
            </tr>

            <tr>
                <td>CPF/CNPJ:</td>
                <td>{{ formataCpfCnpj(evento.contratante?.cpf_cnpj) }}</td>
            </tr>

            <tr>
                <td>RG:</td>
                <td>{{ evento.contratante?.rg }}</td>
            </tr>

            <tr>
                <td>Tipo:</td>
                <td>{{ evento?.contratante?.tipo_pessoa.toUpperCase() }}</td>
            </tr>
        </tbody>
    </table>
</template>

<script setup>
import { formataCpfCnpj } from "@/Utils/stringUtils";

const props = defineProps({ evento: Object });
const variable = ref(null);
</script>
