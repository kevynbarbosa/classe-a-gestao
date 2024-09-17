<template>
    <li>
        <a
            v-ripple
            v-styleclass="{
                selector: '@next',
                enterFromClass: 'hidden',
                enterActiveClass: 'animate-slidedown',
                leaveToClass: 'hidden',
                leaveActiveClass: 'animate-slideup',
            }"
            class="flex items-center cursor-pointer px-4 py-2 rounded text-surface-700 hover:bg-surface-100 dark:text-surface-0 dark:hover:bg-surface-800 duration-150 transition-colors p-ripple"
        >
            <i class="mr-2" :class="icon"></i>
            <span class="font-medium">{{ label }}</span>
            <i class="mdi mdi-menu-down ml-auto"></i>
        </a>
        <ul class="list-none py-0 pl-4 pr-0 m-0 hidden overflow-y-hidden transition-all duration-[400ms] ease-in-out">
            <slot />
        </ul>
    </li>
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
});
</script>
