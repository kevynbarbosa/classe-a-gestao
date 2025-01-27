<template>
    <p class="my-1 text-sm text-gray-600">Digite as informações para gerar uma proposta.</p>

    <form>
        <!-- <div class="flex flex-col gap-3">
            <div>
                <FloatLabel variant="in">
                    <InputText
                        id="nome_completo"
                        class="w-full"
                        size="small"
                        v-model="form.nome_completo"
                        variant="filled"
                    />
                    <label for="nome_completo">Nome</label>
                </FloatLabel>
                <div class="text-red-500" v-if="form.errors.nome_completo">{{ form.errors.nome_completo }}</div>
            </div>

            <div>
                <FloatLabel variant="in">
                    <InputText id="cpf_cnpj" class="w-full" size="small" v-model="form.cpf_cnpj" variant="filled" />
                    <label for="cpf_cnpj">CPF/CNPJ</label>
                </FloatLabel>
                <div class="text-red-500" v-if="form.errors.cpf_cnpj">{{ form.errors.cpf_cnpj }}</div>
            </div>

            <div>
                <FloatLabel variant="in">
                    <InputText id="rg" class="w-full" size="small" v-model="form.rg" variant="filled" />
                    <label for="rg">RG</label>
                </FloatLabel>
                <div class="text-red-500" v-if="form.errors.rg">{{ form.errors.rg }}</div>
            </div>
        </div>

        <div class="mt-4 block">
            <label class="flex items-center">
                <Checkbox name="remember" v-model="form.atualizar_cadastro" binary />
                <span class="ms-2 text-sm text-gray-600">Atualizar cadastro do contratante</span>
            </label>
        </div> -->

        <ServicosDetalhamento :evento="evento" />

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
import ServicosDetalhamento from "./ServicosDetalhamento.vue";

const props = defineProps({ evento: Object });

const variable = ref(null);

const form = useForm({
    nome_completo: props.evento.contratante?.nome_completo ?? null,
    cpf_cnpj: props.evento.contratante?.cpf_cnpj ?? null,
    rg: props.evento.contratante?.rg ?? null,
    atualizar_cadastro: false,
    servicos: props.evento.servicos ?? [],
});

function gerarPropostaContratante() {
    form.post(route("evento-workflow.gerar-proposta", { evento: props.evento.id }));
}
</script>
