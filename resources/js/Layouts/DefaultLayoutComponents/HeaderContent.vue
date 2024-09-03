<template>
    <div>
        <Button icon="mdi mdi-menu" aria-label="Save" @click="emits('toggleSideBar')" size="small" />
    </div>

    <div>
        <IconField>
            <InputIcon class="mdi mdi-magnify" />
            <InputText v-model="value" placeholder="Search" size="small" />
        </IconField>
    </div>

    <div>
        <OverlayBadge severity="danger">
            <Button icon="mdi mdi-bell" @click="emits('toggleRightBar')" size="small"></Button>
        </OverlayBadge>
    </div>
</template>

<script setup>
const props = defineProps([]);
const emits = defineEmits(["toggleSideBar", "toggleRightBar"]);

const value = ref(null);

onMounted(() => {
    // Mounted
});
</script>
