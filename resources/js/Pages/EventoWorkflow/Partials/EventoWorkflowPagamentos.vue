<template>
    <div class="mb-4 text-lg font-bold">Registrar datas de pagamentos</div>

    <form @submit.prevent="submit" autocomplete="off">
        <div class="flex justify-center gap-4">
            <FieldWrap
                v-model="form"
                field="data_pagamento"
                label="Data do pagamento"
                datepicker
                dateFormat="dd/mm/yy"
                :show-time="false"
            />

            <FieldWrap v-model="form" field="valor" label="Valor" currency />

            <div class="flex-0 pt-2">
                <Button
                    label="Adicionar"
                    icon="mdi mdi-plus-box"
                    type="submit"
                    severity="success"
                    :loading="form.processing"
                ></Button>
            </div>
        </div>
    </form>

    <div
        v-if="somaDivergente"
        class="mt-4 flex items-center justify-center rounded bg-red-200 p-2 font-bold text-red-500"
    >
        <i class="mdi mdi-alert-box text-[22px]" v-tooltip="tooltip"></i>
        <div>Atenção, os valores de pagamento não fecha com o valor do evento!</div>
    </div>

    <div class="mb-4">
        <p v-for="item in evento?.pagamentos" class="my-1">
            <Button
                class="mr-4"
                icon="mdi mdi-delete-forever"
                severity="danger"
                size="small"
                rounded
                @click="form.delete('/evento-pagamentos/' + item.id)"
                :loading="form.processing"
            ></Button>

            <b>R$ {{ decimalLocale(item.valor) }}</b>
            em {{ dateLocale(item.data_pagamento) }}
        </p>
    </div>

    <div class="mb-24"></div>
</template>

<script setup>
import FieldWrap from "@/Components/Form/FieldWrap.vue";
import { dateLocale } from "@/Utils/dateUtils";
import { decimalLocale } from "@/Utils/decimalUtils";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    evento: Object,
});

const form = useForm({
    evento_id: props.evento.id,
    data_pagamento: null,
    valor: null,
});

const somaDivergente = computed(() => {
    const totalPagamentos = props.evento?.pagamentos?.reduce((sum, payment) => sum + parseFloat(payment.valor || 0), 0);
    return totalPagamentos !== parseFloat(props.evento?.valor || 0);
});

function submit() {
    form.post("/evento-pagamentos", { onSuccess: () => form.reset(), preserveScroll: true });
}
</script>
