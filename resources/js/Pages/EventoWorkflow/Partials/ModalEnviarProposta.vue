<template>
    <Modal ref="modalRef" max-width="sm" v-slot="{ close }">
        <TituloCard titulo="Confirme o envio da proposta por email"></TituloCard>

        <form @submit.prevent="submit">
            <div>
                <FloatLabel variant="in">
                    <InputText id="email" class="w-full" size="small" v-model="form.email" variant="filled" />
                    <label for="email">E-mail</label>
                </FloatLabel>
                <div class="text-red-500" v-if="form.errors.email">{{ form.errors.email }}</div>
            </div>

            <div
                v-if="Object.keys(form.errors).length > 0"
                class="mt-4 flex items-center justify-center rounded bg-red-200 p-2 font-bold text-red-500"
            >
                <i class="mdi mdi-alert-box text-[22px]"></i>
                <div>Existem erros de validação</div>
            </div>

            <div class="mt-4 flex justify-end gap-2">
                <Button label="Cancelar" severity="secondary" @click="close" />
                <Button label="Salvar" type="submit" :loading="form.processing" />
            </div>
        </form>
    </Modal>
</template>

<script setup>
import TituloCard from "@/Components/TituloCard.vue";
import { useForm } from "@inertiajs/vue3";
import { Modal } from "@inertiaui/modal-vue";

const props = defineProps({ evento: Object });

const form = useForm({
    email: props.evento?.email_formulario ?? null,
});

const modalRef = ref(null);
function submit() {
    form.post(route("evento-workflow.enviar-proposta-email", { evento: props.evento.id }), {
        onSuccess: () => {
            modalRef.value.close();
        },
    });
}
</script>
