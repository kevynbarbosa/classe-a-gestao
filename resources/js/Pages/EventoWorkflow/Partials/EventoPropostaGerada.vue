<template>
    <div class="text-center">Como deseja enviar a proposta?</div>

    <div class="grid grid-cols-3 gap-2">
        <Button label="Download e enviar manualmente" icon="mdi mdi-download" icon-class="text-2xl" />
        <Button label="E-mail " class="mdi mdi-email-fast" icon-class="text-2xl" />
        <Button label="WhatsApp" class="mdi mdi-whatsapp" icon-class="text-2xl" />
    </div>
</template>

<script setup>
const variable = ref(null);
</script>
