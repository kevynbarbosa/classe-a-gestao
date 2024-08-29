<template>
    <div class="bg-gray-100 dark:bg-gray-800 min-h-screen">
        <!-- TopBar -->
        <div
            class="flex flex-wrap bg-slate-200 dark:bg-gray-700 h-14 px-8 justify-between content-center fixed top-0 left-0 right-0 z-10"
        >
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

        <div class="flex">
            <!-- Sidebar -->
            <div class="h-screen max-h-screen w-64 bg-purple-400 dark:bg-[#20242f] sticky z-5" v-show="sideBarVisible">
                <div class="mt-14">11111 alo alo alo</div>
            </div>

            <!-- MainContent -->
            <main class="mt-14 bg-blue-300 flex-1">
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
// const topBarSize = ref("3.5rem");

const sideBarVisible = ref(true);
function toggleSideBar() {
    sideBarVisible.value = !sideBarVisible.value;
}

onMounted(() => {
    // Mounted
});
</script>
