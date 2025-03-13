<template>
    <p class="my-1 text-center text-sm text-gray-600">Confirme as informações para gerar uma proposta.</p>

    <form>
        <!-- <ServicosDetalhamento :evento="evento" /> -->

        <div class="mt-4 w-full border-t border-slate-300 pt-2 text-center">
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
    nome_completo: props.evento.contratante?.nome_completo ?? null,
    cpf_cnpj: props.evento.contratante?.cpf_cnpj ?? null,
    rg: props.evento.contratante?.rg ?? null,
    atualizar_cadastro: false,
    // servicos: props.evento.servicos ?? [],
});

function gerarPropostaContratante() {
    form.post(route("evento-workflow.gerar-proposta", { evento: props.evento.id }));
}
</script>
