<template>
    <Modal>
        <form>
            <div>
                <div class="flex-grow">
                    <FloatLabel variant="in">
                        <InputText
                            id="descricao"
                            class="w-full"
                            size="small"
                            v-model="form.descricao"
                            variant="filled"
                        />
                        <label for="descricao">Descrição</label>
                    </FloatLabel>
                </div>
            </div>

            <div>
                <FloatLabel variant="in">
                    <CurrencyInput id="valor" class="w-full" size="small" v-model="form.valor" variant="filled" />
                    <label for="valor">Valor</label>
                </FloatLabel>
            </div>
        </form>
    </Modal>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";

const variable = useForm({
    descricao: "",
    valor: 0,
});
</script>
