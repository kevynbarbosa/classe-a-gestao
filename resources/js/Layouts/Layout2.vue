<template>
    <div class="flex min-h-screen bg-[#181822] text-slate-200">
        <!-- Header -->
        <div
            class="fixed top-0 right-0 z-10 bg-blue-300 transition-header"
            :class="{ 'w-header': sideBarVisible, 'w-full': !sideBarVisible }"
        >
            <div class="h-header p-4 pr-8 flex justify-between items-center">
                <HeaderContent @toggleSideBar="toggleSideBar" />
            </div>
        </div>

        <!-- Menu -->
        <Transition>
            <div class="w-sidebar" v-if="sideBarVisible"></div>
        </Transition>

        <Transition>
            <div v-show="sideBarVisible" class="fixed h-full w-sidebar border-r border-[#2c2d33] overflow-y-auto">
                <LeftBarContent />
            </div>
        </Transition>

        <!-- Main -->
        <main class="w-full flex-1 bg-purple-300 main-content">
            <slot />
        </main>
    </div>
</template>

<script setup>
import HeaderContent from "./DefaultLayoutComponents/HeaderContent.vue";
import LeftBarContent from "./DefaultLayoutComponents/LeftBarContent.vue";

const props = defineProps([]);

const sideBarVisible = ref(true);
function toggleSideBar() {
    sideBarVisible.value = !sideBarVisible.value;
}
</script>

<style>
:root {
    --header-height: 60px;
    --sidebar-width: 240px;
}
</style>

<style scoped>
.w-header {
    width: calc(100% - var(--sidebar-width));
}

.h-header {
    height: var(--header-height);
}

.main-content {
    margin-top: var(--header-height);
}

.w-sidebar {
    width: var(--sidebar-width);
}

.transition-header {
    transition: all 0.2s;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

.v-enter-active,
.v-leave-active {
    transition: all 0.2s;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

.v-enter-from,
.v-leave-to {
    width: 0;
    overflow: hidden;
}
</style>
