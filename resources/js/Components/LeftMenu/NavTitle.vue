<template>
    <!-- Menu -->
    <ul class="list-none p-2 m-0">
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
                class="px-4 py-2 flex items-center justify-between text-surface-500 dark:text-surface-400 cursor-pointer p-ripple"
            >
                <i class="mr-2" :class="icon"></i>
                <span class="font-medium flex-grow">{{ label.toUpperCase() }}</span>
                <i class="mdi mdi-menu-down"></i>
            </div>
            <ul class="list-none p-0 m-0 overflow-hidden">
                <slot />
            </ul>
        </li>
    </ul>
</template>

<script setup>
const props = defineProps({
    label: {
        type: String,
        required: true,
    },
    icon: {
        type: String,
    },
    active: {
        type: Boolean,
    },
});
</script>
