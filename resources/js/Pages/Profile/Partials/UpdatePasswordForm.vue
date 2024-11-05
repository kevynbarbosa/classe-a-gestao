<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Atualizar senha</h2>

            <p class="mt-1 text-sm text-gray-600">
                Certifique de utilizar uma senha forte e segura para sua conta. Sua senha deve conter pelo menos 8
                dígitos.
            </p>
        </header>

        <form @submit.prevent="updatePassword" class="mt-6 space-y-6">
            <div>
                <FloatLabel variant="in">
                    <InputText
                        id="current_password"
                        class="w-full"
                        size="small"
                        v-model="form.current_password"
                        variant="filled"
                    />
                    <label for="current_password">Senha atual</label>
                </FloatLabel>
                <div class="text-red-500" v-if="form.errors.current_password">{{ form.errors.current_password }}</div>
            </div>

            <div>
                <FloatLabel variant="in">
                    <InputText id="password" class="w-full" size="small" v-model="form.password" variant="filled" />
                    <label for="password">Nova senha</label>
                </FloatLabel>
                <div class="text-red-500" v-if="form.errors.password">{{ form.errors.password }}</div>
            </div>

            <div>
                <FloatLabel variant="in">
                    <InputText
                        id="password_confirmation"
                        class="w-full"
                        size="small"
                        v-model="form.password_confirmation"
                        variant="filled"
                    />
                    <label for="password_confirmation">Confirme a senha</label>
                </FloatLabel>
                <div class="text-red-500" v-if="form.errors.password_confirmation">
                    {{ form.errors.password_confirmation }}
                </div>
            </div>

            <div class="flex items-center gap-4">
                <Button label="Salvar" :loading="form.processing" type="submit" />

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
});

const updatePassword = () => {
    form.put(route("password.update"), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset("password", "password_confirmation");
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset("current_password");
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>
