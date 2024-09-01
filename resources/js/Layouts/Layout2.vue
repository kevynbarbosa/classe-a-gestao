<template>
    <div class="flex min-h-screen bg-[#181822] text-slate-200">
        <!-- Header -->
        <div
            class="fixed top-0 right-0 z-10 bg-blue-300 transition-all duration-500 ease-in-out"
            :class="{ 'w-header': sideBarVisible, 'w-full': !sideBarVisible }"
        >
            <div class="h-[116px] p-4 flex justify-between items-center">
                <HeaderContent @toggleSideBar="toggleSideBar" />
            </div>
        </div>

        <!-- Menu -->
        <Transition>
            <div class="w-[240px]" v-if="sideBarVisible"></div>
        </Transition>

        <Transition>
            <div v-show="sideBarVisible" class="fixed h-full w-[240px] border-r border-[#2c2d33] overflow-y-auto">
                <LeftBarContent />
            </div>
        </Transition>

        <!-- Main -->
        <main class="w-full flex-1 mt-[116px] bg-purple-300">
            <slot />
        </main>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import HeaderContent from "./DefaultLayoutComponents/HeaderContent.vue";
import LeftBarContent from "./DefaultLayoutComponents/LeftBarContent.vue";

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

.v-enter-active,
.v-leave-active {
    transition: all 0.5s;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

.v-enter-from,
.v-leave-to {
    width: 0;
    overflow: hidden;
}
</style>
