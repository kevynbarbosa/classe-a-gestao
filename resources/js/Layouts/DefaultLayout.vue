<template>
    <div class="bg-gray-100 dark:bg-gray-800 min-h-screen flex">
        <div class="w-64 bg-purple-300" v-show="sideBarVisible">
            <!-- Sidebar -->
            1
        </div>

        <div class="flex flex-col flex-1">
            <!-- TopBar -->
            <div class="flex flex-wrap bg-slate-200 dark:bg-gray-700 h-14 px-8 justify-between content-center">
                <!-- Menu toggle -->
                <div>
                    <Button icon="mdi mdi-menu" aria-label="Save" @click="toggleSideBar" />
                </div>

                <!-- Search field -->
                <div>
                    <IconField>
                        <InputIcon class="mdi mdi-magnify" />
                        <InputText v-model="value" placeholder="Search" />
                    </IconField>
                </div>

                <!-- Notification drawer -->
                <div>
                    <OverlayBadge severity="danger">
                        <i class="mdi mdi-bell" style="font-size: 1.5rem" />
                    </OverlayBadge>
                </div>
            </div>

            <!-- MainContent -->
            <main>
                <slot />
            </main>
        </div>
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

const value = ref(null);

const sideBarVisible = ref(true);
function toggleSideBar() {
    sideBarVisible.value = !sideBarVisible.value;
}

onMounted(() => {
    // Mounted
});
</script>
