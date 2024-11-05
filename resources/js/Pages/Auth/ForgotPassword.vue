<template>
    <Head title="Forgot Password" />

    <div class="mb-4 text-sm text-gray-600">
        Esqueceu sua senha? Sem problemas. Basta nos informar seu endereço de e-mail e enviaremos um link de redefinição
        de senha para que você possa escolher uma nova.
    </div>

    <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
        {{ status }}
    </div>

    <form @submit.prevent="submit">
        <div>
            <FloatLabel variant="in">
                <InputText id="email" class="w-full" size="small" v-model="form.email" variant="filled" />
                <label for="email">Email</label>
            </FloatLabel>
            <div class="text-red-500" v-if="form.errors.email">{{ form.errors.email }}</div>
        </div>

        <div class="mt-4 flex items-center justify-end">
            <Button label="Link de redefinição de senha" type="submit" :loading="form.processing" />
        </div>
    </form>
</template>

<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";

defineOptions({ layout: GuestLayout });

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: "",
});

const submit = () => {
    form.post(route("password.email"));
};
</script>
