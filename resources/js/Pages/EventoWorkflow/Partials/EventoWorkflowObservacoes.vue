<template>
    <div class="text-lg font-bold">Registrar observações</div>

    <div class="pl-4">
        <ul class="list-disc">
            <li v-for="i in 3" class="my-2">Lorem ipsum</li>
        </ul>
    </div>

    <div>
        <Textarea class="w-full" v-model="variable" rows="2" cols="30" placeholder="Registrar uma observação" />

        <div class="text-center">
            <Button label="Enviar" icon="mdi mdi-send"></Button>
        </div>
    </div>
</template>

<script setup>
const variable = ref(null);
</script>
