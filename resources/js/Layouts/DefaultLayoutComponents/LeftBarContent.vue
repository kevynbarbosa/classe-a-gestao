<template>
    <div class="text-center">
        <div v-for="i in 200" :key="i">Item do menu - {{ i }}</div>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";

const props = defineProps([]);

const someVar = ref(null);

onMounted(() => {
    // Mounted
});
</script>
