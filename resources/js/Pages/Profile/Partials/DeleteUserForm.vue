<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">Deletar conta</h2>

            <p class="mt-1 text-sm text-gray-600">
                Uma vez que sua conta seja deletada, todos os seus recursos e dados serão permanentemente deletados.
                Antes de deletar sua conta, por favor, faça o download de qualquer dado ou informação que você deseja
                manter.
            </p>
        </header>

        <Button label="Deletar conta" @click="confirmUserDeletion" severity="danger" />

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">Você tem certeza que deseja deletar sua conta?</h2>

                <p class="mt-1 text-sm text-gray-600">
                    Uma vez que sua conta seja deletada, todos os seus recursos e dados serão permanentemente deletados.
                    Por favor, digite sua senha para confirmar que você deseja deletar permanentemente sua conta.
                </p>

                <div class="mt-6">
                    <FloatLabel variant="in">
                        <InputText id="password" class="w-full" size="small" v-model="form.password" variant="filled" />
                        <label for="password">Digite sua senha</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.password">{{ form.errors.password }}</div>
                </div>

                <div class="mt-6 flex justify-end">
                    <Button label="Cancelar" severity="secondary" @click="closeModal" />
                    <Button
                        label="Deletar"
                        severity="danger"
                        class="ms-3"
                        @click="deleteUser"
                        :loading="form.processing"
                    />
                </div>
            </div>
        </Modal>
    </section>
</template>

<script setup>
import Modal from "@/Components/Modal.vue";
import { useForm } from "@inertiajs/vue3";
import { nextTick, ref } from "vue";

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: "",
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route("profile.destroy"), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>
