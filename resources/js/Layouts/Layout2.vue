<template>
    <div class="flex min-h-screen bg-[#181822]">
        <!-- Header -->
        <div class="fixed top-0 right-0 w-header">
            <div class="h-[116px]">
                <div>header</div>
            </div>
        </div>

        <!-- Menu -->
        <div class="w-[240px] border-r-[#2c2d33] border-r-[1px]">
            <div class="h-full w-[240px] fixed overflow-y-auto">
                <div class="text-center">
                    <!-- <div v-for="i in 200">Item do menu - {{ i }}</div> -->
                </div>
            </div>
        </div>

        <!-- Main -->
        <main class="w-full flex-1 mt-[116px]">
            <slot />
        </main>
    </div>
</template>

<script setup>
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
