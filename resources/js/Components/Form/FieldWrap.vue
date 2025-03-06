<template>
    <div>
        <FloatLabel variant="in">
            <InputText
                v-if="mask"
                :id="field"
                class="w-full"
                size="small"
                v-model="model[field]"
                variant="filled"
                v-mask="mask"
            />

            <InputNumber
                v-else-if="props.currency"
                v-model="model[field]"
                :id="field"
                inputId="currency-br"
                mode="currency"
                currency="BRL"
                locale="pt-BR"
                :minFractionDigits="2"
                :maxFractionDigits="2"
                fluid
            />

            <InputText v-else :id="field" class="w-full" size="small" v-model="model[field]" variant="filled" />

            <label :for="field">{{ label }}</label>
        </FloatLabel>
        <div class="text-red-500" v-if="model.errors[field]">{{ model.errors[field] }}</div>

        <!-- <div>Mask: {{ mask }}</div> -->
    </div>
</template>

<script setup>
import { computed } from "vue";

const model = defineModel(); // Form Object
const props = defineProps({
    field: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    cpf: {
        type: Boolean,
        default: false,
    },
    cnpj: {
        type: Boolean,
        default: false,
    },
    cep: {
        type: Boolean,
        default: false,
    },
    phone: {
        type: Boolean,
        default: false,
    },
    currency: {
        type: Boolean,
        default: false,
    },
});

const mask = computed(() => {
    if (props.cep) return "#####-###";
    if (props.cpf) return "###.###.###-##";
    if (props.cnpj) return "##.###.###/####-##";
    if (props.phone) return ["(##) #####-####", "(##) ####-####"];

    return null;
});
</script>
