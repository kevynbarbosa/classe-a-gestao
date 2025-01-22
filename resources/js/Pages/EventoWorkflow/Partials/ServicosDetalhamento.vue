<template>
    <div class="card mt-4 border border-slate-300">
        <TituloCard titulo="Serviços"></TituloCard>

        <div class="text-right">
            <Button
                label="Adicionar"
                icon="mdi mdi-plus"
                severity="info"
                size="small"
                outlined
                @click="novoServico"
                :loading="loadingModal"
            />
        </div>

        <table class="mt-4 w-full">
            <thead>
                <tr>
                    <th class="text-left">Descrição</th>
                    <th class="text-right">Valor</th>
                    <th class="text-right"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in evento?.servicos">
                    <td class="text-left">{{ item.descricao }}</td>
                    <td class="whitespace-nowrap text-right">R$ {{ decimalLocale(item.valor) }}</td>
                    <td class="flex justify-end gap-2">
                        <Button
                            icon="mdi mdi-pencil"
                            severity="secondary"
                            size="small"
                            outlined
                            @click="
                                visitModal(
                                    route('evento-servicos.edit', { evento: evento.id, evento_servico: item.id }),
                                )
                            "
                        ></Button>

                        <ModalLink href="#modalDelete">
                            <Button
                                icon="mdi mdi-delete-forever"
                                severity="danger"
                                size="small"
                                outlined
                                @click="servicoSelecionado = item"
                            ></Button>
                        </ModalLink>
                    </td>
                </tr>

                <tr class="bg-primary/10">
                    <td class="text-left font-bold">Total</td>
                    <td class="whitespace-nowrap text-right font-bold">
                        R$
                        {{ decimalLocale(totalServicos) }}
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <div
            v-if="totalServicos != evento.valor"
            class="mt-4 flex w-full items-center justify-center rounded bg-red-200 p-2 font-bold text-red-500"
        >
            <i class="mdi mdi-alert-box text-[22px]"></i>
            <div>Valor dos serviços difere do valor do evento</div>
        </div>
    </div>

    <Modal name="modalDelete" ref="modalDeleteRef" max-width="md" v-slot="{ close }">
        <Head title="Remover serviço" />

        <TituloCard titulo="Remover serviço"></TituloCard>

        <div>
            Deseja remover o serviço
            <b>"{{ servicoSelecionado?.descricao }}"</b>
            ?
        </div>

        <div class="mt-4 flex justify-end gap-2">
            <Button label="Cancelar" severity="secondary" @click="close" />
            <Button label="Remover" severity="danger" @click="submitDelete(), close()" />
        </div>
    </Modal>
</template>

<script setup>
import TituloCard from "@/Components/TituloCard.vue";
import { decimalLocale } from "@/Utils/decimalUtils";
import { Head, useForm } from "@inertiajs/vue3";
import { Modal, ModalLink, visitModal } from "@inertiaui/modal-vue";
import { computed } from "vue";

const props = defineProps({ evento: Object });

const servicos = ref([
    {
        descricao: "teste",
        valor: "10,00",
    },
]);

const totalServicos = computed(() => {
    return props.evento?.servicos.reduce((total, item) => total + parseFloat(item.valor), 0);
});

const loadingModal = ref(false);
async function novoServico() {
    loadingModal.value = true;
    await visitModal(route("evento-servicos.create", { evento: props.evento.id }));
    loadingModal.value = false;
}

const servicoSelecionado = ref(null);
const deleteServicoForm = useForm({});
const modalDeleteRef = ref(null);
async function submitDelete() {
    deleteServicoForm.delete(
        route("evento-servicos.destroy", {
            evento: props.evento.id,
            evento_servico: servicoSelecionado.value.id,
        }),
        {
            preserveScroll: true,
            onSuccess() {
                servicoSelecionado.value = null;
            },
        },
    );
}
</script>
