<template>
    <li>
        <Link :href="href">
            <a
                v-ripple
                class="flex items-center cursor-pointer px-4 py-2 rounded text-surface-700 hover:bg-surface-100 dark:text-surface-0 dark:hover:bg-surface-800 duration-150 transition-colors p-ripple"
            >
                <i class="mr-2" :class="icon"></i>
                <span class="font-medium">{{ label }}</span>
            </a>
        </Link>
    </li>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
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
