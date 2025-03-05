<template>
    <div>
        <FloatLabel variant="in">
            <InputText :id="field" class="w-full" size="small" v-model="model[field]" variant="filled" />
            <label :for="field">{{ label }}</label>
        </FloatLabel>
        <div class="text-red-500" v-if="model.errors[field]">{{ model.errors[field] }}</div>
    </div>
</template>

<script setup>
const model = defineModel(); // Form Object
const props = defineProps({
    field: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
});
</script>
