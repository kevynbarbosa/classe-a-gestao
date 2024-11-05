<template>
    <Head title="Register" />

    <form @submit.prevent="submit">
        <div>
            <FloatLabel variant="in">
                <InputText
                    id="name"
                    class="w-full"
                    type="text"
                    size="small"
                    v-model="form.name"
                    variant="filled"
                    autofocus
                    autocomplete="name"
                />
                <label for="name">Nome</label>
            </FloatLabel>
            <div class="text-red-500" v-if="form.errors.name">{{ form.errors.name }}</div>
        </div>

        <div class="mt-4">
            <FloatLabel variant="in">
                <InputText
                    id="email"
                    class="w-full"
                    type="email"
                    size="small"
                    v-model="form.email"
                    variant="filled"
                    required
                    autocomplete="username"
                />
                <label for="email">Email</label>
            </FloatLabel>
            <div class="text-red-500" v-if="form.errors.email">{{ form.errors.email }}</div>
        </div>

        <div class="mt-4">
            <FloatLabel variant="in">
                <InputText
                    id="password"
                    class="w-full"
                    type="password"
                    size="small"
                    v-model="form.password"
                    variant="filled"
                    required
                    autocomplete="new-password"
                />
                <label for="password">Senha</label>
            </FloatLabel>
            <div class="text-red-500" v-if="form.errors.password">{{ form.errors.password }}</div>
        </div>

        <div class="mt-4">
            <FloatLabel variant="in">
                <InputText
                    id="password_confirmation"
                    class="w-full"
                    type="password"
                    size="small"
                    v-model="form.password_confirmation"
                    variant="filled"
                    required
                    autocomplete="new-password"
                />
                <label for="password_confirmation">Confirmar Senha</label>
            </FloatLabel>
            <div class="text-red-500" v-if="form.errors.password_confirmation">
                {{ form.errors.password_confirmation }}
            </div>
        </div>

        <div class="mt-4 flex items-center justify-end">
            <Link
                :href="route('login')"
                class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            >
                Já tem cadastro?
            </Link>

            <Button class="ms-4" label="Registrar" :loading="form.processing" type="submit" />
        </div>
    </form>
</template>

<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

defineOptions({ layout: GuestLayout });

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>
