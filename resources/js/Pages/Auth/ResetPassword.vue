<template>
    <Head title="Reset Password" />

    <form @submit.prevent="submit">
        <div>
            <FloatLabel variant="in">
                <InputText id="email" class="w-full" size="small" v-model="form.email" variant="filled" />
                <label for="email">Email</label>
            </FloatLabel>
            <div class="text-red-500" v-if="form.errors.email">{{ form.errors.email }}</div>
        </div>

        <div class="mt-4">
            <FloatLabel variant="in">
                <InputText id="password" class="w-full" size="small" v-model="form.password" variant="filled" />
                <label for="password">Senha</label>
            </FloatLabel>
            <div class="text-red-500" v-if="form.errors.password">{{ form.errors.password }}</div>
        </div>

        <div class="mt-4">
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

        <div class="mt-4 flex items-center justify-end">
            <Button label="Redefinir senha" type="submit" :loading="form.processing" />
        </div>
    </form>
</template>

<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";

defineOptions({ layout: GuestLayout });

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("password.store"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>
