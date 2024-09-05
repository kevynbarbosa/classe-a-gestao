<template>
    <div class="p-4">
        <!-- Logo -->
        <img class="h-12 w-auto m-auto" src="assets/logo-with-text.png" alt="Logo" />

        <!-- Menu -->
        <ul class="list-none p-4 m-0">
            <li>
                <div
                    v-ripple
                    v-styleclass="{
                        selector: '@next',
                        enterFromClass: 'hidden',
                        enterActiveClass: 'animate-slidedown',
                        leaveToClass: 'hidden',
                        leaveActiveClass: 'animate-slideup',
                    }"
                    class="p-4 flex items-center justify-between text-surface-500 dark:text-surface-400 cursor-pointer p-ripple"
                >
                    <i class="mdi mdi-apple-safari"></i>
                    <span class="font-medium">APPLICATION</span>
                    <i class="mdi mdi-menu-down"></i>
                </div>
                <ul class="list-none p-0 m-0 overflow-hidden">
                    <li>
                        <a
                            v-ripple
                            class="flex items-center cursor-pointer p-4 rounded text-surface-700 hover:bg-surface-100 dark:text-surface-0 dark:hover:bg-surface-800 duration-150 transition-colors p-ripple"
                        >
                            <i class="mdi mdi-folder mr-2"></i>
                            <span class="font-medium">Projects</span>
                        </a>
                    </li>
                    <li>
                        <a
                            v-ripple
                            class="flex items-center cursor-pointer p-4 rounded text-surface-700 hover:bg-surface-100 dark:text-surface-0 dark:hover:bg-surface-800 duration-150 transition-colors p-ripple"
                        >
                            <i class="mdi mdi-chart-bar mr-2"></i>
                            <span class="font-medium">Performance</span>
                        </a>
                    </li>
                    <li>
                        <a
                            v-ripple
                            class="flex items-center cursor-pointer p-4 rounded text-surface-700 hover:bg-surface-100 dark:text-surface-0 dark:hover:bg-surface-800 duration-150 transition-colors p-ripple"
                        >
                            <i class="mdi mdi-cog mr-2"></i>
                            <span class="font-medium">Settings</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";

const props = defineProps([]);

const items = ref([
    {
        icon: "",
        route: "",
        label: "Item 1",
    },
    {
        icon: "",
        route: "",
        label: "Item 2",
    },
    {
        icon: "",
        route: "",
        label: "Item 3",
    },
    {
        icon: "",
        route: "",
        label: "Item 4",
    },
]);

onMounted(() => {
    // Mounted
});
</script>
