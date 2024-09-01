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
        <OverlayBadge value="4" severity="danger">
            <div class="bg-primary p-4">
                <i class="mdi mdi-bell" />
            </div>
        </OverlayBadge>
    </div>
</template>

<script setup>
const props = defineProps([]);
const emits = defineEmits(["toggleSideBar"]);

const value = ref(null);

onMounted(() => {
    // Mounted
});
</script>
