<template>
    <div class="mb-4 text-lg font-bold">Registrar datas de pagamentos</div>

    <div class="mb-4">
        <p v-for="item in evento?.pagamentos">
            <b>R$ {{ decimalLocale(item.valor) }}</b>
            em {{ dateLocale(item.data_pagamento) }}
        </p>
    </div>

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

    {{ form.data_pagamento }}
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

function submit() {
    form.post("/evento-pagamentos", { onSuccess: () => form.reset(), preserveScroll: true });
}
</script>
