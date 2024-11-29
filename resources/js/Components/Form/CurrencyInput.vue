<template>
    <InputText ref="inputRef" type="text" :class="{ 'p-filled': modelValue }" />
</template>

<script setup>
import { useCurrencyInput } from "vue-currency-input";

const props = defineProps({
    modelValue: Number, // Vue 2: value
    options: {
        type: Object,
        default: () => ({
            currency: "BRL",
            hideCurrencySymbolOnFocus: false,
            hideGroupingSeparatorOnFocus: false,
            hideNegligibleDecimalDigitsOnFocus: false,
        }),
    },
});

const { inputRef } = useCurrencyInput(props.options);
</script>
