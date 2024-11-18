<template>
    <div class="text-center">
        Formulário enviado para o e-mail:
        <b>q4m0e@example.com</b>
        às 12:00
    </div>
    <div class="flex justify-center gap-2">
        <Button label="Alterar e-mail do formulário" icon="mdi mdi-email-edit" />

        <Button label="Copiar link do formulário" icon="mdi mdi-content-copy" severity="info" />
    </div>
</template>

<script setup>
const variable = ref(null);
</script>
