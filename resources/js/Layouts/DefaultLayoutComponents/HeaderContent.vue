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
            <i class="mdi mdi-bell" style="font-size: 1.5rem" />
        </OverlayBadge>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";

const props = defineProps([]);
const emits = defineEmits(["toggleSideBar"]);

const value = ref(null);

onMounted(() => {
    // Mounted
});
</script>
