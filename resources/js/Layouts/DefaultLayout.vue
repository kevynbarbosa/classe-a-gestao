<template>
    <div class="flex min-h-screen surface-base">
        <!-- Header -->
        <div
            :class="[
                'fixed top-0 right-0 z-10 surface-layout transition-header',
                sideBarVisible ? 'w-header' : 'w-full',
            ]"
        >
            <div class="h-header p-4 pr-8 flex justify-between items-center text-[--p-drawer-color]">
                <HeaderContent @toggleSideBar="toggleSideBar" @toggleRightBar="toggleRightBar" />
            </div>
        </div>

        <!-- Left menuMenu -->
        <div class="hidden lg:block">
            <Transition>
                <div class="w-sidebar" v-if="sideBarVisible"></div>
            </Transition>

            <Transition>
                <div
                    v-show="sideBarVisible"
                    class="fixed h-full w-sidebar surface-layout border-r border-[--p-drawer-border-color] overflow-y-auto"
                >
                    <LeftBarContent />
                </div>
            </Transition>

            <!-- Left menu Mobile -->
            <Drawer v-if="windowWidth < 1024" v-model:visible="sideBarVisible" header="Menu">
                <template #container="{ closeCallback }">
                    <div class="h-full overflow-y-auto">
                        <LeftBarContent />
                    </div>
                </template>
            </Drawer>
        </div>

        <!-- Right Drawer -->
        <Drawer v-model:visible="rightBarVisible" header="Notificações" position="right">
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                ex ea commodo consequat.
            </p>
        </Drawer>

        <DynamicDialog />
        <Toast />

        <!-- Main -->
        <main class="w-full flex-1 main-content">
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

const rightBarVisible = ref(false);
function toggleRightBar() {
    rightBarVisible.value = !rightBarVisible.value;
}

const windowWidth = ref(window.innerWidth);
const updateWidth = () => {
    windowWidth.value = window.innerWidth;
};

onMounted(() => {
    window.addEventListener("resize", updateWidth);
});

onUnmounted(() => {
    window.removeEventListener("resize", updateWidth);
});
</script>

<style>
:root {
    --header-height: 60px;
    --sidebar-width: 240px;
    --ground-background: #ffff;
}
</style>

<style scoped>
.w-header {
    width: 100%;
}

@media (min-width: 1024px) {
    .w-header {
        width: calc(100% - var(--sidebar-width));
    }
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
