<template>
    <div class="grid grid-cols-2 items-center gap-1 rounded bg-primary/10 p-2" v-for="evento in dados" :key="evento.id">
        <div class="font-bold">{{ evento.nome }}</div>
        <div>
            <Badge :value="evento.total" severity="info" size="large"></Badge>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    dados: Array,
});
const variable = ref(null);
</script>
