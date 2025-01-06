<template>
    <div class="mt-4 grid grid-cols-3 gap-2 border-t border-slate-300 pt-2">
        <template v-for="(item, index) in form">
            <div class="col-span-2 flex gap-2">
                <div class="self-center">
                    <Button
                        icon="mdi mdi-close"
                        severity="danger"
                        size="small"
                        rounded
                        variant="text"
                        @click="remove(index)"
                    />
                </div>

                <div class="flex-grow">
                    <FloatLabel variant="in">
                        <InputText
                            id="descricao"
                            class="w-full"
                            size="small"
                            v-model="item.descricao"
                            variant="filled"
                        />
                        <label for="descricao">Descrição</label>
                    </FloatLabel>
                </div>
            </div>

            <div>
                <FloatLabel variant="in">
                    <CurrencyInput id="valor" class="w-full" size="small" v-model="item.valor" variant="filled" />
                    <label for="valor">Valor</label>
                </FloatLabel>
            </div>
        </template>

        <div class="col-span-3 flex justify-end">
            <Button label="Adicionar serviço" icon="mdi mdi-plus" @click="add" />
        </div>
    </div>
</template>

<script setup>
import CurrencyInput from "@/Components/Form/CurrencyInput.vue";

const model = defineModel();

const form = ref([
    {
        descricao: null,
        valor: null,
    },
]);

function add() {
    form.value.push({
        descricao: null,
        valor: null,
    });
}

function remove(index) {
    form.value.splice(index, 1);
}
</script>
