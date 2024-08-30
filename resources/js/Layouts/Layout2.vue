<template>
    <div class="flex min-h-screen bg-[#181822] text-slate-200">
        <!-- Header -->
        <div class="fixed top-0 right-0 w-header z-10 bg-blue-300">
            <div class="h-[116px] p-4 flex justify-between items-center">
                <div>
                    <Button icon="mdi mdi-menu" aria-label="Save" @click="toggleSideBar" />
                </div>

                <div>Teste</div>

                <div>Teste</div>
            </div>
        </div>

        <!-- Menu -->
        <div class="w-[240px] border-r-[#2c2d33] border-r-[1px]" v-show="sideBarVisible">
            <div class="h-full w-[240px] fixed overflow-y-auto">
                <div class="text-center">
                    <div v-for="i in 200">Item do menu - {{ i }}</div>
                </div>
            </div>
        </div>

        <!-- Main -->
        <main class="w-full flex-1 mt-[116px] bg-purple-300">
            <slot />
        </main>
    </div>
</template>

<script setup>
import Button from "primevue/button";
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

<style scoped>
.w-header {
    width: calc(100% - 240px);
}
</style>
