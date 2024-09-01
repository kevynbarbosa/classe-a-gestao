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
import Button from "primevue/button";
import IconField from "primevue/iconfield";
import InputIcon from "primevue/inputicon";
import InputText from "primevue/inputtext";
import OverlayBadge from "primevue/overlaybadge";
import { onMounted, ref } from "vue";

const props = defineProps([]);
const emits = defineEmits(["toggleSideBar"]);

const value = ref(null);

onMounted(() => {
    // Mounted
});
</script>
