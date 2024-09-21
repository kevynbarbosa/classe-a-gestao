<template>
    <div class="mb-4">
        <h3>{{ titulo }}</h3>
        <slot></slot>
    </div>
</template>

<script setup>
const props = defineProps({
    titulo: {
        type: String,
        required: true,
    },
});
const variable = ref(null);
</script>
