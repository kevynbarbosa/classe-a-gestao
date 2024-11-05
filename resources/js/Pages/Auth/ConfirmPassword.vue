<template>
    <Head title="Confirm Password" />

    <div class="mb-4 text-sm text-gray-600">
        Esta é uma área restrita. Por favor, confirme sua senha antes de continuar.
    </div>

    <form @submit.prevent="submit">
        <div>
            <FloatLabel variant="in">
                <InputText id="password" class="w-full" size="small" v-model="form.password" variant="filled" />
                <label for="password">Senha</label>
            </FloatLabel>
            <div class="text-red-500" v-if="form.errors.password">{{ form.errors.password }}</div>
        </div>

        <div class="mt-4 flex justify-end">
            <Button label="Confirmar" type="submit" :loading="form.processing" class="ms-4" />
        </div>
    </form>
</template>

<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";

defineOptions({ layout: GuestLayout });

const form = useForm({
    password: "",
});

const submit = () => {
    form.post(route("password.confirm"), {
        onFinish: () => form.reset(),
    });
};
</script>
