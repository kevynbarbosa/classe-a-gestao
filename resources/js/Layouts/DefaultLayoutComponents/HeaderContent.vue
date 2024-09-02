<template>
    <div>
        <Button icon="mdi mdi-menu" aria-label="Save" @click="emits('toggleSideBar')" />
    </div>

    <div>
        <IconField>
            <InputIcon class="mdi mdi-magnify" />
            <InputText v-model="value" placeholder="Search" />
        </IconField>
    </div>

    <div>
        <OverlayBadge severity="danger">
            <Button icon="mdi mdi-bell" @click="emits('toggleRightBar')"></Button>
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
