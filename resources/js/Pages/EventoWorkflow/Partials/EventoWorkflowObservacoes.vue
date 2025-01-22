<template>
    <div class="text-lg font-bold">Registrar observações</div>

    <div class="my-1 rounded bg-primary/10 p-2 hover:bg-primary/20" v-for="item in evento?.observacoes">
        <div class="flex justify-between">
            <div>
                <div class="text-xs font-light">{{ item.user?.name }} às {{ dateTimeLocale(item.created_at) }}</div>
                <div>
                    {{ item.observacao }}
                </div>
            </div>

            <div>
                <Button
                    icon="mdi mdi-delete-forever"
                    severity="danger"
                    size="small"
                    rounded
                    @click="form.delete('/evento-observacoes/' + item.id)"
                ></Button>
            </div>
        </div>
    </div>

    <div>
        <form
            @submit.prevent="
                form.post('/evento-observacoes', { onSuccess: () => form.reset('observacao'), preserveScroll: true })
            "
        >
            <div>
                <FloatLabel variant="in">
                    <Textarea
                        id="observacao"
                        class="w-full"
                        size="small"
                        rows="2"
                        v-model="form.observacao"
                        variant="filled"
                    />
                    <label for="observacao">Observação</label>
                </FloatLabel>
                <div class="text-red-500" v-if="form.errors.observacao">{{ form.errors.observacao }}</div>
            </div>

            <div
                v-if="Object.keys(form.errors).length > 0"
                class="my-4 flex items-center justify-center rounded bg-red-200 p-2 font-bold text-red-500"
            >
                <i class="mdi mdi-alert-box text-[22px]"></i>
                <div>Existem erros de validação</div>
            </div>

            <div class="text-center">
                <Button label="Enviar" icon="mdi mdi-send" type="submit" :loading="form.processing"></Button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { dateTimeLocale } from "@/Utils/dateUtils";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({ evento: Object });

const form = useForm({
    evento_id: props.evento.id,
    observacao: "",
});
</script>
