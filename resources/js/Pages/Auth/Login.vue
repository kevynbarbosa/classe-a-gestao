<template>
    <Head title="Iniciar sessão" />

    <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
        {{ status }}
    </div>

    <form @submit.prevent="submit">
        <div>
            <FloatLabel variant="in">
                <InputText id="email" class="w-full" type="email" size="small" v-model="form.email" variant="filled" />
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

        <div class="mt-4 block">
            <label class="flex items-center">
                <Checkbox name="remember" v-model="form.remember" :value="true" />
                <span class="ms-2 text-sm text-gray-600">Manter conectado</span>
            </label>
        </div>

        <div class="mt-4 flex items-center justify-end">
            <Link
                v-if="canResetPassword"
                :href="route('password.request')"
                class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            >
                Esqueceu sua senha?
            </Link>

            <Button class="ms-4" label="Entrar" :loading="form.processing" type="submit"></Button>
        </div>
    </form>
</template>

<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

defineOptions({ layout: GuestLayout });

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>
