<template>
    <div class="grid grid-cols-2 gap-2">
        <div v-for="i in 7" class="flex cursor-pointer gap-2 rounded bg-slate-100 p-2 hover:bg-slate-200">
            <i class="mdi mdi-file" style="font-size: 3rem"></i>
            <div>
                <div>Documento 1</div>
                <div>Inserido em: 01/01/2023</div>
            </div>
        </div>
    </div>
</template>

<script setup>
const variable = ref(null);
</script>
