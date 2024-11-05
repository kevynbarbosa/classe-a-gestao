<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Informações de perfil</h2>

            <p class="mt-1 text-sm text-gray-600">Editar as informações do perfil.</p>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="mt-6 space-y-6">
            <div>
                <FloatLabel variant="in">
                    <InputText id="name" class="w-full" size="small" v-model="form.name" variant="filled" />
                    <label for="name">Nome</label>
                </FloatLabel>
                <div class="text-red-500" v-if="form.errors.name">{{ form.errors.name }}</div>
            </div>

            <div>
                <FloatLabel variant="in">
                    <InputText id="email" class="w-full" size="small" v-model="form.email" variant="filled" />
                    <label for="email">Email</label>
                </FloatLabel>
                <div class="text-red-500" v-if="form.errors.email">{{ form.errors.email }}</div>
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="mt-2 text-sm text-gray-800">
                    Seu email ainda não foi verificado.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Clique aqui para reenviar o link de verificação.
                    </Link>
                </p>

                <div v-show="status === 'verification-link-sent'" class="mt-2 text-sm font-medium text-green-600">
                    Um novo link de verificação foi enviado para o seu email.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <Button label="Save" :loading="form.processing" type="submit" />

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Salvo.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>

<script setup>
import { Link, useForm, usePage } from "@inertiajs/vue3";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});
</script>
