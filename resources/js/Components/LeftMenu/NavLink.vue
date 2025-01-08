<template>
    <li>
        <Link :href="href">
            <a
                v-ripple
                class="p-ripple flex cursor-pointer items-center rounded px-4 py-2 text-surface-700 transition-colors duration-150 hover:bg-surface-100 dark:text-surface-0 dark:hover:bg-surface-800"
            >
                <i class="mr-2 text-lg" :class="icon"></i>
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
