<template>
    <p class="my-1 text-sm text-gray-600">Digite as informações para gerar uma proposta.</p>

    <form>
        <div>
            <FloatLabel variant="in">
                <InputText
                    id="nome_completo"
                    class="w-full"
                    size="small"
                    v-model="form.nome_completo"
                    variant="filled"
                />
                <label for="nome_completo">Nome completo</label>
            </FloatLabel>
            <div class="text-red-500" v-if="form.errors.nome_completo">{{ form.errors.nome_completo }}</div>
        </div>

        <div class="mt-4">
            <FloatLabel variant="in">
                <InputText id="documento" class="w-full" size="small" v-model="form.documento" variant="filled" />
                <label for="documento">Número do documento</label>
            </FloatLabel>
            <div class="text-red-500" v-if="form.errors.documento">{{ form.errors.documento }}</div>
        </div>

        <div class="mt-4 block">
            <label class="flex items-center">
                <Checkbox name="remember" v-model="form.atualizar_cadastro" binary />
                <span class="ms-2 text-sm text-gray-600">Atualizar cadastro do contratante</span>
            </label>
        </div>

        <div class="w-full text-center">
            <Button
                class="mt-2"
                label="Gerar proposta"
                icon="mdi mdi-send"
                @click="gerarPropostaContratante"
                :loading="form.processing"
            />
        </div>
    </form>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";

const props = defineProps({ evento: Object });

const variable = ref(null);

const form = useForm({
    nome_completo: null,
});

function gerarPropostaContratante() {
    form.post(route("evento-workflow.gerar-proposta", { evento: props.evento.id }));
}
</script>
